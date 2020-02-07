<?php

namespace Kopokopo\SDK\Requests;

class SettlementBankAccountRequest extends BaseRequest
{
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

    public function getSettlementBankAccountBody()
    {
        return [
            'account_name' => $this->getAccountName(),
            'bank_id' => $this->getBankId(),
            'bank_branch_id' => $this->getBankBranchId(),
            'account_number' => $this->getAccountNumber(),
        ];
    }
}