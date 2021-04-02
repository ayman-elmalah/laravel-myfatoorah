<?php

namespace AymanElmalah\MyFatoorah\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

abstract class Service
{
    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * @var $mode
     */
    protected $mode;

    /**
     * @var $token
     */
    protected $token;

    /**
     * @var $basePath
     */
    protected $basePath;

    /**
     * @var $endpoint
     */
    protected $endpoint;

    /**
     * @var $headers
     */
    protected $headers = [];

    /**
     * Service constructor.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get instance
     *
     * @throws \Exception
     */
    public function getInstance()
    {
        $this->setMode();

        $this->setBasePath();

        $this->setAccessToken();

        $this->setHeader('Content-Type', 'application/json');
        $this->setHeader('Accept-Type', 'application/json');

        $this->setClient();

        if($this->token == null) {
            throw new \Exception("You must send token");
        }

        if($this->mode == null) {
            throw new \Exception("You must send mode");
        }
    }

    /**
     * Set header
     *
     * @param array $header
     * @return $this
     */
    protected function setHeader($key, $value)
    {
        $this->headers[$key] = $value;

        return $this;
    }

    /**
     * Get headers
     *
     * @return array
     */
    protected function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Set base path
     *
     * @throws \Exception
     */
    protected function setBasePath()
    {
        if(! in_array($this->getMode(), ['test', 'live'])) {
            throw new \Exception("Mode is not supported, supported are : test and live");
        }

        $this->basePath = $this->getMode() == "live" ? "https://api.myfatoorah.com/v2/" : "https://apitest.myfatoorah.com/v2/";
    }

    /**
     * Get base path
     *
     * @return string
     */
    protected function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * Get endpoint
     *
     * @return string
     * @throws \Exception
     */
    protected function getEndPoint()
    {
        if(! isset($this->endpoint)) {
            throw new \Exception("Endpoint is not exists");
        }

        return $this->endpoint;
    }

    /**
     * Set client
     */
    protected function setClient()
    {
        $this->client = Http::withHeaders($this->getHeaders());
    }

    /**
     * Get client
     *
     * @return Client
     * @throws \Exception
     */
    public function getClient()
    {
        $this->getInstance();

        return $this->client;
    }

    /**
     * Set mode
     *
     * @param null $mode
     * @return $this
     * @throws \Exception
     */
    public function setMode($mode = null)
    {
        if($mode != null && ! in_array($mode, ['test', 'live'])) {
            throw new \Exception("Mode is not supported, supported are : test and live");
        }

        if($this->mode == null) {
            $this->mode = is_null($mode) ? config( 'myfatoorah.mode', 'test') : $mode;
        }

        return $this;
    }

    /**
     * Get mode
     *
     * @return string
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * Set access token
     *
     * @param null $token
     * @return $this
     */
    public function setAccessToken($token = null)
    {
        if($this->token == null) {
            $this->token = is_null($token) ? config( 'myfatoorah.token') : $token;
        }

        $this->setHeader('Authorization', "Bearer $this->token");

        return $this;
    }

    /**
     * Get full url
     *
     * @return string
     * @throws \Exception
     */
    public function getFullUrl() {
        return $this->getBasePath() . $this->getEndPoint();
    }
}
