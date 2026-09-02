<?php

declare(strict_types=1);

$funcionarios = [
    ["id" => 1, "nome" => "Ana Souza", "cargo" => "Dev Front-End", "salario" => 4500.00],
    ["id" => 2, "nome" => "Bruno Costa", "cargo" => "Dev Back-End", "salario" => 5200.00],
    ["id" => 3, "nome" => "Carla Dias", "cargo" => "Tech Lead", "salario" => 8900.00],
    ["id" => 4, "nome" => "Daniel Silva", "cargo" => "Estagiário", "salario" => 1500.00]
];

$totalFolha = 0;

foreach ($funcionarios as $funcionario) {

    echo "Nome: " . $funcionario["nome"];
    echo "\n";

    echo "Cargo: " . $funcionario["cargo"];
    echo "\n";

    echo "Salário: R$ " . $funcionario["salario"];
    echo "\n";

    $totalFolha = $totalFolha + $funcionario["salario"];
}

echo "Total gasto pela empresa: R$ " . $totalFolha;


