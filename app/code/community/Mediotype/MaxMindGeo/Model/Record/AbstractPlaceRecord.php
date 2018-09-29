<?php

/**
 * Refactored for Magento by Joel Hart  <joel@mediotype.com>
 *
 */
abstract class Mediotype_MaxMindGeo_Model_Record_AbstractPlaceRecord extends Mediotype_MaxMindGeo_Model_Record_AbstractRecord
{
    private $locales;

    /**
     * @ignore
     * Removed  $record, $locales = array('en')
     */
    public function __construct(Array $params)
    {
        if ( array_key_exists('record', $params) && array_key_exists('locales', $params)) {
            $this->locales = $params['locales'];
            parent::__construct($params);
        } else {
            throw new Mediotype_Core_Exception('failed to provide records or locales params for constructor');
        }
    }

    /**
     * @ignore
     */
    public function __get($attr)
    {
        if ($attr == 'name') {
            return $this->name();
        } else {
            return parent::__get($attr);
        }
    }

    private function name()
    {
        foreach ($this->locales as $locale) {
            if (isset($this->names[$locale])) {
                return $this->names[$locale];
            }
        }
    }
}
