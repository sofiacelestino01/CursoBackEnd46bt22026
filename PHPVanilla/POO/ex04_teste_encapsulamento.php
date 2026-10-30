<?php

declare(strict_types=1);

require_once __DIR__ . '/src/Excecoes.php';
require_once __DIR__ . '/src/Titular.php';
require_once __DIR__ . '/src/Transacao.php';
require_once __DIR__ . '/src/NotificadorInterface.php';
require_once __DIR__ . '/src/ContaBancaria.php';
require_once __DIR__ . '/src/ContaCorrente.php';

$titular = new Titular(
    'Maria Silva',
    '12345678900'
);

$conta = new ContaCorrente(
    '004',
    $titular,
    200.00
);

echo "=== TESTE DE ENCAPSULAMENTO ===" . PHP_EOL;

echo PHP_EOL . "1. Tentativa de alterar propriedade privada:"
    . PHP_EOL;

try {
    $titular->nome = 'Outro Nome';

    echo "A alteração foi permitida." . PHP_EOL;
} catch (Error $erro) {
    echo "Bloqueado: " . $erro->getMessage() . PHP_EOL;
}

echo PHP_EOL . "2. Tentativa de instanciar classe abstrata:"
    . PHP_EOL;

try {
    $contaAbstrata = new ContaBancaria(
        '005',
        $titular
    );

    echo "A instanciação foi permitida." . PHP_EOL;
} catch (Error $erro) {
    echo "Bloqueado: " . $erro->getMessage() . PHP_EOL;
}

echo PHP_EOL . "3. Tentativa de depósito negativo:"
    . PHP_EOL;

try {
    $conta->depositar(-100.00);

    echo "O depósito foi permitido." . PHP_EOL;
} catch (ValorInvalidoException $erro) {
    echo "Bloqueado: " . $erro->getMessage() . PHP_EOL;
}

echo PHP_EOL . "4. Saldo após os testes:"
    . PHP_EOL;

echo "R$ "
    . number_format($conta->getSaldo(), 2, ',', '.')
    . PHP_EOL;
