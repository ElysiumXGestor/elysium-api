<?php

namespace Elysium\Api;

use GuzzleHttp\Exception\GuzzleException;

class Clients
{
    private ElysiumApi $api;

    public function __construct(ElysiumApi $api)
    {
        $this->api = $api;
    }

    public function create(array $data): array
    {
        try {
            $response = $this->api->getClient()->post('/api/external/clients/create', [
                'json' => $data
            ]);

            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            return $this->api->handleError($e);
        }
    }

    public function update(array $data): array
    {
        try {
            $response = $this->api->getClient()->put('/api/external/clients/update', [
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
            $response = $this->api->getClient()->get('/api/external/clients/list', [
                'query' => $params
            ]);

            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            return $this->api->handleError($e);
        }
    }

    public function delete(array $data): array
    {
        try {
            $response = $this->api->getClient()->delete('/api/external/clients/delete', [
                'json' => $data
            ]);

            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            return $this->api->handleError($e);
        }
    }

    public function get(array $data): array
    {
        try {
            $response = $this->api->getClient()->get('/api/external/clients/get', [
                'query' => $data
            ]);

            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            return $this->api->handleError($e);
        }
    }
}