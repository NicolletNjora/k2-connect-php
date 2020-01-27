<?php

namespace Kopokopo\SDK;

require 'vendor/autoload.php';

use Kopokopo\SDK\Requests\StkPaymentRequest;
use Kopokopo\SDK\Requests\StatusRequest;
use Exception;
use GuzzleHttp\Psr7\Request;

class StkService extends Service
{
    public function paymentRequest($options)
    {
        $stkPaymentrequest = new StkPaymentRequest($options);
        try {
            $response = $this->client->post('api/'.$this->version.'/incoming_payments', ['body' => json_encode($stkPaymentrequest->getPaymentRequestBody()), 'headers' => $stkPaymentrequest->getHeaders()]);

            return $this->success($response);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function paymentRequestStatus($options)
    {
        $stkStatus = new StatusRequest($options);
        try {
            $object_uri = $stkStatus->getLocation();
            $request = new Request('GET', $object_uri);

            $response = $this->client->send($request, ['timeout' => 5, 'headers' => $stkStatus->getHeaders()]);

            return $this->statusSuccess($response);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
