<?php

namespace Aimtoget\Agent;

use GuzzleHttp\Client;

class Account extends Main
{
    /**
     * Get balance
     *
     * @return string
     */
    public function getBalance(): float
    {
        $res = $this->_config->getClient()->request('GET', 'balance');
        $content = $res->getBody()->getContents();
        $data = json_decode($content);

        return $data->data->balance;
    }
}
