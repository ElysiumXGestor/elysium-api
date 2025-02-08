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
            $response = $this->api->getHttpClient()->post('/api/external/messages/send', [
                'json' => [
                    'plano_id' => $data['plano_id'] ?? null,
                    'mensagem' => $data['mensagem'] ?? null,
                    'tipo' => $data['tipo'] ?? '1',
                    'delay' => $data['delay'] ?? '0',
                    'imagem' => $data['imagem'] ?? null
                ]
            ]);

            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            return $this->api->handleError($e);
        }
    }

    public function sendSingle(array $data): array
    {
        try {
            $response = $this->api->getHttpClient()->post('/api/external/messages/send-single', [
                'json' => [
                    'identificador_tipo' => $data['identificador_tipo'] ?? null,
                    'identificador_valor' => $data['identificador_valor'] ?? null,
                    'mensagem' => $data['mensagem'] ?? null,
                    'tipo' => $data['tipo'] ?? '1',
                    'delay' => $data['delay'] ?? '0',
                    'imagem' => $data['imagem'] ?? null
                ]
            ]);

            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            return $this->api->handleError($e);
        }
    }
}