<?php
namespace Mwb\HttpClients;

use GuzzleHttp\Client;
use InvalidArgumentException;
use Exception;
use Mwb\HttpClients\MwbHttpClientInterface;
use Mwb\Authentication\BasicAuth;

/**
 * Class HttpClientsFactory
 * @package Mwb\HttpClients
 */
class HttpClientsFactory
{
    /**
     * HttpClientsFactory constructor.
     */
    private function __construct()
    {
    }

    /**
     * HTTP client generation.
     *
     * @param MwbHttpClientInterface|Client|string|null $handler
     * @param \Mwb\Authentication\BasicAuth $auth
     *
     * @throws Exception                If the cURL extension or the Guzzle client aren't available (if required).
     * @throws InvalidArgumentException If the http client handler isn't "curl", "guzzle", or an instance of Mwb\HttpClients\MwbHttpClientInterface.
     *
     * @return MwbHttpClientInterface
     */

    /**
     * Detect and return the default http client
     * @param BasicAuth $auth The authentication credentials
     * @return MwbGuzzleHttpClient
     */
    private static function detectDefaultClient($auth)
    {
        if (class_exists('GuzzleHttp\Client')) {
            return new MwbGuzzleHttpClient(null, $auth);
        }

        if (extension_loaded('curl')) {
            return new MwbGuzzleHttpClient(null, $auth);
        }

        return new MwbGuzzleHttpClient(null, $auth);
    }

     public static function createHttpClient($handler, $auth)
    {
        if (!$handler) {
            return self::detectDefaultClient($auth);
        }

        if ($handler instanceof MwbHttpClientInterface) {
            return $handler;
        }

        if ('curl' === $handler) {
            if (!extension_loaded('curl')) {
                throw new Exception('The cURL extension must be loaded in order to use the "curl" handler.');
            }

            return new MwbGuzzleHttpClient(null, $auth);
        }

        if ('guzzle' === $handler && !class_exists('GuzzleHttp\Client')) {
            throw new Exception(
                'The Guzzle HTTP client must be included in order to use the "guzzle" handler.');
        }

        if ($handler instanceof Client) {
            return new MwbGuzzleHttpClient($handler, $auth);
        }
        if ('guzzle' === $handler) {
            return new MwbGuzzleHttpClient(null, $auth);
        }

        throw new InvalidArgumentException('The http client handler must be set to "curl", "guzzle", be an instance of GuzzleHttp\Client or an instance of Mwb\HttpClients\MwbHttpClientInterface');
    }
}