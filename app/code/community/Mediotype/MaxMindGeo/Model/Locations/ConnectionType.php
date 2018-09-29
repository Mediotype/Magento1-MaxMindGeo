<?php
/**
 * This class provides the GeoIP2 Connection-Type model.
 *
 * @property string $connectionType The connection type may take the following
 *     values: "Dialup", "Cable/DSL", "Corporate", "Cellular". Additional
 *     values may be added in the future.
 *
 * @property string $ipAddress The IP address that the data in the model is
 *     for.
 *
 */
class Mediotype_MaxMindGeo_Model_Locations_ConnectionType extends Mediotype_MaxMindGeo_Model_Locations_AbstractModel
{
    protected $connectionType;
    protected $ipAddress;

    /**
     * @ignore
     * Removed $raw
     */
    public function __construct(Array $params)
    {
        if(array_key_exists('raw', $params)){
        parent::__construct($params);
        } else {
            throw new Mediotype_Core_Exception('failed to provide raw param to constructor');
        }

        $this->connectionType = $this->get('connection_type');
        $this->ipAddress = $this->get('ip_address');
    }
}
