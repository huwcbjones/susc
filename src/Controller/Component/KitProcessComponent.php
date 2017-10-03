<?php

namespace SUSC\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\Component\FlashComponent;
use Cake\Controller\ComponentRegistry;
use Cake\Core\Exception\Exception;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Psr\Log\LogLevel;
use SUSC\Controller\AppController;
use SUSC\Model\Entity\Config;
use SUSC\Model\Entity\ItemsOrder;
use SUSC\Model\Entity\ProcessedOrder;
use SUSC\Model\Table\ConfigTable;
use SUSC\Model\Table\ItemsOrdersTable;
use SUSC\Model\Table\ItemsTable;
use SUSC\Model\Table\OrdersTable;
use SUSC\Model\Table\ProcessedOrdersTable;
use ZipArchive;

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

    protected $_batchID;
    protected $_tempDir;
    protected $_items;
    protected $_configMap;
    protected $_saveDir;

    public function __construct(ComponentRegistry $registry, array $config = [])
    {
        $this->_saveDir = WWW_ROOT . 'docs' . DS . 'kit-orders' . DS;
        parent::__construct($registry, $config);
    }


    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->Controller = $this->getController();
        $this->ItemsOrders = TableRegistry::get('ItemsOrders');
        $this->ProcessedOrders = TableRegistry::get('ProcessedOrders');
        $this->Config = TableRegistry::get('Config');
    }


    /**
     * Creates the download zip from the batch ID
     * @param $batchID integer Batch to process
     */
    public function createDownload($batchID)
    {
        $this->_batchID = $batchID;
        $this->_tempDir = $this->_tempdir();
        $this->_loadConfig();
        $this->_loadItems();
        $this->_processItems();

        $this->_compressData();
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
            $this->log("tempdir: " . $tempfile, LogLevel::DEBUG);
            return $tempfile;
        }
        return false;
    }

    /**
     * Loads the config from the database
     */
    protected function _loadConfig()
    {
        $config = $this->Config->find()->where(["`key` LIKE 'kit-orders.%'"])->toArray();

        /** @var Config $conf */
        foreach ($config as $conf) {
            if ($conf->value === null) continue;
            $this->_configMap[$conf->value] = str_replace('kit-orders.', '', $conf->key);
        }
    }

    /**
     * Loads the items that need processing from the database
     */
    protected function _loadItems()
    {
        /** @var ProcessedOrder $batch */
        $batch = $this->ProcessedOrders->find('assoc')->where(['id' => $this->_batchID])->firstOrFail();
        $items = [];
        foreach ($batch->items_orders as $item) {
            try {
                /** * @var Config $configItem */
                if (!array_key_exists($item->item_id, $this->_configMap)) {
                    $this->_configMap[$item->item_id] = $item->item->slug;
                };
                $items[$this->_configMap[$item->item_id]][] = $item;
            } catch (RecordNotFoundException $ex) {

            }
        }
        $this->_items = $items;
    }

    /**
     * Processes items
     */
    protected function _processItems()
    {
        foreach ($this->_items as $fileName => $item) {
            if ($item == null) continue;
            $this->_processItem($fileName, $item);
        }
    }

    /**
     * Processes each item
     *
     * @param $fileName string filename of item
     * @param ItemsOrder[] $items Items to include in file
     */
    protected function _processItem($fileName, array $items)
    {
        $fileName = $this->_tempDir . DS . $fileName . '.csv';
        $file = fopen($fileName, 'w');
        $header = [
            'FirstName',
            'LastName',
            'Size',
            'Quantity'
        ];
        if ($items[0]->additional_info) {
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

    /**
     * Compresses the temporary csv files into a zip
     */
    protected function _compressData()
    {
        $zipFile = $this->getZipFilePath();
        $zipArchive = new ZipArchive();

        $result = $zipArchive->open($zipFile, ZipArchive::CREATE);
        if ($result !== true) throw new Exception('Failed to create file. Code: ' . $result);
        $zipArchive->addGlob($this->_tempDir . DS . '*.{csv}', GLOB_BRACE, ['remove_all_path' => true]);

        if (!$zipArchive->status == ZipArchive::ER_OK) throw new Exception('Failed to create file.');

        $zipArchive->close();
    }

    /**
     * Gets the full path of a the zip file for a given batch ID
     *
     * @param string|null $batchID Batch ID
     * @return string Full path to zip file
     */
    public function getZipFilePath($batchID = null)
    {
        if ($batchID == null) $batchID = $this->_batchID;
        return $this->_saveDir . $this->getZipFileName($batchID);
    }

    /**
     * Gets the zip file name from a batch ID
     * @param string|null $batchID Batch ID
     * @return string Zip File Name
     */
    public function getZipFileName($batchID = null)
    {
        if ($batchID == null) $batchID = $this->_batchID;
        return 'susc-kit-order-' . $batchID . '.zip';
    }

    /**
     * Cleans up after processing
     */
    protected function _cleanUp()
    {
        $this->rrmdir($this->_tempDir);
    }

    /**
     * Recursively removes a directory
     * @param string $dir directory to remove
     */
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

    /**
     * Returns whether a download exists for a batch or not
     *
     * @param int|null $batchID Batch ID
     * @return bool
     */
    public function isDownloadExist($batchID = null)
    {
        if ($batchID == null) {
            $batchID = $this->_batchID;
        } elseif ($this->_batchID == null) {
            $this->_batchID = $batchID;
        };

        $file = $this->getZipFilePath($batchID);
        return file_exists($file);
    }

    /**
     * Processes a batch of items
     */
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