<?php

namespace Aimtoget\Agent;

use Aimtoget\Agent\Exceptions\ServiceException;
use GuzzleHttp\RequestOptions;

class Networks extends Main
{
    /**
     * Get All Networks
     *
     * @return array
     */
    public function getAllNetworks()
    {
        $res = $this->_config->getClient()->request('GET', 'networks');
        $content = $res->getBody()->getContents();
        $data = json_decode($content);

        return $data->data->networks;
    }

    public function validatePhone(string $phone)
    {
        $res = $this->_config->getClient()->request('POST', 'phone/validate', [
            RequestOptions::JSON => array(
                'phone' => $phone
            )
        ]);

        $response = $res->getBody()->getContents();
        $data = json_decode($response);

        if($data->status === Config::STATUS_ERROR) {
            throw new ServiceException($res->msg);
        }

        return $data->data->validated;
    }
}