<?php
namespace Mwb\Authentication;

/**
 * Class BasicAuth
 * @package Mwb\Authentication
 */
class BasicAuth
{
    /**
     * @var string
     */
    protected $apiKey;
    /**
     * @var string
     */
    protected $pin;

    /**
     * BasicAuth constructor.
     * @param string|null $apiKey
     * @param string|null $pin
     */
    public function __construct($apiKey = null, $pin = null)
    {
        // if null try from the environment
        $this->apiKey = $apiKey?:getenv('MWB_AUTH_KEY');
        $this->pin = $pin?:getenv('MWB_AUTH_PIN');
    }

    /**
     * Returns the api key
     * @return string
     */
    public function getAuthKey()
    {
        return $this->apiKey;
    }

    /**
     * Returns the authentication pin
     * @return string
     */
    public function getAuthPin()
    {
        return $this->pin;
    }
}