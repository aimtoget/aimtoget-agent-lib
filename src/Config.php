<?php

namespace Aimtoget\Agent;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;


class Config
{
    const STATUS_OK = 'ok';
    const STATUS_ERROR = 'error';

    public $_base_uri = 'https://aimtoget.com/api/v1/';

    /**
     * Aimtoget key
     *
     * @var string
     */
    private $_key;

    /**
     * Wallet pin
     *
     * @var string
     */
    private $_pin;

    /**
     * Set key
     *
     * @param string $key
     */
    public function __construct(string $key, string $wallet_pin)
    {
        $this->_key = $key;
        $this->_pin = $wallet_pin;
    }

    /**
     * Get connection client
     *
     * @return Client
     */
    public function getClient() : Client
    {
        $client = new Client([
            'base_uri' => $this->_base_uri,
            'headers' => array(
                'Content-type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->_key
            )
        ]);

        return $client;
    }

    /**
     * Add pin to data
     *
     * @return array
     */
    public function withPin(array $data) : array
    {
        $data['pin'] = $this->_pin;
        return $data;
    }
}