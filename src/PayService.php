<?php

namespace Kopokopo\SDK;

require 'vendor/autoload.php';

use Kopokopo\SDK\Requests\PayRecipientMobileRequest;
use Kopokopo\SDK\Requests\PayRecipientAccountRequest;
use Kopokopo\SDK\Requests\PayRequest;
use Kopokopo\SDK\Requests\StatusRequest;
use Exception;
use GuzzleHttp\Psr7\Request;
use Kopokopo\SDK\Data\Status\StatusDataHandler;

class PayService extends Service
{
    public function addPayRecipient($options)
    {
        try {
            if (!isset($options['type'])) {
                throw new \InvalidArgumentException('You have to provide the type');
            } elseif ($options['type'] === 'bank_account') {
                $payRecipientrequest = new PayRecipientAccountRequest($options);
            } else {
                $payRecipientrequest = new PayRecipientMobileRequest($options);
            }

            $response = $this->client->post('api/'.$this->version.'/pay_recipients',
             ['body' => json_encode($payRecipientrequest->getPayRecipientBody()),
              'headers' => $payRecipientrequest->getHeaders()]);

            return $this->success($response);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function sendPay($options)
    {
        $payRequest = new PayRequest($options);
        try {
            $response = $this->client->post('api/'.$this->version.'/payments',
             ['body' => json_encode($payRequest->getPayBody()),
              'headers' => $payRequest->getHeaders()]);

            return $this->success($response);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function payRecipientStatus($options)
    {
        $payRecipientStatus = new StatusRequest($options);
        try {            
            $object_uri = $payRecipientStatus->getLocation();
            $request = new Request('GET', $object_uri);

            $response = $this->client->send($request, ['timeout' => 5, 'headers' => $payRecipientStatus->getHeaders()]);
            
            return $this->statusSuccess($response);
        } catch (Exception $e) {    
            return $this->error($e->getMessage());
        }
    }

    public function payStatus($options)
    {
        $payStatus = new StatusRequest($options);
        try {            
            $object_uri = $payStatus->getLocation();
            $request = new Request('GET', $object_uri);

            $response = $this->client->send($request, ['timeout' => 5, 'headers' => $payStatus->getHeaders()]);

            $statusDataHandler = new StatusDataHandler(json_decode($response->getBody()->getContents(), true));
            return $this->statusSuccess($statusDataHandler->dataHandlerSort());
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
