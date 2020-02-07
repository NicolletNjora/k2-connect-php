<?php

namespace Kopokopo\SDK\Requests;

class SettleFundsRequest extends BaseRequest
{
    public function getAmount()
    {
        return $this->getRequestData('amount');
    }

    public function getCurrency()
    {
        return $this->getRequestData('currency');
    }

    public function getDestination()
    {
        if (!isset($this->data['destination'])) {
            return null;
        }

        return $this->getRequestData('destination');
    }

    public function getUrl()
    {
        if (!isset($this->data['callbackUrl'])) {
            return null;
        }

        return $this->getRequestData('callbackUrl');
    }

    public function getMetadata()
    {
        if (!isset($this->data['metadata'])) {
            return null;
        }

        return $this->getRequestData('metadata');
    }

    public function getSettleFundsBody()
    {
        return [
            'amount' => [
                'currency' => $this->getCurrency(),
                'value' => $this->getAmount(),
            ],
            'destination' => $this->getDestination(),
            'meta_data' => $this->getMetadata(),
            '_links' => [
                'callback_url' => $this->getUrl(),
            ],
        ];
    }
}
