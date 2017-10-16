<?php
/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 * @copyright Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 * @link      http://susc.org.uk SUSC Website
 */

/**
 * Author: Huw
 * Since: 11/10/2017
 */

namespace SUSC\Controller\Component;


use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Core\Exception\Exception;
use Cake\ORM\TableRegistry;
use Psr\Log\LogLevel;
use SUSC\Controller\AppController;
use SUSC\Model\Table\MembershipsTable;
use ZipArchive;

/**
 * Class MembershipProcessComponent
 *
 * @package SUSC\Controller\Component
 * @property MembershipsTable $Memberships
 * @property AppController $Controller
 */
class MembershipProcessComponent extends Component
{

    public $components = ['Flash'];

    protected $_tempDir;
    protected $_memberships;
    protected $_date;
    protected $_zipFile;

    public function __construct(ComponentRegistry $registry, array $config = [])
    {
        $this->_zipFile = TMP . DS . 'membership' . DS; // php temp filename
        if (!file_exists($this->_zipFile)) {
            mkdir($this->_zipFile, 0777, true);
        }
        parent::__construct($registry, $config);
    }


    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->Controller = $this->getController();
        $this->Memberships = TableRegistry::get('Memberships');
    }


    /**
     * Creates the download zip from the date
     * @param $date string Date to snapshot membership
     */
    public function createDownload($date)
    {
        $this->_date = $date;
        $this->_tempDir = $this->_tempdir();
        //$this->_loadConfig();
        $this->_loadMemberships();
        $this->_processMemberships();

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
     * Loads the items that need processing from the database
     */
    protected function _loadMemberships()
    {
        $this->_memberships = $this->Memberships
            ->find('date', ['date' => $this->_date])
            ->where(['paid IS NOT NULL', 'is_cancelled' => false])
            ->order(['Memberships.last_name' => 'ASC', 'Memberships.first_name' => 'ASC']);
    }

    /**
     * Processes items
     */
    protected function _processMemberships()
    {
        $fileName = $this->_tempDir . DS . 'membership.csv';
        $file = fopen($fileName, 'w');
        $header = [
            'FirstName',
            'LastName',
            'StudentID',
            'Soton ID'
        ];
        fwrite($file, $this->csvgetstr($header) . "\r\n");

        if ($file === false) throw new Exception('Failed to open file. ' . $fileName);
        foreach ($this->_memberships as $member) {
            $data = [
                $member->first_name,
                $member->last_name,
                $member->student_id,
                $member->soton_id
            ];
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
     * Gets the full path of a the zip file for a given date
     *
     * @param string|null $date Date of Membership
     * @return string Full path to zip file
     */
    public function getZipFilePath($date = null)
    {
        if ($date == null) $date = $this->_date;
        return $this->_zipFile . $this->getZipFileName($date);
    }

    /**
     * Gets the zip file name from a date
     * @param string|null $date Date of Membership
     * @return string Zip File Name
     */
    public function getZipFileName($date = null)
    {
        if ($date == null) $date = $this->_date;
        return 'susc-membership-' . $date->format('Y-m-d') . '.zip';
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
     * @param int|null $date Date
     * @return bool
     */
    public function isDownloadExist($date = null)
    {
        if ($date == null) {
            $date = $this->_date;
        } elseif ($this->_date == null) {
            $this->_date = $date;
        };

        $file = $this->getZipFilePath($date);
        return file_exists($file);
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