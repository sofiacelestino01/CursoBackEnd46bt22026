<?php
declare(strict_types=1);

require 'conexao.php';

// Recebe o número da página.
$pagina = max(1, (int) ($_GET['p'] ?? 1));
$offset = ($pagina - 1) * 5;

// Busca cinco peças por página.
$stmt = $pdo->prepare(
    "SELECT id, nome FROM pecas_industriais
     ORDER BY id
     LIMIT :limite OFFSET :offset"
);

// Define os parâmetros como números inteiros.
$stmt->bindValue(':limite', 5, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();

// Exibe os resultados com escape de HTML.
function e(string $valor): string
{
    return htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
}

foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $peca) {
    echo e((string) $peca['id']) . ' - ';
    echo e((string) $peca['nome']) . "<br>\n";
}

echo '<a href="?p=' . ($pagina + 1) . '">Próxima página</a>';