<?php

/**
 * Model class for the data returned by GeoIP2 City web service and database.
 *
 * The only difference between the City and Insights model classes is which
 * fields in each record may be populated. See
 * http://dev.maxmind.com/geoip/geoip2/web-services more details.
 *
 * @property \GeoIp2\Record\City $city City data for the requested IP
 * address.
 *
 * @property \GeoIp2\Record\Continent $continent Continent data for the
 * requested IP address.
 *
 * @property \GeoIp2\Record\Country $country Country data for the requested
 * IP address. This object represents the country where MaxMind believes the
 * end user is located.
 *
 * @property \GeoIp2\Record\Location $location Location data for the
 * requested IP address.
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
 * @property array $subdivisions An array of {@link \GeoIp2\Record\Subdivision}
 * objects representing the country subdivisions for the requested IP
 * address. The number and type of subdivisions varies by country, but a
 * subdivision is typically a state, province, county, etc. Subdivisions
 * are ordered from most general (largest) to most specific (smallest).
 * If the response did not contain any subdivisions, this method returns
 * an empty array.
 *
 * @property \GeoIp2\Record\Subdivision $mostSpecificSubdivision An  object
 * representing the most specific subdivision returned. If the response
 * did not contain any subdivisions, this method returns an empty
 * {@link \GeoIp2\Record\Subdivision} object.
 *
 * @property \GeoIp2\Record\Traits $traits Data for the traits of the
 * requested IP address.
 */
class Mediotype_MaxMindGeo_Model_Locations_City extends Mediotype_MaxMindGeo_Model_Locations_Country
{
    /**
     * @ignore
     */
    protected $city;
    /**
     * @ignore
     */
    protected $location;
    /**
     * @ignore
     */
    protected $postal;
    /**
     * @ignore
     */
    protected $subdivisions = array();

    /**
     * @ignore
     */
    public function __construct(Array $params = array())
    {

        if ( !array_key_exists('locales', $params ) ){
            $params['locales'] = array('en');
        }
        $raw = $params['raw'];
        $locales = $params['locales'];

        parent::__construct($params);

        $this->city = Mage::getModel('geoip/Record_City', array('record' => $this->get('city'), 'locales' => $locales));
        $this->location = Mage::getModel('geoip/Record_Location', array('record' => $this->get('location'), 'locales' => $locales));
        $this->postal = Mage::getModel('geoip/Record_Postal', array('record' => $this->get('postal')));

        $this->createSubdivisions($raw, $locales);
    }

    private function createSubdivisions($raw, $locales)
    {
        if (!isset($raw['subdivisions'])) {
            return;
        }

        foreach ($raw['subdivisions'] as $sub) {
            array_push(
                $this->subdivisions,
                Mage::getModel('geoip/Record_Subdivision', array('record' => $sub, 'locales' => $locales))
            );
        }
    }

    /**
     * @ignore
     */
    public function __get($attr)
    {
        if ($attr == 'mostSpecificSubdivision') {
            return $this->$attr();
        } else {
            return parent::__get($attr);
        }
    }

    private function mostSpecificSubdivision()
    {
        return empty($this->subdivisions) ?
            Mage::getModel('geoip/Record_Subdivision', array('record' => array(), 'locales' => $this->locales)) :
            end($this->subdivisions);
    }
}
