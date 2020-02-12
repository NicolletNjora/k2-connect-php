<?php

namespace Kopokopo\SDK\Data;

class MerchantBankAccount
{
    public function setData($response)
    {
        $data['id'] = $response['id'];
        $data['type'] = $response['type'];

        $data['accountName'] = $response['attributes']['account_name'];
        $data['accountNumber'] = $response['attributes']['account_number'];
        $data['bankId'] = $response['attributes']['bank_id'];
        $data['bankBranchId'] = $response['attributes']['bank_branch_id'];

        return $data;
    }
}
