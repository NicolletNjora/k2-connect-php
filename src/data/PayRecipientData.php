<?php

namespace Kopokopo\SDK\Data;

class PayRecipientData
{
    public function setData($response)
    {
        $data['id'] = $response['id'];
        $data['type'] = $response['type'];

		$data['recipientType'] = $response['attributes']['recipient_type'];
		
		$data['firstName'] = $response['attributes']['first_name'];
        $data['lastName'] = $response['attributes']['last_name'];
        $data['phone'] = $response['attributes']['phone'];
        $data['network'] = $response['attributes']['network'];
		$data['email'] = $response['attributes']['email'];

        // For Bank
        switch ($response['attributes']['recipient_type']) {
			case 'BankAccount':
				$data['accountName'] = $response['attributes']['account_name'];
                $data['accountNumber'] = $response['attributes']['account_number'];
                $data['bankId'] = $response['attributes']['bank_id'];
                $data['bankBranchId'] = $response['attributes']['bank_branch_id'];
                break;
            default:
                break;
        }

        return $data;
    }
}
