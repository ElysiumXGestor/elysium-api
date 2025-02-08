<?php

namespace Elysium\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ElysiumApi
{
    private string $email;
    private string $hash;
    private string $baseURL;
    private Client $client;
    private Clients $clients;
    private Plans $plans;
    private Messages $messages;

    public function __construct(array $config)
    {
        $this->email = $config['email'];
        $this->hash = $config['hash'];
        $this->baseURL = $config['baseURL'] ?? 'https://elysiumx.com.br';
        
        $this->client = new Client([
            'base_uri' => $this->baseURL,
            'headers' => [
                'Content-Type' => 'application/json',
                'email' => $this->email,
                'hash' => $this->hash
            ]
        ]);

        $this->clients = new Clients($this);
        $this->plans = new Plans($this);
        $this->messages = new Messages($this);
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    // Métodos para clientes
    public function createClient(array $data): array
    {
        return $this->clients->create($data);
    }

    public function updateClient(array $data): array
    {
        return $this->clients->update($data);
    }

    public function listClients(array $params = []): array
    {
        return $this->clients->list($params);
    }

    public function deleteClient(array $data): array
    {
        return $this->clients->delete($data);
    }

    public function getClient(array $data): array
    {
        return $this->clients->get($data);
    }

    // Métodos para planos
    public function createPlan(array $data): array
    {
        return $this->plans->create($data);
    }

    public function updatePlan(string $planId, array $data): array
    {
        return $this->plans->update($planId, $data);
    }

    public function listPlans(array $params = []): array
    {
        return $this->plans->list($params);
    }

    // Métodos para mensagens
    public function sendMessagePlan(array $data): array
    {
        return $this->messages->sendAllPlan($data);
    }

    public function sendSingleMessage(array $data): array
    {
        return $this->messages->sendSingle($data);
    }

    protected function handleError($error): array
    {
        if ($error instanceof GuzzleException) {
            $response = $error->getResponse();
            $status = $response ? $response->getStatusCode() : 500;
            $data = $response ? json_decode($response->getBody(), true) : [];

            $errorMessages = [
                400 => 'Requisição inválida',
                401 => 'Credenciais inválidas',
                403 => 'Sem permissão para acessar este recurso',
                404 => 'Recurso não encontrado',
                409 => 'Conflito na operação',
                500 => 'Erro interno do servidor'
            ];

            return [
                'status' => $status,
                'message' => $data['error'] ?? $errorMessages[$status] ?? 'Erro desconhecido',
                'details' => $data['details'] ?? $data
            ];
        }

        return [
            'status' => 500,
            'message' => $error->getMessage() ?? 'Erro interno na API',
            'details' => 'Erro desconhecido'
        ];
    }
}