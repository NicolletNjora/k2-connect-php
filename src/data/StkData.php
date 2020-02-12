<?php

namespace Kopokopo\SDK\Data;

class StkData
{
    public function setData($result)
    {
        $data['id'] = $result['id'];
        $data['type'] = $result['type'];

        $data['initiationTime'] = $result['attributes']['initiation_time'];
        $data['status'] = $result['attributes']['status'];

        $data['eventType'] = $result['attributes']['event']['type'];

        switch ($result['attributes']['status']) {
            case 'Failed':
                $data['resource'] = $result['attributes']['event']['resource'];

                $data['errorsCode'] = $result['attributes']['event']['errors']['code'];
                $data['errorsDescription'] = $result['attributes']['event']['errors']['description'];
                break;
            default:
                $data['transactionReference'] = $result['attributes']['event']['resource']['transaction_reference'];
                $data['originationTime'] = $result['attributes']['event']['resource']['origination_time'];
                $data['senderMsisdn'] = $result['attributes']['event']['resource']['sender_msisdn'];
                $data['amount'] = $result['attributes']['event']['resource']['amount'];
                $data['currency'] = $result['attributes']['event']['resource']['currency'];
                $data['tillIdentifier'] = $result['attributes']['event']['resource']['till_identifier'];
                $data['system'] = $result['attributes']['event']['resource']['system'];
                $data['status'] = $result['attributes']['event']['resource']['status'];
                $data['firstName'] = $result['attributes']['event']['resource']['sender_first_name'];
                $data['middleName'] = $result['attributes']['event']['resource']['sender_middle_name'];
                $data['lastName'] = $result['attributes']['event']['resource']['sender_last_name'];

                $data['errors'] = $result['attributes']['event']['errors'];
                break;
        }

        // metadata
        $data['metadata'] = $result['attributes']['meta_data'];

        $data['linkSelf'] = $result['attributes']['_links']['self'];
        $data['callbackUrl'] = $result['attributes']['_links']['callback_url'];

        return $data;
    }
}
