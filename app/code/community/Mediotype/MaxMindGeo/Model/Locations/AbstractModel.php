<?php
/**
 * @ignore
 */
abstract class Mediotype_MaxMindGeo_Model_Locations_AbstractModel implements JsonSerializable
{
    protected $raw;

    /**
     * @ignore
     * Removed $raw
     */
    public function __construct(Array $params)
    {
        if(array_key_exists('raw',$params)){
            $this->raw = $params['raw'];
        } else{
            throw new Mediotype_Core_Exception('Failed to provide raw param in constructor');
        }
    }

    /**
     * @ignore
     */
    protected function get($field)
    {
        return isset($this->raw[$field]) ? $this->raw[$field] : null;
    }

    /**
     * @ignore
     */
    public function __get($attr)
    {
        if ($attr != "instance" && property_exists($this, $attr)) {
            return $this->$attr;
        }

        throw new RuntimeException("Unknown attribute: $attr");
    }

    /**
     * @ignore
     */
    public function __isset($attr)
    {
        return $attr != "instance" && isset($this->$attr);
    }

    public function jsonSerialize()
    {
        return $this->raw;
    }
}
