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
     * @param $key
     * @param $value
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
     * @return array|mixed
     */
    protected function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Set base path
     *
     * @return void
     * @throws \Exception
     */
    protected function setBasePath()
    {
        $availableModes = $this->availableModes();

        if(! array_key_exists($this->getMode(), $availableModes)) {
            throw new \Exception("Mode is not supported, supported are : " . implode(',', array_keys($availableModes)));
        }

        $this->basePath = data_get($availableModes, $this->getMode().'.base_path');
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
        $availableModes = $this->availableModes();

        if($mode != null && ! array_key_exists($this->getMode(), $availableModes)) {
            throw new \Exception("Mode is not supported, supported are : " . implode(',', array_keys($availableModes)));
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

    /**
     * Available modes
     *
     * @return array
     */
    private function availableModes() {
        return [
            'test'      => ['base_path' => 'https://apitest.myfatoorah.com/v2/'],
            'live'      => ['base_path' => 'https://api.myfatoorah.com/v2/'],
            'live-sa'   => ['base_path' => 'https://api-sa.myfatoorah.com/v2/'],
        ];
    }
}
