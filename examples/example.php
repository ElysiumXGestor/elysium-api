<?php

require_once __DIR__ . '/src/ElysiumApi.php';

use Elysium\Api\ElysiumApi;

// Inicialização da API
$api = new ElysiumApi([
    'email' => 'email@gmail.com',
    'hash' => 'apikey',
]);

try {
    // Exemplo 1: Criar um cliente
    $novoCliente = $api->createClient([
        'nome' => 'Fernando',
        'numero' => '5532995959999',
        'plano_id' => '264',
        'email_cliente' => 'teste@gm23ail.com',
        'vencimento' => '2025-10-31',
        'observacao' => 'Cliente teste'
    ]);
    echo "Cliente criado: " . json_encode($novoCliente, JSON_PRETTY_PRINT) . "\n\n";

    // Exemplo 2: Atualizar um cliente
    $clienteAtualizado = $api->updateClient([
        'identificador_tipo' => 'email',
        'identificador_valor' => 'teste@gm23ail.com',
        'nome' => 'Fernando Silva',
        'vencimento' => '2025-12-31'
    ]);
    echo "Cliente atualizado: " . json_encode($clienteAtualizado, JSON_PRETTY_PRINT) . "\n\n";

    // Exemplo 3: Listar clientes
    $clientes = $api->listClients([
        'status' => 'ativos',
        'search' => 'Fernando',
        'page' => 1,
        'limit' => 10
    ]);
    echo "Lista de clientes: " . json_encode($clientes, JSON_PRETTY_PRINT) . "\n\n";

    // Exemplo 4: Enviar mensagem para um cliente
    $mensagem = $api->sendSingleMessage([
        'identificador_tipo' => 'email',
        'identificador_valor' => 'teste@gmail.com',
        'mensagem' => 'Olá, tudo bem?',
        'tipo' => '1',
        'delay' => '0'
    ]);
    echo "Mensagem enviada: " . json_encode($mensagem, JSON_PRETTY_PRINT) . "\n\n";

} catch (Exception $e) {
    echo "Erro: " . $e->getMessage() . "\n";
}