<?php

namespace Aimtoget\Agent;

use Aimtoget\Agent\Exceptions\ServiceException;
use GuzzleHttp\RequestOptions;

class BankTransfer extends Main
{
    /**
     * Get banks
     *
     * @return array
     */
    public function getBanks()
    {
        $request = $this->_config->getClient()->get('banks');
        $response = $request->getBody()->getContents();
        $content = json_decode($response);

        return $content->data->banks;
    }

    /**
     * Resolve account details
     *
     * @see https://aimtoget.com/developer/api/transfer-resolve-account
     * 
     * @param string $bank_code
     * @param string $account_number
     * @return string Account name
     */
    public function resolveAccount(string $bank_code, string $account_number)
    {
        $request = $this->_config->getClient()->post('banks/resolveaccount', [
            RequestOptions::JSON => [
                'bank_code' => $bank_code,
                'account_number' => $account_number
            ]
        ]);

        $content = $request->getBody()->getContents();
        $response = json_decode($content);

        if($response->status === Config::STATUS_ERROR) {
            throw new ServiceException($response->data->msg);
        }

        return $response->data->name;
    }

    /**
     * Make bank transfer
     * 
     * @see https://aimtoget.com/developer/api/transfer-bank
     *
     * @param array $data
     * @return string Reference code
     */
    public function transfer(array $data)
    {
        $config = $this->_config;
        $data = $config->withPin($data);

        $request = $config->getClient()->request('POST', 'bank-transfer', [
            RequestOptions::JSON => $data
        ]);
        $content = $request->getBody()->getContents();
        $response = json_decode($content);

        if($response->status === Config::STATUS_ERROR) {
            throw new ServiceException($response->data->msg);
        }

        return $response->data->ref;
    }
}