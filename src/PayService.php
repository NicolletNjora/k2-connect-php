<?php

namespace Kopokopo\SDK;

require 'vendor/autoload.php';

use Kopokopo\SDK\Requests\PayRecipientMobileRequest;
use Kopokopo\SDK\Requests\PayRecipientAccountRequest;
use Kopokopo\SDK\Requests\PayRequest;
use Kopokopo\SDK\Requests\StatusRequest;
use Exception;

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

            // FIXME: Do not hard code version
            $response = $this->client->post('api/v1/pay_recipients', ['body' => json_encode($payRecipientrequest->getPayRecipientBody()), 'headers' => $payRecipientrequest->getHeaders()]);

            return $this->success($response);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function sendPay($options)
    {
        $payRequest = new PayRequest($options);
        try {
            // FIXME: Do not hard code version
            $response = $this->client->post('api/v1/payments', ['body' => json_encode($payRequest->getPayBody()), 'headers' => $payRequest->getHeaders()]);

            return $this->success($response);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function payStatus($options)
    {
        $payStatus = new StatusRequest($options);
        try {
            // FIXME: Do not hard code version
            // TODO: Figure out what to do with getStatus
            $response = $this->client->get('api/v1/payments/'.$payStatus->getLocation(), ['headers' => $payStatus->getHeaders()]);

            return $this->success($response);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
