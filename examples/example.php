<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Elysium\Api\ElysiumApi;

$api = new ElysiumApi([
    'email' => 'seu-email@exemplo.com',
    'hash' => 'seu-hash-de-autenticacao'
]);

try {
    // Criar cliente
    $cliente = $api->createClient([
        'nome' => 'Fernando',
        'numero' => '5532999999999',
        'plano_id' => '264',
        'email_cliente' => 'teste@gmail.com',
        'vencimento' => '2025-10-31',
        'observacao' => 'Observação opcional'
    ]);
    
    echo "Cliente criado: " . json_encode($cliente, JSON_PRETTY_PRINT) . "\n";

    // Listar planos
    $planos = $api->listPlans([
        'search' => 'premium',
        'page' => 1,
        'limit' => 10
    ]);
    
    echo "Planos encontrados: " . json_encode($planos, JSON_PRETTY_PRINT) . "\n";

} catch (Exception $e) {
    echo "Erro: " . $e->getMessage() . "\n";
}