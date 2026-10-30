<?php

declare(strict_types=1);

require_once 'database.php';

// Demonstra a consulta vulnerável à injeção SQL.
function buscarVulneravel(string $termo): void
{
    global $pdo;

    $sql = "SELECT id, nome FROM ferramentas WHERE nome = '$termo'";
    $resultado = $pdo->query($sql);
    echo 'Vulnerável: ' . $resultado->rowCount() . " registro(s).\n";
}

// Demonstra a consulta protegida com parâmetro.
function buscarProtegido(string $termo): void
{
    global $pdo;

    $stmt = $pdo->prepare('SELECT id, nome FROM ferramentas WHERE nome = :nome');
    $stmt->execute([':nome' => $termo]);
    echo 'Protegido: ' . $stmt->rowCount() . " registro(s).\n";
}

// Compara o comportamento das duas consultas.
$termo = "' OR '1'='1";
buscarVulneravel($termo);
buscarProtegido($termo);