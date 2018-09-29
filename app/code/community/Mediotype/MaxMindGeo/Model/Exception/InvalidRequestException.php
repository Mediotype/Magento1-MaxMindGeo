<?php
/**
 * This class represents an error returned by MaxMind's GeoIP2
 * web service.
 */
class Mediotype_InstantRebate_Model_Geo_Exception_InvalidRequestException extends Mediotype_MaxMindGeo_Model_Exception_GeoIp2Exception
{
    /**
     * The code returned by the MaxMind web service
     */
    public $error;

    public function __construct(
        $message,
        $error,
        $httpStatus,
        $uri,
        Exception $previous = null
    ) {
        $this->error = $error;
        parent::__construct($message, $httpStatus, $uri, $previous);
    }
}
