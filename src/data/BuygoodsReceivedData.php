<?php

namespace Kopokopo\SDK\Data;

class BuygoodsReceivedData
{
    public function setData($result)
    {
        $data['id'] = $result['id'];
        $data['topic'] = $result['topic'];
        $data['createdAt'] = $result['created_at'];

        $data['eventType'] = $result['event']['type'];

        $data['resourceId'] = $result['event']['resource']['id'];
        $data['amount'] = $result['event']['resource']['amount'];
        $data['currency'] = $result['event']['resource']['currency'];
        $data['status'] = $result['event']['resource']['status'];
        $data['system'] = $result['event']['resource']['system'];

        $data['reference'] = $result['event']['resource']['reference'];

        $data['originationTime'] = $result['event']['resource']['origination_time'];
        $data['senderMsisdn'] = $result['event']['resource']['sender_msisdn'];
        
        $data['tillNumber'] = $result['event']['resource']['till_number'];
       
        $data['firstName'] = $result['event']['resource']['sender_first_name'];
        $data['middleName'] = $result['event']['resource']['sender_middle_name'];
        $data['lastName'] = $result['event']['resource']['sender_last_name'];

        $data['linkSelf'] = $result['_links']['self'];
        $data['linkResource'] = $result['_links']['resource'];

        return $data;
    }
}
