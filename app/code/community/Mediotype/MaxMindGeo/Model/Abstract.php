<?php
/**
 * //TODO add other public DB's to remote archive list && TODO Integrate with live API
 * @author  Joel Hart
 */
class Mediotype_MaxMindGeo_Model_Abstract
{
    protected $localDir, $localFile, $localArchive, $remoteArchive;

    protected $helper;

    public function __construct()
    {
        $this->helper = Mage::helper('geoip');
        $this->localDir = $this->helper->getModuleDataDir();
        $this->localFile = $this->localDir . DS . 'GeoIP.dat';
        $this->localArchive =  $this->localDir . DS . 'GeoIP.dat.gz';
        $this->remoteArchive = 'http://www.maxmind.com/download/geoip/database/GeoLiteCountry/GeoIP.dat.gz';
    }

    public function getArchivePath()
    {
        return $this->localArchive;
    }

    public function checkFilePermissions()
    {
        /** @var $helper Mediotype_Core_Helper_File */
        $helper = Mage::helper('mediotype_core/file');

        $dir = $this->localDir;
        if (file_exists($dir)) {
            if (!is_dir($dir)) {
                return sprintf($helper->__('%s exists but it is file, not dir.'), 'var/' . $this->localDir);
            } elseif ((!file_exists($this->localFile) || !file_exists($this->localArchive)) && !is_writable($dir)) {
                return sprintf($helper->__('%s exists but files are not and directory is not writable.'), 'var/' . $this->localDir);
            } elseif (file_exists($this->localFile) && !is_writable($this->localFile)) {
                return sprintf($helper->__('%s is not writable.'), 'var/' . $this->localDir . '/GeoIP.dat');
            } elseif (file_exists($this->localArchive) && !is_writable($this->localArchive)) {
                return sprintf($helper->__('%s is not writable.'), 'var/' . $this->localDir . '/GeoIP.dat.gz');
            }
        } elseif (!@mkdir($dir)) {
            return  sprintf($helper->__('Can\'t create %s directory.'), $this->localDir);
        }

        return '';
    }

    public function update(){
        /** @var $helper Mediotype_Core_Helper_File */
        $helper = Mage::helper('mediotype_core/file');

        $ret = array('status' => 'error');

        if ($permissionsError = $this->checkFilePermissions()) {
            $ret['message'] = $permissionsError;
        } else {
            $remoteFileSize = $helper->getSize($this->remoteArchive);
            if ($remoteFileSize < 100000) {
                $ret['message'] = $helper->__('You are banned from downloading the file. Please try again in several hours.');
            } else {
                /** @var $session Mage_Core_Model_Session */
                $session = Mage::getSingleton('core/session');
                $session->setData('_geoip_file_size', $remoteFileSize);

                $src = fopen($this->remoteArchive, 'r');
                $target = fopen($this->localArchive, 'w');
                stream_copy_to_stream($src, $target);
                fclose($target);

                if (filesize($this->localArchive)) {
                    if ($helper->unGZip($this->localArchive, $this->localFile)) {
                        $ret['status'] = 'success';
                        $format = Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
                        $ret['date'] = Mage::app()->getLocale()->date(filemtime($this->localFile))->toString($format);
                    } else {
                        $ret['message'] = $helper->__('UnGzipping failed');
                    }
                } else {
                    $ret['message'] = $helper->__('Download failed.');
                }
            }
        }

        echo json_encode($ret);
    }
}