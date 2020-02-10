<?php

namespace Kopokopo\SDK\Data\Status;

use Kopokopo\SDK\Data\PayData;
use Kopokopo\SDK\Data\StkData;
use Kopokopo\SDK\Data\PayRecipientData;
use Kopokopo\SDK\Data\TransferData;

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
            case 'webhook_subscription':
                return WebhookSubscriptionData::setData($this->data);
                break;
            case 'incoming_payment':
                return StkData::setData($this->data);
                break;
            case 'payment':
                return PayData::setData($this->data);
                break;
            case 'pay_recipient':
                return PayRecipientData::setData($this->data);
                break;
            case 'transfer':
                return TransferData::setData($this->data);
                break;
            case 'merchant_bank_account':
                return MerchantBankAccount::setData($this->data);
                break;
            case 'merchant_wallet':
                return MerchantWallet::setData($this->data);
                break;
        }
    }
}
