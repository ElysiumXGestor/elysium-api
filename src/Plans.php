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

    public function list(array $params = []): array
    {
        try {
            $queryParams = http_build_query(array_filter([
                'search' => $params['search'] ?? null,
                'page' => $params['page'] ?? 1,
                'limit' => $params['limit'] ?? 10
            ]));

            $response = $this->api->getHttpClient()->get("/api/external/plans/list?{$queryParams}");

            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            return $this->api->handleError($e);
        }
    }

    public function create(array $data): array
    {
        try {
            $response = $this->api->getHttpClient()->post('/api/external/plans/create', [
                'json' => [
                    'nome' => $data['nome'] ?? null,
                    'valor' => $data['valor'] ?? null,
                    'duracao' => $data['duracao'] ?? null,
                    'hora_disparo' => $data['hora_disparo'] ?? null
                ]
            ]);

            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            return $this->api->handleError($e);
        }
    }

    public function update(string $planId, array $data): array
    {
        try {
            $response = $this->api->getHttpClient()->put(
                "/api/external/plans/update?plano_id={$planId}",
                ['json' => $data]
            );

            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            return $this->api->handleError($e);
        }
    }
}