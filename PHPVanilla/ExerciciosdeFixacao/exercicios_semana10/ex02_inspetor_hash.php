<?php
declare(strict_types=1);

// Recebe a senha pelo terminal
echo "Digite uma senha: ";
$senha = trim((string) fgets(STDIN));

// Gera o hash usando Argon2id
$hash = password_hash($senha, PASSWORD_ARGON2ID);

if ($hash === false) {
    exit("Erro ao gerar o hash." . PHP_EOL);
}

// Separa as partes do hash
$partes = explode('$', $hash);

echo PHP_EOL . "=== Inspetor de Hash ===" . PHP_EOL;
echo "Hash completo: " . $hash . PHP_EOL;
echo "Algoritmo: " . $partes[1] . PHP_EOL;

if ($partes[1] === 'argon2id') {
    echo "Versão e custos: " . $partes[2] . PHP_EOL;
    echo "Salt codificado: " . $partes[3] . PHP_EOL;
    echo "Hash final: " . $partes[4] . PHP_EOL;
} elseif ($partes[1] === '2y') {
    echo "Custo: " . $partes[2] . PHP_EOL;
    echo "Salt codificado: " . substr($partes[3], 0, 22) . PHP_EOL;
    echo "Hash final: " . substr($partes[3], 22) . PHP_EOL;
}

echo PHP_EOL . "O salt é gerado automaticamente pelo PHP." . PHP_EOL;
