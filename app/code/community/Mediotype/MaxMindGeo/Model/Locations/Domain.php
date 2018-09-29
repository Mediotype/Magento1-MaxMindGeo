<?php
/**
 * This class provides the GeoIP2 Domain model.
 *
 * @property string $domain The second level domain associated with the IP
 *     address. This will be something like "example.com" or "example.co.uk",
 *     not "foo.example.com".
 *
 * @property string $ipAddress The IP address that the data in the model is
 *     for.
 *
 */
class Mediotype_MaxMindGeo_Model_Locations_Domain extends Mediotype_MaxMindGeo_Model_Locations_AbstractModel
{
    protected $domain;
    protected $ipAddress;

    /**
     * @ignore
     * Removed $raw
     */
    public function __construct($params)
    {
        if(array_key_exists('raw', $params)){
            parent::__construct($params);
        } else {
            throw new Mediotype_Core_Exception('failed to provide raw param to constructor');
        }

        $this->domain = $this->get('domain');
        $this->ipAddress = $this->get('ip_address');
    }
}
