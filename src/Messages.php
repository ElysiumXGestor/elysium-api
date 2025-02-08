<?php

namespace Elysium\Api;

use GuzzleHttp\Exception\GuzzleException;

class Messages
{
    private ElysiumApi $api;

    public function __construct(ElysiumApi $api)
    {
        $this->api = $api;
    }

    public function sendAllPlan(array $data): array
    {
        try {
            $response = $this->api->getClient()->post('/api/external/messages/send', [
                'json' => $data
            ]);

            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            return $this->api->handleError($e);
        }
    }

    public function sendSingle(array $data): array
    {
        try {
            $response = $this->api->getClient()->post('/api/external/messages/send-single', [
                'json' => $data
            ]);

            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            return $this->api->handleError($e);
        }
    }
}