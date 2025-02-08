<?php

namespace Elysium\Api;

use GuzzleHttp\Exception\GuzzleException;

class Plans
{
    private ElysiumApi $api;

    public function __construct(ElysiumApi $api)
    {
        $this->api = $api;
    }

    public function create(array $data): array
    {
        try {
            $response = $this->api->getClient()->post('/api/external/plans/create', [
                'json' => $data
            ]);

            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            return $this->api->handleError($e);
        }
    }

    public function update(string $planId, array $data): array
    {
        try {
            $data['plano_id'] = $planId;
            $response = $this->api->getClient()->put('/api/external/plans/update', [
                'json' => $data
            ]);

            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            return $this->api->handleError($e);
        }
    }

    public function list(array $params = []): array
    {
        try {
            $response = $this->api->getClient()->get('/api/external/plans/list', [
                'query' => $params
            ]);

            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            return $this->api->handleError($e);
        }
    }
}