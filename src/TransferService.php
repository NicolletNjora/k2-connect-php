<?php

namespace Kopokopo\SDK;

require 'vendor/autoload.php';

use Kopokopo\SDK\Requests\MerchantBankAccountRequest;
use Kopokopo\SDK\Requests\MerchantWalletRequest;
use Kopokopo\SDK\Requests\SettleFundsRequest;
use Kopokopo\SDK\Requests\StatusRequest;
use Exception;
use GuzzleHttp\Psr7\Request;
use Kopokopo\SDK\Data\Status\StatusDataHandler;

class TransferService extends Service
{
    public function createMerchantBankAccount($options)
    {
        $merchantBankAccountRequest = new MerchantBankAccountRequest($options);
        try {
            $response = $this->client->post('api/'.$this->version.'/merchant_bank_accounts',
                ['body' => json_encode($merchantBankAccountRequest->getMerchantBankAccountBody()),
                 'headers' => $merchantBankAccountRequest->getHeaders()]);

            return $this->success($response);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function createMerchantWallet($options)
    {
        $merchantWalletRequest = new MerchantWalletRequest($options);
        try {
            $response = $this->client->post('api/'.$this->version.'/merchant_wallets',
             ['body' => json_encode($merchantWalletRequest->getMerchantWalletBody()),
              'headers' => $merchantWalletRequest->getHeaders()]);

            return $this->success($response);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function settleFunds($options)
    {
        $settleFundsRequest = new SettleFundsRequest($options);
        try {
            $response = $this->client->post('api/'.$this->version.'/transfers',
             ['body' => json_encode($settleFundsRequest->getSettleFundsBody()),
              'headers' => $settleFundsRequest->getHeaders()]);

            return $this->success($response);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
