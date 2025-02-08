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
            $response = $this->api->getHttpClient()->post('/api/external/clients/create', [
                'json' => [
                    'nome' => $data['nome'] ?? null,
                    'email_cliente' => $data['email_cliente'] ?? null,
                    'numero' => $data['numero'] ?? null,
                    'plano_id' => $data['plano_id'] ?? null,
                    'vencimento' => $data['vencimento'] ?? null,
                    'observacao' => $data['observacao'] ?? null
                ]
            ]);

            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            return $this->api->handleError($e);
        }
    }

    public function update(array $data): array
    {
        try {
            $identificador_tipo = $data['identificador_tipo'] ?? null;
            $identificador_valor = $data['identificador_valor'] ?? null;
            unset($data['identificador_tipo'], $data['identificador_valor']);

            $response = $this->api->getHttpClient()->put(
                "/api/external/clients/update?identificador_tipo={$identificador_tipo}&identificador_valor={$identificador_valor}",
                ['json' => $data]
            );

            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            return $this->api->handleError($e);
        }
    }

    public function delete(array $data): array
    {
        try {
            $identificador_tipo = $data['identificador_tipo'] ?? null;
            $identificador_valor = $data['identificador_valor'] ?? null;

            $response = $this->api->getHttpClient()->delete(
                "/api/external/clients/delete?identificador_tipo={$identificador_tipo}&identificador_valor={$identificador_valor}"
            );

            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            return $this->api->handleError($e);
        }
    }

    public function get(array $data): array
    {
        try {
            $identificador_tipo = $data['identificador_tipo'] ?? null;
            $identificador_valor = $data['identificador_valor'] ?? null;

            $response = $this->api->getHttpClient()->get(
                "/api/external/clients/getclient?identificador_tipo={$identificador_tipo}&identificador_valor={$identificador_valor}"
            );

            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            return $this->api->handleError($e);
        }
    }

    public function list(array $params = []): array
    {
        try {
            $queryParams = http_build_query(array_filter([
                'status' => $params['status'] ?? null,
                'search' => $params['search'] ?? null,
                'page' => $params['page'] ?? 1,
                'limit' => $params['limit'] ?? 10
            ]));

            $response = $this->api->getHttpClient()->get("/api/external/clients/list?{$queryParams}");

            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            return $this->api->handleError($e);
        }
    }
}