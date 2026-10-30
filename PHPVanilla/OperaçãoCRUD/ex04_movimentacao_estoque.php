<?php

declare(strict_types=1);

require_once 'database.php';
require_once 'PecaDAO.php';

// Testa uma saída de cinco unidades da peça de ID 1.
$dao = new PecaDAO($pdo);
$resultado = $dao->registrarMovimentacao(1, 5, 'saida');

echo $resultado
    ? 'Movimentação registrada com sucesso.'
    : 'Movimentação cancelada ou inválida.';