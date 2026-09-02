<?php

declare(strict_types=1);

$usuario = [
    "nome" => "Carlos Eduardo",
    "idade" => 28,
    "cidade" => "Americana",
    "estado" => "SP",
    "premium" => true
];

echo "Nome: " . $usuario["nome"];

if ($usuario["premium"]) {
    echo " ⭐";
}

echo "\n";

echo "Idade: " . $usuario["idade"] . " anos";

echo "\n";

echo "Cidade: " . $usuario["cidade"] . " - " . $usuario["estado"];

echo "\n";

echo "Plano: ";

if ($usuario["premium"]) {
    echo "Premium";
} else {
    echo "Gratuito";
}

