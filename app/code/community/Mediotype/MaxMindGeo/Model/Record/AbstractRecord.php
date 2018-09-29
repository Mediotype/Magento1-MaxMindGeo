<?php
/**
 * Refactored for Magento by Joel Hart <joel@mediotype.com>
 *
 */
abstract class Mediotype_MaxMindGeo_Model_Record_AbstractRecord implements JsonSerializable
{
    private $record;

    /**
     * @ignore
     * removed $record replaced w/ array
     */
    public function __construct(Array $params = array() )
    {
        if(array_key_exists('record', $params )){
            $this->record = isset($params['record']) ? $params['record'] : array();
        } else {
            throw new Mediotype_Core_Exception('Failed to provide record key in params array for MaxMind Record Model');
        }
    }

    /**
     * @ignore
     */
    public function __get($attr)
    {
        // XXX - kind of ugly but greatly reduces boilerplate code
        $key = $this->attributeToKey($attr);

        if ($this->__isset($attr)) {
            return $this->record[$key];
        } elseif ($this->validAttribute($attr)) {
            return null;
        } else {
            throw new RuntimeException("Unknown attribute: $attr");
        }
    }

    public function __isset($attr)
    {
        return $this->validAttribute($attr) &&
             isset($this->record[$this->attributeToKey($attr)]);
    }

    private function attributeToKey($attr)
    {
        return strtolower(preg_replace('/([A-Z])/', '_\1', $attr));
    }

    private function validAttribute($attr)
    {
        return in_array($attr, $this->validAttributes);
    }

    public function jsonSerialize()
    {
        return $this->record;
    }
}
