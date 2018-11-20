<?php

namespace Aimtoget\Agent;

use GuzzleHttp\RequestOptions;
use Aimtoget\Agent\Exceptions\ServiceException;

class Services extends Main
{
    /**
     * Get all services
     *
     * @return array
     */
    public function getAll() : array
    {
        $res = $this->_config->getClient()->request('GET', 'services');
        $content = $res->getBody()->getContents();
        $data = json_decode($content);

        return $data->data;
    }

    /**
     * Get service
     *
     * @param string $id Service Id
     * @return array Service data
     */
    public function getService($id)
    {
        $res = $this->_config->getClient()->request('GET', 'service/' . $id);
        $content = $res->getBody()->getContents();
        $data = json_decode($content);

        return $data->data;
    }
    
    /**
     * Pay for service
     * 
     * @see https://aimtoget.com/developer/api/pay-service
     *
     * @param string $service_id Service id
     * @param array $data Post data
     * @return void
     */
    public function pay($service_id, array $params)
    {
        $params = $this->_config->withPin($params);
        $res = $this->_config->getClient()->request('POST', 'service/pay/' . $service_id, [
            RequestOptions::JSON => $params
        ]);

        $content = $res->getBody()->getContents();
        $data = json_decode($content);

        if($data->status == Config::STATUS_ERROR) {
            throw new ServiceException($data->data->msg);
        }

        return $data->data->reference_code;
    }

    /**
     * Verify customer
     *
     * @param string $service_id Service id
     * @param string $customer_id Customer id
     * @return string Customer name
     */
    public function verifyCustomer($service_id, $customer_id)
    {
        $res = $this->_config->getClient()->request('POST', 'service/customer/' . $service_id, [
            RequestOptions::JSON => array(
                'customer_id' => $customer_id
            )
        ]);

        $content = $res->getBody()->getContents();
        $data = json_decode($content);

        return $data->data->customer_name;
    }
}