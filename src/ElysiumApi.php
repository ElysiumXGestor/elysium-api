<?php

namespace Elysium\Api;

require_once __DIR__ . '/Clients.php';
require_once __DIR__ . '/Plans.php';
require_once __DIR__ . '/Messages.php';
require_once dirname(__DIR__) . '/vendor/autoload.php';

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
            'headers' => $this->getHeaders()
        ]);

        $this->clients = new Clients($this);
        $this->plans = new Plans($this);
        $this->messages = new Messages($this);
    }

    public function getHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'email' => $this->email,
            'hash' => $this->hash
        ];
    }

    public function getHttpClient(): Client
    {
        return $this->client;
    }

    // API de Clientes
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

    // API de Planos
    public function listPlans(array $params = []): array
    {
        return $this->plans->list($params);
    }

    public function updatePlan(string $planId, array $data): array
    {
        return $this->plans->update($planId, $data);
    }

    public function createPlan(array $data): array
    {
        return $this->plans->create($data);
    }

    // API de Mensagens
    public function sendMessagePlan(array $data): array
    {
        return $this->messages->sendAllPlan($data);
    }

    public function sendSingleMessage(array $data): array
    {
        return $this->messages->sendSingle($data);
    }

    public function handleError($error): array
    {
        if ($error instanceof GuzzleException) {
            $response = $error->getResponse();
            $status = $response ? $response->getStatusCode() : 500;
            $data = $response ? json_decode($response->getBody(), true) : null;

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
                'details' => $data['details'] ?? $data ?? []
            ];
        }

        if ($error->getCode() === 'ECONNREFUSED') {
            return [
                'status' => 503,
                'message' => 'Servidor indisponível',
                'details' => 'Não foi possível conectar ao servidor'
            ];
        }

        return [
            'status' => $error->getCode() ?? 500,
            'message' => $error->getMessage() ?? 'Erro interno na API',
            'details' => $error->getCode() ?? 'Erro desconhecido'
        ];
    }
}