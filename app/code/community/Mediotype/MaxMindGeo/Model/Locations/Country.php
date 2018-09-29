<?php
/**
 * Model class for the data returned by GeoIP2 Country web service and database.
 *
 * The only difference between the City and Insights model classes is which
 * fields in each record may be populated. See
 * http://dev.maxmind.com/geoip/geoip2/web-services more details.
 *
 * @property \GeoIp2\Record\Continent $continent Continent data for the
 * requested IP address.
 *
 * @property \GeoIp2\Record\Country $country Country data for the requested
 * IP address. This object represents the country where MaxMind believes the
 * end user is located.
 *
 * @property \GeoIp2\Record\MaxMind $maxmind Data related to your MaxMind
 * account.
 *
 * @property \GeoIp2\Record\Country $registeredCountry Registered country
 * data for the requested IP address. This record represents the country
 * where the ISP has registered a given IP block and may differ from the
 * user's country.
 *
 * @property \GeoIp2\Record\RepresentedCountry $representedCountry
 * Represented country data for the requested IP address. The represented
 * country is used for things like military bases. It is only present when
 * the represented country differs from the country.
 *
 * @property \GeoIp2\Record\Traits $traits Data for the traits of the
 * requested IP address.
 */
class Mediotype_MaxMindGeo_Model_Locations_Country extends Mediotype_MaxMindGeo_Model_Locations_AbstractModel
{
    protected $continent;
    protected $country;
    protected $locales;
    protected $maxmind;
    protected $registeredCountry;
    protected $representedCountry;
    protected $traits;

    /**
     * @ignore
     */
    public function __construct(Array $params)
    {
        if(!array_key_exists('locales',$params)){
            $params['locales'] = array('en');
        }
        $raw = $params['raw'];
        $locales = $params['locales'];

        parent::__construct($params);

        $this->continent = Mage::getModel('geoip/Record_Continent', array( // new \GeoIp2\Record\Continent(
            'record' => $this->get('continent'),
            'locales' => $locales
        ));
        $this->country = Mage::getModel('geoip/Record_Country', array( // new \GeoIp2\Record\Country(
            'record' => $this->get('country'),
            'locales' => $locales
        ));
        $this->maxmind = Mage::getModel('geoip/Record_MaxMind', array('record' => 'maxmind' ));  // new \GeoIp2\Record\MaxMind($this->get('maxmind'));
        $this->registeredCountry = Mage::getModel('geoip/Record_Country', array(  // new \GeoIp2\Record\Country(
            'record' => $this->get('registered_country'),
            'locales' => $locales
        ));
        $this->representedCountry = Mage::getModel('geoip/Record_RepresentedCountry', array( // new \GeoIp2\Record\RepresentedCountry(
            'record' => $this->get('represented_country'),
            'locales' => $locales
        ));
        $this->traits = Mage::getModel('geoip/Record_Traits', array('record' => 'traits'));  // new \GeoIp2\Record\Traits($this->get('traits'));

        $this->locales = $locales;
    }
}
