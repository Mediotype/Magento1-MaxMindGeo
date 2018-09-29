<?php
/**
 * Used for updating public DB (fallback from paid service)
 * Class Mediotype_InstantRebate_Adminhtml_GeoipController
 *
 * @author  Joel Hart
 */
class Mediotype_MaxMindGeo_Adminhtml_GeoipController extends Mage_Adminhtml_Controller_Action
{
    public function statusAction()
    {
        /** @var $session Mage_Core_Model_Session */
        $session = Mage::getSingleton('core/session');
        /** @var $info Mediotype_MaxMindGeo_Model_Info */
        $info = Mage::getModel('geoip/info');

        $realSize = filesize($info->getArchivePath());
        $totalSize = $session->getData('_geoip_file_size');
        echo $totalSize ? $realSize / $totalSize * 100 : 0;
    }

    public function synchronizeAction()
    {
        /** @var $info Mediotype_MaxMindGeo_Model_Info */
        $info = Mage::getModel('geoip/info');
        $info->update();
    }
}
