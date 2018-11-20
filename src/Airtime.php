<?php

namespace Aimtoget\Agent;

use GuzzleHttp\RequestOptions;
use Aimtoget\Agent\Exceptions\ServiceException;

class Airtime extends Main
{
    /**
     * Airtime purchase
     *
     * @see https://aimtoget.com/developer/api/airtime
     * @param array $data
     * @return string Reference Number
     */
    public function purchase(array $data) : string
    {
        $data = $this->_config->withPin($data);

        $res = $this->_config->getClient()->request('POST', 'airtime', [
            RequestOptions::JSON => $data
        ]);

        $content = $res->getBody()->getContents();
        $data = json_decode($content);

        if($data->status == Config::STATUS_ERROR) {
            throw new ServiceException($data->data->msg);
        }
        
        return $data->data->ref;
    }
}