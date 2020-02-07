<?php

namespace Kopokopo\SDK\Data;

// TODO: Reuse this for STK Status request response
class StkResultData
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
                $data['resource'] = $result['event']['resource'];

                $data['errors']['code'] = $result['event']['errors']['code'];
                $data['errors']['description'] = $result['event']['errors']['description'];
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

                $data['linkResource'] = $result['attributes']['_links']['resource'];
                break;
        }

        // metadata
        $data['metadata'] = $result['attributes']['metadata'];

        $data['linkSelf'] = $result['attributes']['_links']['self'];
        $data['callbackUrl'] = $result['attributes']['_links']['callback_url'];

        return $data;
    }
}
