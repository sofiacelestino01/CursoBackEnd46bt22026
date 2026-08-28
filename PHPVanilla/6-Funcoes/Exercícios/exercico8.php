
<?php
declare(strict_types=1);

function limparCPF(string $cpf): string
{
    $cpf = str_replace(".", "", $cpf);
    $cpf = str_replace("-", "", $cpf);

    return $cpf;
}

function cpfValido(string $cpf): bool
{
    return strlen($cpf) == 11 && is_numeric($cpf);
}

$cpf = limparCPF("123.456.789-00");

echo $cpf . "\n";

if (cpfValido($cpf)) {
    echo "CPF valido";
} else {
    echo "CPF invalido";
}

