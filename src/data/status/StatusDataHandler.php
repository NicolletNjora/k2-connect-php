<?php

namespace Kopokopo\SDK\Data\Status;

use Kopokopo\SDK\Data\PayData;
use Kopokopo\SDK\Data\StkResultData;
use Kopokopo\SDK\Data\PayRecipientData;

class StatusDataHandler
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data['data'];
    }

    public function dataHandlerSort()
    {
        switch ($this->data['type']) {
            case 'incoming_payment':
                // TODO: Reuse this for STK Status request response
                return StkResultData::setData($this->data);
            break;
            case 'payment':
                return PayData::setData($this->data);
            break; 
            case 'pay_recipient':
                return PayRecipientData::setData($this->data);
            break;
        }
    }
}
