<?php
/**
 *  This class represents an HTTP transport error.
 */

class Mediotype_MaxMindGeo_Model_Exception_HttpException extends Mediotype_MaxMindGeo_Model_Exception_GeoIp2Exception
{
    /**
     * The URI queried
     */
    public $uri;

    public function __construct(
        $message,
        $httpStatus,
        $uri,
        Exception $previous = null
    ) {
        $this->uri = $uri;
        parent::__construct($message, $httpStatus, $previous);
    }
}
