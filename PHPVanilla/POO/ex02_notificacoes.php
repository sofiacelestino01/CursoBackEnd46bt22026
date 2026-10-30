<?php

declare(strict_types=1);

require_once __DIR__ . '/src/Excecoes.php';
require_once __DIR__ . '/src/Titular.php';
require_once __DIR__ . '/src/Transacao.php';
require_once __DIR__ . '/src/NotificadorInterface.php';
require_once __DIR__ . '/src/Notificadores.php';
require_once __DIR__ . '/src/ContaBancaria.php';
require_once __DIR__ . '/src/ContaCorrente.php';

$titular = new Titular(
    'Maria Silva',
    '12345678900'
);

$conta = new ContaCorrente(
    '002',
    $titular,
    500.00
);

$conta->adicionarNotificador(
    new NotificadorEmail()
);

$conta->adicionarNotificador(
    new NotificadorSMS()
);

$conta->adicionarNotificador(
    new NotificadorWhatsApp()
);

echo "=== TESTE DE NOTIFICAÇÕES ===" . PHP_EOL;

$conta->depositar(1000.00);

echo PHP_EOL;

$conta->sacar(200.00);

echo PHP_EOL;

echo "Saldo final: R$ "
    . number_format($conta->getSaldo(), 2, ',', '.')
    . PHP_EOL;
