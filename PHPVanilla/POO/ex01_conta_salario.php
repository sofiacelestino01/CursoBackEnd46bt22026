<?php

declare(strict_types=1);

require_once __DIR__ . '/src/Excecoes.php';
require_once __DIR__ . '/src/Titular.php';
require_once __DIR__ . '/src/Transacao.php';
require_once __DIR__ . '/src/NotificadorInterface.php';
require_once __DIR__ . '/src/Notificadores.php';
require_once __DIR__ . '/src/ContaBancaria.php';
require_once __DIR__ . '/src/ContaSalario.php';

$titular = new Titular(
    'Maria Silva',
    '12345678900'
);

$conta = new ContaSalario(
    '001',
    $titular,
    '12345678000199'
);

$conta->adicionarNotificador(
    new NotificadorEmail()
);

echo "=== TESTE DA CONTA SALÁRIO ===" . PHP_EOL;

try {
    $conta->depositarSalario(
        2500.00,
        '12345678000199'
    );

    echo "Salário depositado com sucesso." . PHP_EOL;
} catch (Throwable $erro) {
    echo "Erro: " . $erro->getMessage() . PHP_EOL;
}

try {
    $conta->depositarSalario(
        1000.00,
        '99999999000199'
    );
} catch (OperacaoNaoPermitidaException $erro) {
    echo "Depósito bloqueado: "
        . $erro->getMessage()
        . PHP_EOL;
}

for ($i = 1; $i <= 3; $i++) {
    try {
        $conta->sacar(100.00);

        echo "Saque {$i} realizado." . PHP_EOL;
    } catch (Throwable $erro) {
        echo "Erro no saque: "
            . $erro->getMessage()
            . PHP_EOL;
    }
}

echo "Titular: "
    . $conta->getTitular()->getNome()
    . PHP_EOL;

echo "Tipo: " . $conta->getTipo() . PHP_EOL;

echo "Saldo final: R$ "
    . number_format($conta->getSaldo(), 2, ',', '.')
    . PHP_EOL;
