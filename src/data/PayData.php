<?php

namespace Kopokopo\SDK\Data;

// TODO: Reuse this
class PayData
{
    public function setData($result)
    {
        $data['id'] = $result['id'];
        $data['type'] = $result['type'];

        $data['transactionReference'] = $result['attributes']['transaction_reference'];
        $data['destination'] = $result['attributes']['destination'];
        $data['status'] = $result['attributes']['status'];

        $data['origination_time'] = $result['attributes']['origination_time'];
        $data['initiationTime'] = $result['attributes']['initiation_time']; 

        $data['amount'] = $result['attributes']['amount']['value'];
        $data['currency'] = $result['attributes']['amount']['currency'];

        // metadata
        $data['metadata'] = $result['attributes']['meta_data'];

        // _links
        $data['linkSelf'] = $result['attributes']['_links']['self'];
        $data['callbackUrl'] = $result['attributes']['_links']['callback_url'];

        return $data;
    }
}
