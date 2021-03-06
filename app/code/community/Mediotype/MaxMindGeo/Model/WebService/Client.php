<?php
/**
 * This class provides a client API for all the GeoIP2 Precision web service
 * end points. The end points are Country, City, and Insights. Each end point
 * returns a different set of data about an IP address, with Country returning
 * the least data and Insights the most.
 *
 * Each web service end point is represented by a different model class, and
 * these model classes in turn contain multiple Record classes. The record
 * classes have attributes which contain data about the IP address.
 *
 * If the web service does not return a particular piece of data for an IP
 * address, the associated attribute is not populated.
 *
 * The web service may not return any information for an entire record, in
 * which case all of the attributes for that record class will be empty.
 *
 * **Usage**
 *
 * The basic API for this class is the same for all of the web service end
 * points. First you create a web service object with your MaxMind
 * <code>$userId</code> and <code>$licenseKey</code>, then you call the method
 * corresponding to a specific end point, passing it the IP address you want
 * to look up.
 *
 * If the request succeeds, the method call will return a model class for
 * the end point you called. This model in turn contains multiple record
 * classes, each of which represents part of the data returned by the web
 * service.
 *
 * If the request fails, the client class throws an exception.
 */
class Mediotype_MaxMindGeo_Model_WebService_Client implements Mediotype_MaxMindGeo_Model_ProviderInterface
{
    private $userId;
    private $licenseKey;
    private $locales;
    private $host;
    private $guzzleClient;

    /**
     * Constructor.
     *
     * @param int $userId Your MaxMind user ID
     * @param string $licenseKey Your MaxMind license key
     * @param array $locales List of locale codes to use in name property
     * from most preferred to least preferred.
     * @param string $host Optional host parameter
     * @param object $guzzleClient Optional Guzzle client to use (to facilitate
     * unit testing).
     *
     * Removed
     *
     * $userId,
     * $licenseKey,
     * $locales = array('en'),
     * $host = 'geoip.maxmind.com',
     * $guzzleClient = null
     */
    public function __construct(
        Array $params = array()
    )
    {
        $this->userId = $params['userId'];
        $this->licenseKey = $params['licenseKey'];
        if(array_key_exists('locales', $params)){
            $this->locales = $params['locales'];
        } else {
            $this->locales = array('en');
        }
        if(array_key_exists('host', $params)){
            $this->host = $params['host'];
        } else {
            $this->host = 'geoip.maxmind.com';
        }
        // To enable unit testing
        if (array_key_exists('guzzleClient', $params)) {
            $this->guzzleClient = $params['guzzleClient'];
        } else {
            $this->guzzleClient = null;
        }
    }

    /**
     * This method calls the GeoIP2 Precision: City endpoint.
     *
     * @param string $ipAddress IPv4 or IPv6 address as a string. If no
     * address is provided, the address that the web service is called
     * from will be used.
     *
     * @return \GeoIp2\Model\City
     *
     * @throws \GeoIp2\Exception\AddressNotFoundException if the address you
     *   provided is not in our database (e.g., a private address).
     * @throws \GeoIp2\Exception\AuthenticationException if there is a problem
     *   with the user ID or license key that you provided.
     * @throws \GeoIp2\Exception\OutOfQueriesException if your account is out
     *   of queries.
     * @throws \GeoIp2\Exception\InvalidRequestException} if your request was
     *   received by the web service but is invalid for some other reason.
     *   This may indicate an issue with this API. Please report the error to
     *   MaxMind.
     * @throws \GeoIp2\Exception\HttpException if an unexpected HTTP error
     *   code or message was returned. This could indicate a problem with the
     *   connection between your server and the web service or that the web
     *   service returned an invalid document or 500 error code.
     * @throws \GeoIp2\Exception\GeoIp2Exception This serves as the parent
     *   class to the above exceptions. It will be thrown directly if a 200
     *   status code is returned but the body is invalid.
     */
    public function city($ipAddress = 'me')
    {
        return $this->responseFor('city', 'City', $ipAddress);
    }

    /**
     * This method calls the GeoIP2 Precision: City endpoint.
     *
     * @param string $ipAddress IPv4 or IPv6 address as a string. If no
     * address is provided, the address that the web service is called
     * from will be used.
     *
     * @return \GeoIp2\Model\City
     *
     * @throws \GeoIp2\Exception\AddressNotFoundException if the address you
     *   provided is not in our database (e.g., a private address).
     * @throws \GeoIp2\Exception\AuthenticationException if there is a problem
     *   with the user ID or license key that you provided.
     * @throws \GeoIp2\Exception\OutOfQueriesException if your account is out
     *   of queries.
     * @throws \GeoIp2\Exception\InvalidRequestException} if your request was
     *   received by the web service but is invalid for some other reason.
     *   This may indicate an issue with this API. Please report the error to
     *   MaxMind.
     * @throws \GeoIp2\Exception\HttpException if an unexpected HTTP error
     *   code or message was returned. This could indicate a problem with the
     *   connection between your server and the web service or that the web
     *   service returned an invalid document or 500 error code.
     * @throws \GeoIp2\Exception\GeoIp2Exception This serves as the parent
     *   class to the above exceptions. It will be thrown directly if a 200
     *   status code is returned but the body is invalid.
     *
     * @deprecated deprecated since version 0.7.0
     */
    public function cityIspOrg($ipAddress = 'me')
    {
        return $this->city($ipAddress);
    }

    /**
     * This method calls the GeoIP2 Precision: Country endpoint.
     *
     * @param string $ipAddress IPv4 or IPv6 address as a string. If no
     * address is provided, the address that the web service is called
     * from will be used.
     *
     * @return \GeoIp2\Model\Country
     *
     * @throws \GeoIp2\Exception\AddressNotFoundException if the address you
     *   provided is not in our database (e.g., a private address).
     * @throws \GeoIp2\Exception\AuthenticationException if there is a problem
     *   with the user ID or license key that you provided.
     * @throws \GeoIp2\Exception\OutOfQueriesException if your account is out
     *   of queries.
     * @throws \GeoIp2\Exception\InvalidRequestException} if your request was
     *   received by the web service but is invalid for some other reason.
     *   This may indicate an issue with this API. Please report the error to
     *   MaxMind.
     * @throws \GeoIp2\Exception\HttpException if an unexpected HTTP error
     *   code or message was returned. This could indicate a problem with the
     *   connection between your server and the web service or that the web
     *   service returned an invalid document or 500 error code.
     * @throws \GeoIp2\Exception\GeoIp2Exception This serves as the parent
     *   class to the above exceptions. It will be thrown directly if a 200
     *   status code is returned but the body is invalid.
     */
    public function country($ipAddress = 'me')
    {
        return $this->responseFor('country', 'Country', $ipAddress);
    }

    /**
     * This method calls the GeoIP2 Precision: Insights endpoint.
     *
     * @param string $ipAddress IPv4 or IPv6 address as a string. If no
     * address is provided, the address that the web service is called
     * from will be used.
     *
     * @return \GeoIp2\Model\Insights
     *
     * @throws \GeoIp2\Exception\AddressNotFoundException if the address you
     *   provided is not in our database (e.g., a private address).
     * @throws \GeoIp2\Exception\AuthenticationException if there is a problem
     *   with the user ID or license key that you provided.
     * @throws \GeoIp2\Exception\OutOfQueriesException if your account is out
     *   of queries.
     * @throws \GeoIp2\Exception\InvalidRequestException} if your request was
     *   received by the web service but is invalid for some other reason.
     *   This may indicate an issue with this API. Please report the error to
     *   MaxMind.
     * @throws \GeoIp2\Exception\HttpException if an unexpected HTTP error
     *   code or message was returned. This could indicate a problem with the
     *   connection between your server and the web service or that the web
     *   service returned an invalid document or 500 error code.
     * @throws \GeoIp2\Exception\GeoIp2Exception This serves as the parent
     *   class to the above exceptions. It will be thrown directly if a 200
     *   status code is returned but the body is invalid.
     *
     * @deprecated deprecated since version 0.7.0
     */
    public function insights($ipAddress = 'me')
    {
        return $this->responseFor('insights', 'Insights', $ipAddress);
    }

    /**
     * This method calls the GeoIP2 Precision: Insights (prev. Omni) endpoint.
     *
     * @param string $ipAddress IPv4 or IPv6 address as a string. If no
     * address is provided, the address that the web service is called
     * from will be used.
     *
     * @return \GeoIp2\Model\Insights
     *
     * @throws \GeoIp2\Exception\AddressNotFoundException if the address you
     *   provided is not in our database (e.g., a private address).
     * @throws \GeoIp2\Exception\AuthenticationException if there is a problem
     *   with the user ID or license key that you provided.
     * @throws \GeoIp2\Exception\OutOfQueriesException if your account is out
     *   of queries.
     * @throws \GeoIp2\Exception\InvalidRequestException} if your request was
     *   received by the web service but is invalid for some other reason.
     *   This may indicate an issue with this API. Please report the error to
     *   MaxMind.
     * @throws \GeoIp2\Exception\HttpException if an unexpected HTTP error
     *   code or message was returned. This could indicate a problem with the
     *   connection between your server and the web service or that the web
     *   service returned an invalid document or 500 error code.
     * @throws \GeoIp2\Exception\GeoIp2Exception This serves as the parent
     *   class to the above exceptions. It will be thrown directly if a 200
     *   status code is returned but the body is invalid.
     *
     * @deprecated deprecated since version 0.7.0
     */
    public function omni($ipAddress = 'me')
    {
        return $this->insights($ipAddress);
    }

    private function responseFor($endpoint, $class, $ipAddress)
    {
        $uri = implode('/', array($this->baseUri(), $endpoint, $ipAddress));

        /** @var Mediotype_MagentoGuzzle_Model_Client $client */
        $client = $this->guzzleClient ?
        $this->guzzleClient : Mage::getModel('guzzle/Client'); //replaced for Magento normalization : new GuzzleClient();

        //SO the get function works a little differently currently
        //get actually executes the request
        /** @var Mediotype_MagentoGuzzle_Model_Message_Response $response */
        $response = $client->get($uri, array('auth' => array($this->userId, $this->licenseKey)));

        if ($response && $response->getStatusCode() == 200) {
            $body = $this->handleSuccess($response, $uri);
            $class = "Mediotype_MaxMindGeo_Model_Locations_" . $class;
            return new $class(array('raw' => $body, 'locales' => $this->locales));
        } else {
            $this->handleNon200($response, $uri);
        }
    }

    private function handleSuccess($response, $uri)
    {
        if ($response->getHeader('content-length') == 0) {
            throw new Mediotype_MaxMindGeo_Model_Exception_GeoIp2Exception(
                "Received a 200 response for $uri but did not " .
                "receive a HTTP body."
            );
        }

        try {
            return $response->json();
        } catch (RuntimeException $e) {
            throw new Mediotype_MaxMindGeo_Model_Exception_GeoIp2Exception(
                "Received a 200 response for $uri but could not decode " .
                "the response as JSON: " . $e->getMessage()
            );

        }
    }

    private function handle4xx($response, $uri)
    {
        $status = $response->getStatusCode();

        if ($response->getHeader('content-length') > 0) {
            if (strstr($response->getHeader('content-type'), 'json')) {
                try {
                    $body = $response->json();
                    if (!isset($body['code']) || !isset($body['error'])) {
                        throw new Mediotype_MaxMindGeo_Model_Exception_GeoIp2Exception(
                            'Response contains JSON but it does not specify ' .
                            'code or error keys: ' . $response->getBody()
                        );
                    }
                } catch (RuntimeException $e) {
                    throw new Mediotype_MaxMindGeo_Model_Exception_HttpException(
                        "Received a $status error for $uri but it did not " .
                        "include the expected JSON body: " .
                        $e->getMessage(),
                        $status,
                        $uri
                    );
                }
            } else {
                throw new Mediotype_MaxMindGeo_Model_Exception_HttpException(
                    "Received a $status error for $uri with the " .
                    "following body: " . $response->getBody(),
                    $status,
                    $uri
                );
            }
        } else {
            throw new Mediotype_MaxMindGeo_Model_Exception_HttpException(
                "Received a $status error for $uri with no body",
                $status,
                $uri
            );
        }
        $this->handleWebServiceError(
            $body['error'],
            $body['code'],
            $status,
            $uri
        );
    }

    private function handleWebServiceError($message, $code, $status, $uri)
    {
        switch ($code) {
            case 'IP_ADDRESS_NOT_FOUND':
            case 'IP_ADDRESS_RESERVED':
                throw new Mediotype_MaxMindGeo_Model_Exception_AddressNotFoundException($message);
            case 'AUTHORIZATION_INVALID':
            case 'LICENSE_KEY_REQUIRED':
            case 'USER_ID_REQUIRED':
                throw new Mediotype_MaxMindGeo_Model_Exception_AuthenticationException($message);
            case 'OUT_OF_QUERIES':
                throw new Mediotype_MaxMindGeo_Model_Exception_OutOfQueriesException($message);
            default:
                throw new Mediotype_InstantRebate_Model_Geo_Exception_InvalidRequestException(
                    $message,
                    $code,
                    $status,
                    $uri
                );
        }
    }

    private function handle5xx($response, $uri)
    {
        $status = $response->getStatusCode();

        throw new Mediotype_MaxMindGeo_Model_Exception_HttpException(
            "Received a server error ($status) for $uri",
            $status,
            $uri
        );
    }

    private function handleNon200($response, $uri)
    {
        $status = $response->getStatusCode();

        throw new Mediotype_MaxMindGeo_Model_Exception_HttpException(
            "Received a very surprising HTTP status " .
            "($status) for $uri",
            $status,
            $uri
        );
    }

    private function baseUri()
    {
        return 'https://' . $this->host . '/geoip/v2.1';
    }
}
