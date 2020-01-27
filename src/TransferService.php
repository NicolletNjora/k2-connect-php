<?php

namespace Kopokopo\SDK;

require 'vendor/autoload.php';

use Kopokopo\SDK\Requests\SettlementAccountRequest;
use Kopokopo\SDK\Requests\SettleFundsRequest;
use Kopokopo\SDK\Requests\StatusRequest;
use Exception;
use GuzzleHttp\Psr7\Request;

class TransferService extends Service
{
    public function createSettlementAccount($options)
    {
        $settlementAccountRequest = new SettlementAccountRequest($options);
        try {
            $response = $this->client->post('api/'.$this->version.'merchant_bank_accounts', ['body' => json_encode($settlementAccountRequest->getSettlementAccountBody()), 'headers' => $settlementAccountRequest->getHeaders()]);

            return $this->success($response);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function settleFunds($options)
    {
        $settleFundsRequest = new SettleFundsRequest($options);
        try {
            $response = $this->client->post('api/'.$this->version.'transfers', ['body' => json_encode($settleFundsRequest->getSettleFundsBody()), 'headers' => $settleFundsRequest->getHeaders()]);

            return $this->success($response);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function settlementAccountStatus($options)
    {
        $settlementAccountStatus = new StatusRequest($options);
        try {
            $object_uri = $settlementAccountStatus->getLocation();
            $request = new Request('GET', $object_uri);

            $response = $this->client->send($request, ['timeout' => 5, 'headers' => $settlementAccountStatus->getHeaders()]);

            return $this->statusSuccess($response);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function settlementStatus($options)
    {
        $settlementStatus = new StatusRequest($options);
        try {
            $object_uri = $settlementStatus->getLocation();
            $request = new Request('GET', $object_uri);

            $response = $this->client->send($request, ['timeout' => 5, 'headers' => $settlementStatus->getHeaders()]);

            return $this->statusSuccess($response);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
