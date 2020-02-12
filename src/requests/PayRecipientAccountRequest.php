<?php

namespace Kopokopo\SDK\Requests;

class PayRecipientAccountRequest extends BaseRequest
{
    public function getType()
    {
        return $this->getRequestData('type');
    }

    public function getFirstName()
    {
        return $this->getRequestData('firstName');
    }

    public function getLastName()
    {
        return $this->getRequestData('lastName');
    }

    public function getAccountName()
    {
        return $this->getRequestData('accountName');
    }

    public function getBankId()
    {
        return $this->getRequestData('bankId');
    }

    public function getBankBranchId()
    {
        return $this->getRequestData('bankBranchId');
    }

    public function getAccountNumber()
    {
        return $this->getRequestData('accountNumber');
    }

    public function getEmail()
    {
        if (!isset($this->data['email'])) {
            return null;
        }

        return $this->getRequestData('email');
    }

    public function getPhone()
    {
        $validate = new Validate();

        if (!isset($this->data['phone'])) {
            return null;
        } elseif ($validate->isPhoneValid($this->getRequestData('phone'))) {
            return $this->getRequestData('phone');
        }
    }

    public function getNetwork()
    {
        if (!isset($this->data['network'])) {
            return null;
        }
        return $this->getRequestData('network');
    }

    public function getPayRecipientBody()
    {
        return [
            'type' => $this->getType(),
            'pay_recipient' => [
                'first_name' => $this->getFirstName(),
                'last_name' => $this->getLastName(),
                'account_name' => $this->getAccountName(),
                'bank_id' => $this->getBankId(),
                'bank_branch_id' => $this->getBankBranchId(),
                'account_number' => $this->getAccountNumber(),
                'email' => $this->getEmail(),
                'phone' => $this->getPhone(),
                'network' => $this->getNetwork()
            ],
        ];
    }
}
