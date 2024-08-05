<?php
namespace Mwb;

use Mwb\Authentication\BasicAuth;
use Mwb\Http\MwbRequest;
use Mwb\Http\MwbResponse;
use Mwb\HttpClients\MwbGuzzleHttpClient;
use Mwb\HttpClients\MwbHttpClientInterface;
use Mwb\Exceptions\MwbRestException;
use Mwb\Util\ArrayOperations;

/**
 * Class BaseClient
 *
 * @package Mwb
 */
class BaseClient
{
    /**
     * @const Default timeout for request
     */
    const DEFAULT_REQUEST_TIMEOUT = 5;

    /**
     * @var string Base API URL
     */
    private $base_api_url = 'https://mywhistlebox.com/api/1.0/rest';

    /**
     * @var int|null Request timeout
     */
    protected $timeout = null;

    /**
     * @var MwbHttpClientInterface
     */
    protected $httpClientHandler;

    /**
     * @var BasicAuth
     */
    protected $basicAuth;
    
    /**
     * @var int Number of requests made
     */
    public static $requestCount = 0;

    /**
     * Instantiates a new BaseClient object.
     *
     * @param string|null $authKey
     * @param string|null $authPin
     * @param null $proxyHost
     * @param null $proxyPort
     * @param null $proxyUsername
     * @param null $proxyPassword
     * @internal param null $proxyOptions
     */
    public function __construct(
        $authKey = null,
        $authPin = null,
        $proxyHost = null,
        $proxyPort = null,
        $proxyUsername = null,
        $proxyPassword = null)
    {
        $this->basicAuth = new BasicAuth($authKey, $authPin);
        $this->httpClientHandler =
            new MwbGuzzleHttpClient(
                null,
                $this->basicAuth,
                $proxyHost,
                $proxyPort,
                $proxyUsername,
                $proxyPassword);
    }

    /**
     * Sets the HTTP client handler.
     *
     * @param MwbHttpClientInterface $httpClientHandler
     */
    public function setHttpClientHandler(MwbHttpClientInterface $httpClientHandler)
    {
        $this->httpClientHandler = $httpClientHandler;
    }

    /**
     * Set default timeout for all the requests
     *
     * @param int $timeout
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;
    }

    /**
     * Returns the HTTP client handler.
     *
     * @return MwbHttpClientInterface
     */
    public function getHttpClientHandler()
    {
        return $this->httpClientHandler;
    }

    /**
     * Returns the Authentication Key
     *
     * @return string
     */
    public function getAuthKey()
    {
        return $this->basicAuth->getAuthKey();
    }

    /**
     * Sets the base api url
     *
     * @param string $url
     */
    public function setBaseUrl($url)
    {
        $this->base_api_url = $url;
    }

    /**
     * @param MwbRequest $request
     * @param null $fullUrl (request contains endpoint)
     * @return MwbResponse
     * @throws Exceptions\MwbRequestException
     * @throws MwbRestException
     */
    public function sendRequest(MwbRequest $request, $fullUrl = null)
    {
        // request contains a relative endpoint.  It can be overriden with the fullUrl
        $fullUrl = $fullUrl ? $fullUrl : $this->base_api_url . $request->makeMethodUrl();
        $timeout = $this->timeout ?: static::DEFAULT_REQUEST_TIMEOUT;

        $MwbResponse =
            $this->httpClientHandler->send_request(
                $fullUrl, $request->getMethod(), $request->getParams(), $request->getHeaders(), $timeout, $request);

        static::$requestCount++;

        if ($MwbResponse->getStatusCode() >= 500) {
            return $this->sendRequest($request, null);
        }
        return $MwbResponse;
    }

    /**
     * getIt method
     * @param string $endpoint
     * @param array $params
     * @return MwbResponse
     */
    public function getIt($endpoint, array $params=[])
    {
        $request =
            new MwbRequest(
                'GET', $endpoint, ArrayOperations::removeNull($params));
        return $this->sendRequest($request);
    }

    /**
     * postIt method
     * @param $endpoint
     * @param $params
     * @return MwbResponse
     */
    public function postIt($endpoint, array $params=[])
    {
        $request =
            new MwbRequest(
                'POST', $endpoint, ArrayOperations::removeNull($params));
        return $this->sendRequest($request);
    }

    /**
     * deleteIt method
     * @param string $endpoint
     * @param array $params
     * @return MwbResponse
     */
    public function deleteIt($endpoint, array $params=[])
    {
        $request =
            new MwbRequest(
                'DELETE', $endpoint, ArrayOperations::removeNull($params));

        return $this->sendRequest($request);
    }
}
