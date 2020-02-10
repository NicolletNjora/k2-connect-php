<?php

namespace Kopokopo\SDK\Requests;

class MerchantWalletRequest extends BaseRequest
{
    public function getMsisdn()
    {
        return $this->getRequestData('msisdn');
    }

    public function getNetwork()
    {
        return $this->getRequestData('network');
    }

    public function getMerchantWalletBody()
    {
        return [
            'msisdn' => $this->getMsisdn(),
            'network' => $this->getNetwork()
        ];
    }
}
