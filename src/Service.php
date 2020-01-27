<?php

namespace Kopokopo\SDK;

use GuzzleHttp\Client;

abstract class Service
{
    protected $client;
    protected $clientId;
    protected $clientSecret;

    public function __construct($client, $clientId, $clientSecret)
    {
        $this->client = $client;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->version = 'v1';
    }

    protected static function error($data)
    {
        return [
            'status' => 'error',
            'data' => $data,
        ];
    }

    protected static function success($data)
    {
        $headers = $data->getHeaders();
        // The location header is nested, hence: $headers['location'][0]
        return [
            'status' => 'success',
            'location' => $headers['location'][0],
        ];
    }

    protected static function tokenSuccess($data)
    {
        return [
            'status' => 'success',
            'data' => json_decode($data->getBody()->getContents()),
        ];
    }

    protected static function webhookSuccess($data)
    {
        return [
            'status' => 'success',
            'data' => $data,
        ];
    }

    protected static function statusSuccess($data)
    {
        return [
            'status' => 'success',
            'data' => $data,
        ];
    }
}
