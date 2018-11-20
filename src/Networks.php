<?php

namespace Aimtoget\Agent;

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
}