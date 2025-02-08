# Elysium API - PHP

API moderna e futurista para integração com o sistema Elysium.

## Instalação via Composer

```bash
composer require elysium/api
```

## Configuração Inicial

Para começar a usar a API, você precisa inicializar com suas credenciais:

```php
use Elysium\Api\ElysiumApi;

$api = new ElysiumApi([
    'email' => 'seu-email@exemplo.com',
    'hash' => 'seu-hash-de-autenticacao'
]);
```

## Autenticação

A autenticação é realizada através de dois parâmetros essenciais:

- `email`: Seu email cadastrado no sistema Elysium
- `hash`: Sua chave de autenticação fornecida pelo sistema

  **IMPORTANTE**: Mantenha suas credenciais em segurança! Nunca as exponha em código público.

## Recursos Principais

- Interface moderna e intuitiva
- Suporte completo às funcionalidades do Elysium
- Tratamento de erros robusto
- Documentação completa
- Compatível com PHP 7.4+

## Exemplos de Uso

### Criar Cliente

```php
try {
    $cliente = $api->createClient([
        'nome' => 'Fernando',
        'numero' => '000000000',
        'plano_id' => '264',
        'email_cliente' => 'teste@gmail.com',
        'vencimento' => '2025-10-31',
        'observacao' => 'Observação' // opcional
    ]);
    print_r($cliente);
} catch (Exception $error) {
    echo "Erro: " . $error->getMessage();
}
```

### Deletar Cliente

Duas formas de deletar um cliente:

```php
// Por número
$deletarPorNumero = $api->deleteClient([
    'identificador_tipo' => 'numero',
    'identificador_valor' => '11987654321'
]);

// Por email
$deletarPorEmail = $api->deleteClient([
    'identificador_tipo' => 'email',
    'identificador_valor' => 'teste@exemplo.com'
]);
```

### Consultar Cliente

```php
try {
    $cliente = $api->getClient([
        'identificador_tipo' => 'numero',
        'identificador_valor' => '1198654321'
    ]);
    print_r($cliente);
} catch (Exception $error) {
    echo "Erro: " . $error->getMessage();
}
```

### Listar Clientes

```php
try {
    $clientes = $api->listClients([
        'status' => 'vencidos',    // opcional
        'search' => 'cliente 1',    // opcional
        'page' => 1,               // opcional
        'limit' => 10              // opcional
    ]);
    print_r($clientes);
} catch (Exception $error) {
    echo "Erro: " . $error->getMessage();
}
```

### Enviar Mensagem

```php
try {
    // Mensagem de texto
    $mensagemTexto = $api->sendSingleMessage([
        'identificador_tipo' => 'email',
        'identificador_valor' => 'cliente@exemplo.com',
        'mensagem' => 'Olá! Como vai?',
        'tipo' => '1',    // 1 = texto
        'delay' => '1'    // velocidade (0 a 5)
    ]);

    // Mensagem com imagem
    $mensagemImagem = $api->sendSingleMessage([
        'identificador_tipo' => 'numero',
        'identificador_valor' => '11987654321',
        'mensagem' => 'Veja nossa promoção!',
        'tipo' => '2',    // 2 = imagem
        'delay' => '1',
        'imagem' => 'data:image/png;base64,...'
    ]);
} catch (Exception $error) {
    echo "Erro: " . $error->getMessage();
}
```

### Mensagem em Massa

```php
try {
    $envioMassa = $api->sendMessagePlan([
        'plano_id' => '264',
        'mensagem' => 'Mensagem para todos!',
        'tipo' => '1',
        'delay' => '0'
    ]);
    print_r($envioMassa);
} catch (Exception $error) {
    echo "Erro: " . $error->getMessage();
}
```

### Gerenciar Planos

```php
try {
    // Criar plano
    $novoPlan = $api->createPlan([
        'nome' => 'Plano Premium',
        'valor' => 100,
        'duracao' => 30,
        'hora_disparo' => '00:00'
    ]);

    // Atualizar plano
    $planoAtualizado = $api->updatePlan('266', [
        'nome' => 'Plano Premium 2.0',
        'valor' => 100,
        'duracao' => 30,
        'hora_disparo' => '00:00'
    ]);

    // Listar planos
    $planos = $api->listPlans([
        'search' => 'premium',
        'page' => 1,
        'limit' => 10
    ]);
} catch (Exception $error) {
    echo "Erro: " . $error->getMessage();
}
```

## Velocidades de Envio

| Delay | Tempo de Envio |
| ----- | -------------- |
| 0     | 10-20 segundos |
| 1     | 20-30 segundos |
| 2     | 30-40 segundos |
| 3     | 40-50 segundos |
| 4     | 50-60 segundos |
| 5     | 60-70 segundos |

## Requisitos

- PHP 7.4 ou superior
- Extensão cURL habilitada
- Composer
