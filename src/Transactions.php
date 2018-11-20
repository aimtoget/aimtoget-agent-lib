<?php

namespace Aimtoget\Agent;

use GuzzleHttp\RequestOptions;
use GuzzleHttp\Exception\ServerException;

class Transactions extends Main
{

    /**
     * Get transaction details
     *
     * @param string $reference_code Reference code
     * @return object Transaction data
     */
    public function getTransaction(string $reference_code): object
    {
        $res = $this->_config->getClient()->request('GET', 'me/transactions/' . $reference_code);
        $content = $res->getBody()->getContents();
        $data = json_decode($content);

        if($data->status == Config::STATUS_ERROR) {
            throw new ServerException($data->data->msg);
        }

        return $data->data;
    }

    /**
     * Fetch transactions
     *
     * @param integer $page Page to fetch
     * @param integer $limit No. of transactions to fetch
     * @return array Transactions
     */
    public function getTransactions(int $page = 1, int $limit = 10) : array
    {
        $params = array(
            'page' => $page,
            'limit' => $limit);

        $endpoint = 'me/transactions?' . http_build_query($params);
        $res = $this->_config->getClient()->request('GET', $endpoint);

        $content = $res->getBody()->getContents();
        $data = json_decode($content);

        return $data->data;
    }
}