<?php

namespace Kopokopo\SDK\Data;

class MerchantWallet
{
    public function setData($response)
    {
        $data['id'] = $response['id'];
        $data['type'] = $response['type'];
		
		$data['msisdn'] = $response['attributes']['msisdn'];
        $data['network'] = $response['attributes']['network'];

        return $data;
    }
}
