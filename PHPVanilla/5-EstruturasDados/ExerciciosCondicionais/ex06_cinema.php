<?php

declare(strict_types=1);

$diaSemana = "Quarta";
$isEstudante = true;
$valorBase = 40.00;

// 1. Calcula o preço de acordo com o dia
$valorDia = match ($diaSemana) {
    "Segunda", "Terca" => $valorBase * 0.80,
    "Quarta" => $valorBase * 0.50,
    "Quinta", "Sexta", "Sabado", "Domingo" => $valorBase,
    default => $valorBase
};

// 2. Aplica o desconto de estudante
if ($isEstudante === true) {
    $valorFinal = $valorDia * 0.50;
} else {
    $valorFinal = $valorDia;
}

// 3. Exibe o resultado
echo "Valor final: R$ " . number_format($valorFinal, 2, ',', '.');