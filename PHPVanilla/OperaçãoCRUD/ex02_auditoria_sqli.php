<?php
declare(strict_types=1);

require 'conexao.php';

// Consulta vulnerável, somente para demonstração.
function buscarVulneravel(PDO $pdo, string $termo): void
{
    $sql = "SELECT * FROM ferramentas WHERE nome = '$termo'";
    $resultado = $pdo->query($sql);

    echo "Vulnerável: " . $resultado->rowCount() . " registros.\n";
}

// Consulta protegida com parâmetro nomeado.
function buscarProtegido(PDO $pdo, string $termo): void
{
    $stmt = $pdo->prepare(
        "SELECT * FROM ferramentas WHERE nome = :nome"
    );
    $stmt->execute([':nome' => $termo]);

    echo "Protegido: " . $stmt->rowCount() . " registros.\n";
}

// Compara os dois métodos com o mesmo texto.
$termo = "' OR '1'='1";

buscarVulneravel($pdo, $termo);
buscarProtegido($pdo, $termo);