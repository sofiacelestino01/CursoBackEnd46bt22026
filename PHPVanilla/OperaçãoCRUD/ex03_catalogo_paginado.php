<?php

declare(strict_types=1);

require_once 'database.php';

// Escapa valores antes de exibi-los no HTML.
function e(string $valor): string
{
    return htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
}

// Calcula a página e o deslocamento.
$pagina = max(1, (int) ($_GET['p'] ?? 1));
$offset = ($pagina - 1) * 5;

// Consulta cinco peças por página.
$sql = 'SELECT id, nome, quantidade FROM pecas_industriais ORDER BY id LIMIT :limite OFFSET :offset';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':limite', 5, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$pecas = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Catálogo de peças</title>
</head>
<body>
    <h1>Catálogo de peças industriais</h1>

    <?php foreach ($pecas as $peca): ?>
        <p>
            <?= e((string) $peca['id']) ?> -
            <?= e((string) $peca['nome']) ?> -
            Estoque: <?= e((string) $peca['quantidade']) ?>
        </p>
    <?php endforeach; ?>

    <a href="?p=<?= max(1, $pagina - 1) ?>">Anterior</a>
    <a href="?p=<?= $pagina + 1 ?>">Próxima</a>
</body>
</html>