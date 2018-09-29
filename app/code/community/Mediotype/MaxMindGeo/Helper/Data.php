<?php
/**
 * @author  Joel Hart   <joel@mediotype.com>
 */
class Mediotype_MaxMindGeo_Helper_Data extends Mage_Core_Helper_Abstract
{


    const CONFIG_PATH_MAGENTO_ALLOW_COUNTRIES = 'general/country/allow';

    const CONFIG_PATH_GEOIP_ACTIVE = "instant_rebate_config/general/active";
    const CONFIG_PATH_GEOIP_STATUS = "geoip_config/general/geoip_status";
    const CONFIG_PATH_GEOIP_SYNCHRONIZE = "geoip_config/general/geoip_synchronize";

    const CONFIG_PATH_GEOIP_USER = "geoip_config/general/maxmind_user";
    const CONFIG_PATH_GEOIP_LICENSEKEY = "geoip_config/general/maxmind_licensekey";
    const CONFIG_PATH_GEOIP_SERVICE = "geoip_config/general/maxmind_api_level";

    /**
     * Gets Magento Store Allowed Countries Config
     *
     */
    public function getConfigAllowCountries()
    {
        return (string)Mage::getStoreConfig(self::CONFIG_PATH_MAGENTO_ALLOW_COUNTRIES);
    }

    public function getModuleDataDir()
    {
        return (string)Mage::getModuleDir('data', 'Mediotype_MaxMindGeo');
    }

    /**
     * @param $ip  String Valid IP address, or defaults to local ip (request origin)
     * @returns Mediotype_MaxMindGeo_Model_Locations_Insights | Mediotype_MaxMindGeo_Model_Locations_Country | Mediotype_MaxMindGeo_Model_Locations_City
     */
    public function lookUpIp($ip = 'me')
    {

        $authArray = array(
            'userId' => Mage::helper('core')->decrypt(Mage::getStoreConfig(self::CONFIG_PATH_GEOIP_USER)),
            'licenseKey' => Mage::helper('core')->decrypt(Mage::getStoreConfig(self::CONFIG_PATH_GEOIP_LICENSEKEY)),
        );

        /** @var Mediotype_MaxMindGeo_Model_WebService_Client $client */
        $client = Mage::getModel('geoip/WebService_Client', $authArray);

        $serviceLevel = Mage::getStoreConfig(self::CONFIG_PATH_GEOIP_SERVICE);

        $response = false;

        try {
            switch ($serviceLevel) {
                case Mediotype_MaxMindGeo_Model_System_Config_Source_Service::MAXMIND_API_LEVEL_INSIGHTS:
                    $response = $client->insights($ip);
                    break;
                case Mediotype_MaxMindGeo_Model_System_Config_Source_Service::MAXMIND_API_LEVEL_COUNTRY:
                    $response = $client->country($ip);
                    break;
                case Mediotype_MaxMindGeo_Model_System_Config_Source_Service::MAXMIND_API_LEVEL_CITY:
                    $response = $client->city($ip);
                    break;
                default:
                    throw new Mediotype_Core_Exception('please set a service level for the MaxMind extension');
                    break;
            }
        } catch (Exception $e) {
            Mage::logException($e);
            //todo fail back to local db if response failure
        }

        return $response;
    }

}