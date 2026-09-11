<?php
declare(strict_types=1);

function calcularIMC(float $peso, float $altura): float
{
    return $peso / ($altura * $altura);
}

echo calcularIMC(60.0, 1.65);
