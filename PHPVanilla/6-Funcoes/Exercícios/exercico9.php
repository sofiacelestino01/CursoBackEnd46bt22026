
<?php
declare(strict_types=1);

function buscarCliente(array $clientes, string $nome): ?array
{
    foreach ($clientes as $cliente) {
        if ($cliente["nome"] == $nome) {
            return $cliente;
        }
    }

    return null;
}

$clientes = [
    ["nome" => "Sofia"],
    ["nome" => "Maria"]
];

$cliente = buscarCliente($clientes, "Sofia");

if ($cliente != null) {
    echo "Cliente encontrado";
} else {
    echo "Cliente nao encontrado";
}

