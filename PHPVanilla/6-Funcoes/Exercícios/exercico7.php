<?php
declare(strict_types=1);

function calcularMedia(array $notas): float
{
    $soma = 0;

    foreach ($notas as $nota) {
        $soma = $soma + $nota;
    }

    return $soma / count($notas);
}

function verificarAprovacao(float $media): string
{
    if ($media >= 7) {
        return "Aprovado";
    } else {
        return "Reprovado";
    }
}

$notas = [8, 7, 9];

$media = calcularMedia($notas);

echo $media . "\n";
echo verificarAprovacao($media);

