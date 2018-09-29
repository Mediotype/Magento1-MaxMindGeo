<?php
/**
 *
 *
 * @author  Joel Hart
 */
class Mediotype_MaxMindGeo_Model_Cron
{
    public function run()
    {
        /** @var $info Mediotype_MaxMindGeo_Model_Info */
        $info = Mage::getModel('geoip/info');
        $info->update();
    }
}