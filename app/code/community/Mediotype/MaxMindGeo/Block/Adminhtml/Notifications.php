<?php
/**
 * @author  Joel Hart
 */
class Mediotype_MaxMindGeo_Block_Adminhtml_Notifications extends Mage_Adminhtml_Block_Template
{
    public function checkFilePermissions()
    {
        /** @var $info Mediotype_MaxMindGeo_Model_Info */
        $info = Mage::getModel('geoip/info');
        return $info->checkFilePermissions();
    }
}
