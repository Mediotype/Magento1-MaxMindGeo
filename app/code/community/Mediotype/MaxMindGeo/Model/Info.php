<?php

/**
 * Info about file
 *
 * @author  Joel Hart
 * Class Sandfox_GeoIP_Model_Info
 */
class Mediotype_MaxMindGeo_Model_Info extends Mediotype_MaxMindGeo_Model_Abstract
{
    public function getDatFileDownloadDate()
    {
        return file_exists($this->localFile) ? filemtime($this->localFile) : 0;
    }
}