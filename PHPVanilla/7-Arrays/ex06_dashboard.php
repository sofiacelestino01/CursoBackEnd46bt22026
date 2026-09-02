<?php

declare(strict_types=1);

$extrato = [
    ["data" => "2026-09-01", "descricao" => "Salário", "tipo" => "Entrada", "valor" => 4000.00],
    ["data" => "2026-09-02", "descricao" => "Supermercado", "tipo" => "Saida", "valor" => 450.50],
    ["data" => "2026-09-05", "descricao" => "Pix João", "tipo" => "Entrada", "valor" => 200.00],
    ["data" => "2026-09-10", "descricao" => "Conta de Luz", "tipo" => "Saida", "valor" => 120.00],
    ["data" => "2026-09-12", "descricao" => "Cinema", "tipo" => "Saida", "valor" => 65.00]
];

$totalEntradas = 0;
$totalSaidas = 0;

foreach ($extrato as $transacao) {

    if ($transacao["tipo"] == "Entrada") {
        $totalEntradas = $totalEntradas + $transacao["valor"];
    } else {
        $totalSaidas = $totalSaidas + $transacao["valor"];
    }
}

$saldoAtual = $totalEntradas - $totalSaidas;

echo "Entradas: R$ " . $totalEntradas;

echo "\n";

echo "Saídas: R$ " . $totalSaidas;

echo "\n";

echo "Saldo atual: R$ " . $saldoAtual;

echo "\n";

foreach ($extrato as $transacao) {

    echo "Data: " . $transacao["data"];
    echo "\n";

    echo "Descrição: " . $transacao["descricao"];
    echo "\n";

    echo "Tipo: " . $transacao["tipo"];
    echo "\n";

    echo "Valor: R$ " . $transacao["valor"];
    echo "\n";
}

