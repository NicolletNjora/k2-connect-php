<?php

namespace Kopokopo\SDK;

use Kopokopo\SDK\Requests\StatusRequest;
use Exception;
use GuzzleHttp\Psr7\Request;
use Kopokopo\SDK\Data\Status\StatusDataHandler;

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

    public function getStatus($options)
    {
        $statusRequest = new StatusRequest($options);
        try {
            $object_uri = $statusRequest->getLocation();
            $request = new Request('GET', $object_uri);

            $response = $this->client->send($request, ['headers' => $statusRequest->getHeaders()]);

            $statusDataHandler = new StatusDataHandler(json_decode($response->getBody()->getContents(), true));
            return $this->statusSuccess($statusDataHandler->dataHandlerSort());
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
