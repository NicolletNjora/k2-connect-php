<?php

namespace Kopokopo\SDK\Data\Status;

class WebhookSubscriptionData
{
    public function setData($response)
    {
        $data['id'] = $response['id'];
        $data['type'] = $response['type'];

        $data['eventType'] = $response['attributes']['event_type'];
        $data['webhookUri'] = $response['attributes']['webhook_uri'];
        $data['secret'] = $response['attributes']['secret'];
        $data['status'] = $response['attributes']['status'];

        $data['scopeableType'] = $response['attributes']['scopeable_type'];
        $data['scopeableId'] = $response['attributes']['scopeable_id'];

        return $data;
    }
}
