<?php

declare(strict_types=1);

require_once __DIR__ . '/src/Excecoes.php';
require_once __DIR__ . '/src/Titular.php';
require_once __DIR__ . '/src/Transacao.php';
require_once __DIR__ . '/src/NotificadorInterface.php';
require_once __DIR__ . '/src/ContaBancaria.php';
require_once __DIR__ . '/src/ContaCorrente.php';
require_once __DIR__ . '/src/ContaInvestimento.php';

$titular = new Titular(
    'Maria Silva',
    '12345678900'
);

$investimento = new ContaInvestimento(
    '005',
    $titular,
    0.02
);

$contaCorrente = new ContaCorrente(
    '006',
    $titular,
    500.00
);

echo "=== TESTE DA CONTA INVESTIMENTO ===" . PHP_EOL;

$investimento->depositar(5000.00);

echo "Saldo inicial: R$ "
    . number_format(
        $investimento->getSaldo(),
        2,
        ',',
        '.'
    )
    . PHP_EOL;

echo PHP_EOL . "Taxa de administração:" . PHP_EOL;

foreach ([0, 6, 12, 24] as $meses) {
    $taxa = $investimento->calcularTaxaAdministracao(
        $meses
    );

    echo "{$meses} meses: "
        . number_format($taxa * 100, 2, ',', '.')
        . "%" . PHP_EOL;
}

echo PHP_EOL . "Realizando resgate..." . PHP_EOL;

$valorLiquido = $investimento->resgatar(
    1000.00,
    365,
    $contaCorrente
);

echo "Valor líquido resgatado: R$ "
    . number_format($valorLiquido, 2, ',', '.')
    . PHP_EOL;

echo "Saldo do investimento: R$ "
    . number_format(
        $investimento->getSaldo(),
        2,
        ',',
        '.'
    )
    . PHP_EOL;

echo "Saldo da conta corrente: R$ "
    . number_format(
        $contaCorrente->getSaldo(),
        2,
        ',',
        '.'
    )
    . PHP_EOL;
