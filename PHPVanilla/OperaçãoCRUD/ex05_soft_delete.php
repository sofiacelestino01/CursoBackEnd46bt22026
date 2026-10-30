<?php

declare(strict_types=1);

require_once 'database.php';
require_once 'PecaDAO.php';

// Desativa uma peça sem remover o registro.
$dao = new PecaDAO($pdo);
$id = 1;

if ($dao->excluir($id)) {
    echo "Peça desativada.\n";
} else {
    echo "Não foi possível desativar a peça.\n";
}

// Confere se o registro continua armazenado.
$stmt = $pdo->prepare(
    'SELECT id, nome, ativo FROM pecas_industriais WHERE id = :id'
);
$stmt->execute([':id' => $id]);
$peca = $stmt->fetch();

if ($peca !== false) {
    echo 'Registro preservado: ' . $peca['nome'] . "\n";
    echo 'Ativo: ' . ($peca['ativo'] ? 'Sim' : 'Não') . "\n";
}
