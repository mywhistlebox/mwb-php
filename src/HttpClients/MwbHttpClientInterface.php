<?php
namespace Mwb\HttpClients;

/**
 * Interface MwbHttpClientInterface
 * @package Mwb\HttpClients
 */
interface MwbHttpClientInterface
{
    /**
     * Sends a request to the server and returns the raw response.
     *
     * @param string $url     The endpoint to send the request to.
     * @param string $method  The request method.
     * @param string $body    The body of the request.
     * @param array  $headers The request headers.
     * @param int    $timeOut The timeout in seconds for the request.
     * @param MwbRequest $request The original request
     *
     * @return \Mwb\Http\MwbResponse Raw response from the server.
     *
     * @throws \Mwb\Exceptions\MwbRestException
     */
    public function send_request($url, $method, $body, $headers, $timeOut, $request);
}