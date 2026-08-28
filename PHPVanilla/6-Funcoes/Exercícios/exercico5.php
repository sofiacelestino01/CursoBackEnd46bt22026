
<?php
declare(strict_types=1);

function calcularCarrinho(array $produtos): float
{
    $total = 0;

    foreach ($produtos as $produto) {
        $total = $total + $produto["preco"] * $produto["quantidade"];
    }

    return $total;
}

$produtos = [
    ["nome" => "Caderno", "preco" => 25.00, "quantidade" => 2],
    ["nome" => "Caneta", "preco" => 3.50, "quantidade" => 4]
];

echo calcularCarrinho($produtos);

