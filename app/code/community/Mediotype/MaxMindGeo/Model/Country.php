<?php
/**
 *
 *
 * @author  Joel Hart
 */
class Mediotype_MaxMindGeo_Model_Country extends Mediotype_MaxMindGeo_Model_Abstract
{
    private $country;
    private $allowedCountries = array();
    /** @var $helper Mediotype_MaxMindGeo_Helper_Data */
    protected $helper;

    public function __construct()
    {
        parent::__construct();

        /** @var $this->helper Mediotype_MaxMindGeo_Helper_Data */
        $this->helper = Mage::helper('geoip');
        $this->country = $this->getCountryByIp(Mage::helper('core/http')->getRemoteAddr());
        $allowCountries = explode(',', $this->helper->getConfigAllowCountries());
        $this->addAllowedCountry($allowCountries);
    }

    public function getCountryByIp($ip)
    {
        /** @var $wrapper Mediotype_MaxMindGeo_Model_Wrapper */
        $wrapper = Mage::getSingleton('geoip/wrapper');
        if ($wrapper->geoip_open($this->localFile, 0)) {
            $country = $wrapper->geoip_country_code_by_addr($ip);
            $wrapper->geoip_close();

            return $country;
        } else {
            return null;
        }
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function isCountryAllowed($country = '')
    {
        $country = $country ? $country : $this->country;
        if (count($this->allowedCountries) && $country) {
            return in_array($country, $this->allowedCountries);
        } else {
            return true;
        }
    }

    public function addAllowedCountry($countries)
    {
        $countries = is_array($countries) ? $countries : array($countries);
        $this->allowedCountries = array_merge($this->allowedCountries, $countries);

        return $this;
    }
}