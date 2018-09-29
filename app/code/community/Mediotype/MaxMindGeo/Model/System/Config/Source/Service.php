<?php
/**
 * The level of lookup service being paid for via MaxMind API
 *
 * @author  Joel Hart
 */
class Mediotype_MaxMindGeo_Model_System_Config_Source_Service{

    const MAXMIND_API_LEVEL_COUNTRY     = 1;
    const MAXMIND_API_LEVEL_CITY        = 2;
    const MAXMIND_API_LEVEL_INSIGHTS    = 3;

    public function toOptionArray(){
        return array(
            array('value' => 1, 'label' => 'Country'),
            array('value' => 2, 'label' => 'City'),
            array('value' => 3, 'label'=> 'Insights'),
        );
    }

}