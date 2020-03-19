<?php

namespace Aimtoget\Agent;

use GuzzleHttp\RequestOptions;
use Aimtoget\Agent\Exceptions\ServiceException;

class Data extends Main
{
    /**
     * Get all data plans
     *
     * @return array
     */
    public function getAllVariations() : object
    {
        $res = $this->_config->getClient()->request('GET', 'data/variations/all');
        $content = $res->getBody()->getContents();
        $data = json_decode($content);

        return $data->data->variations;
    }

    /**
     * Get selected network variartion
     *
     * @param string $network_id
     * @return array
     */
    public function getNetworkVariations(string $network_id)
    {
        $res = $this->_config->getClient()->request('GET', 'data/variations/' . $network_id);
        $content = $res->getBody()->getContents();
        $data = json_decode($content);

        return $data->data->variations;
    }

    /**
     * Purchase data
     * 
     * @see https://aimtoget.com/developer/api/data
     *
     * @param array $params Parameters
     * @return string Reference code
     */
    public function purchase(array $params) : string
    {
        $params = $this->_config->withPin($params);
        $res = $this->_config->getClient()->request('POST', 'data', [
            RequestOptions::JSON => $params
        ]);

        $content = $res->getBody()->getContents();
        $data = json_decode($content);

        if($data->status == Config::STATUS_ERROR) {
            throw new ServiceException($data->data->msg);
        }

        return $data->data->ref;
    }
}