<?php

declare(strict_types=1);

$peso = 85.5;
$altura = 1.75;

$imc = $peso / ($altura * $altura);


if ($imc < 18.5) {
    echo "Abaixo do Peso";
} elseif ($imc <= 24.9) {
    echo "Peso Normal";
} elseif ($imc <= 29.9) {
    echo "Sobrepeso";
} elseif ($imc <= 34.9) {
    echo "Obesidade Grau I";
} else {
    echo "Obesidade Grau II ou III";
}