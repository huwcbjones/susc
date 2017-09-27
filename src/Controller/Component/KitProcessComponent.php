<?php

namespace SUSC\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\Component\FlashComponent;
use Cake\Core\Exception\Exception;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\I18n\Time;
use Cake\ORM\ResultSet;
use Cake\ORM\TableRegistry;
use SUSC\Controller\AppController;
use SUSC\Model\Entity\Config;
use SUSC\Model\Entity\ItemsOrder;
use SUSC\Model\Table\ConfigTable;
use SUSC\Model\Table\ItemsOrdersTable;
use SUSC\Model\Table\ItemsTable;
use SUSC\Model\Table\OrdersTable;
use SUSC\Model\Table\ProcessedOrdersTable;

/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 * @copyright Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 * @link      http://susc.org.uk SUSC Website
 *
 * @property FlashComponent $Flash
 * @property ItemsOrdersTable $ItemsOrders
 * @property OrdersTable $Orders
 * @property ConfigTable $Config
 * @property ItemsTable $Items
 * @property ProcessedOrdersTable $ProcessedOrders
 * @property AppController $Controller
 */
class KitProcessComponent extends Component
{

    public $components = ['Flash'];

    protected $_tempDir;
    protected $_items;


    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->Controller = $this->getController();
        $this->ItemsOrders = TableRegistry::get('ItemsOrders');
        $this->ProcessedOrders = TableRegistry::get('ProcessedOrders');
        $this->Config = TableRegistry::get('Config');
    }


    public function createDownload()
    {
        $this->_tempDir = $this->_tempdir();
        $this->_loadItems();
        if (count($this->_items)) {
            $this->Flash->error('Could no process orders. No orders to process (you are up to date!)');
        }
        $this->_processItems();

        $this->_compressData();
        $this->_saveItems();
        $this->_cleanUp();
    }

    /**
     * Creates a temporary directory
     * @return bool|string
     */
    protected function _tempdir()
    {
        $tempfile = tempnam(sys_get_temp_dir(), '');
        // you might want to reconsider this line when using this snippet.
        // it "could" clash with an existing directory and this line will
        // try to delete the existing one. Handle with caution.
        if (file_exists($tempfile)) {
            unlink($tempfile);
        }
        mkdir($tempfile);
        if (is_dir($tempfile)) {
            return $tempfile;
        }
        return false;
    }

    protected function _loadItems()
    {
        $all_items = $this->Items->find('unprocessed')->all();
        $items = [];
        foreach ($all_items as $item) {
            try {
                /** * @var Config $configItem */
                $configItem = $this->Config->find('value', ['value' => $item->id])->firstOrFail();
                $itemsOrders = $this->ItemsOrders
                    ->find('itemId', ['id' => $item->id])
                    ->find('unprocessed')->all();
                $items[str_replace('kit-orders.', '', $configItem->key)] = $itemsOrders;
            } catch (RecordNotFoundException $ex) {

            }
        }
        $this->_items = $items;
    }

    protected function _processItems()
    {
        foreach ($this->_items as $fileName => $item) {
            if ($item == null) continue;
            $this->_processItem($fileName, $item);
        }
    }

    protected function _processItem($fileName, ResultSet $items)
    {
        $items = $items->toArray();
        /** @var ItemsOrder[] $items */
        $fileName = $this->_tempDir . DS . $fileName . '.csv';
        $file = fopen($fileName, 'w');
        $header = [
            'FirstName',
            'LastName',
            'Size',
            'Quantity'
        ];
        if ($items[0]->item->additional_info) {
            array_splice($header, 2, 0, 'Initials');
        }
        fwrite($file, $this->csvgetstr($header) . "\r\n");

        if ($file === false) throw new Exception('Failed to open file. ' . $fileName);
        foreach ($items as $order) {
            $data = [
                $order->order->user->first_name,
                $order->order->user->last_name,
                $order->size,
                $order->quantity
            ];
            if ($order->item->additional_info) {
                array_splice($data, 2, 0, [$order->additional_info]);
            }
            fwrite($file, $this->csvgetstr($data) . "\r\n");
        }
        fclose($file);
    }

    /**
     * Converts a 1-dimensional array to a CSV string
     * @param $array array to convert
     * @param string $delim Deliminator to separate fields
     * @return string
     */
    function csvgetstr(array $array, $delim = ",")
    {
        $string = '';
        if (count($array) != 0) {
            foreach ($array as $k => $v) {
                $string .= $v . ',';
            }
            $string = rtrim($string, ',');
        }
        return $string;
    }

    protected function _compressData()
    {
        $zipFile = WWW_ROOT . 'docs' . DS . 'kit-orders' . DS . 'susc-kit-order-' . date('Ymd-Hi') . '.zip';
        $zipArchive = new \ZipArchive();

        $result = $zipArchive->open($zipFile, \ZipArchive::CREATE);
        if ($result !== true) throw new Exception('Failed to create file. Code: ' . $result);
        $zipArchive->addGlob($this->_tempDir . DS . '*.{csv}', GLOB_BRACE, ['remove_all_path' => true]);

        if (!$zipArchive->status == \ZipArchive::ER_OK) throw new Exception('Failed to create file.');

        $zipArchive->close();
    }

    protected function _saveItems()
    {
        $now = new Time();
        $this->ItemsOrders->getConnection()->transactional(function () use ($now) {
            foreach ($this->_items as $item) {
                foreach ($item as $items) {
                    $items->ordered = $now;
                    $this->ItemsOrders->saveOrFail($items);
                }
            }
        });
    }

    protected function _cleanUp()
    {
        $this->rrmdir($this->_tempdir());
    }

    function rrmdir($dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (is_dir($dir . "/" . $object))
                        $this->rrmdir($dir . "/" . $object);
                    else
                        unlink($dir . "/" . $object);
                }
            }
            rmdir($dir);
        }
    }

    public function process()
    {
        /** @var ItemsOrder[] $items */
        $items = $this->ItemsOrders->find('unprocessed')->toArray();
        if (count($items) === 0) {
            $this->Flash->success('No orders to process (you are up to date!)');
            return;
        }

        $now = new Time();
        $order = $this->ProcessedOrders->newEntity([
            'user_id' => $this->Controller->currentUser->id,
            'ordered' => NULL,
            'created' => $now
        ]);

        $this->ProcessedOrders->saveOrFail($order);

        foreach ($items as &$item) {
            $item->processed_order_id = $order->id;
        }

        $save = $this->ItemsOrders->saveMany($items);
        if ($save !== false) {
            $this->Flash->success('Batch processed!');
        } else {
            $this->Flash->error('Failed to save batch!)');
        }

    }

    /**
     * Converts a CSV String to an Array
     * @param $string String to convert
     * @param string $delim Deliminator
     * @param bool $filter Set true to remove blank values from the output array
     * @return array
     */
    function strgetcsv($string, $delim = ",", $filter = true)
    {
        if ($string == "") {
            return [];
        }
        $csv = [];
        $csvprelim = str_getcsv($string, $delim);
        if ($filter) {
            $csv = array_filter($csvprelim, function ($item) {
                return $item != "";
            });
        }
        return array_values($csv);
    }

}