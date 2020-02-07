<?php

namespace Kopokopo\SDK\Requests;

class SettlementWalletAccountRequest extends BaseRequest
{
    public function getMsisdn()
    {
        return $this->getRequestData('msisdn');
    }

    public function getNetwork()
    {
        return $this->getRequestData('network');
    }

    public function getSettlementWalletAccountBody()
    {
        return [
            'msisdn' => $this->getMsisdn(),
            'network' => $this->getNetwork()
        ];
    }
}
