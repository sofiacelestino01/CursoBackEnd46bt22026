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
    '003',
    $titular,
    500.00
);

$conta->depositar(1000.00);
$conta->sacar(150.00);
$conta->depositar(300.00);
$conta->sacar(50.00);

echo "=================================================" . PHP_EOL;
echo "                 EXTRATO BANCÁRIO                " . PHP_EOL;
echo "=================================================" . PHP_EOL;

printf(
    "%-20s %-18s %12s %12s\n",
    'DATA',
    'TIPO',
    'VALOR (R$)',
    'SALDO (R$)'
);

echo str_repeat('-', 66) . PHP_EOL;

foreach ($conta->getExtrato() as $transacao) {
    printf(
        "%-20s %-18s %12.2f %12.2f\n",
        $transacao->getData(),
        $transacao->getTipo(),
        $transacao->getValor(),
        $transacao->getSaldoAposTransacao()
    );
}

echo str_repeat('-', 66) . PHP_EOL;

printf(
    "Saldo final: R$ %.2f\n",
    $conta->getSaldo()
);
