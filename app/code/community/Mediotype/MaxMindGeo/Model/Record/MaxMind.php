<?php
/**
 * Contains data about your account.
 *
 * This record is returned by all the end points.
 *
 * @property int $queriesRemaining The number of remaining queries you have
 * for the end point you are calling.
 */
class Mediotype_MaxMindGeo_Model_Record_MaxMind extends Mediotype_MaxMindGeo_Model_Record_AbstractRecord
{
    /**
     * @ignore
     */
    protected $validAttributes = array('queriesRemaining');
}
