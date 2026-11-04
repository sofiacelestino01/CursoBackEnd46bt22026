<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\ConexaoBanco;
use PDO;
use RuntimeException;

class Movimentacao
{
    public function listar(): array
    {
        $sql = 'SELECT m.*, p.nome AS produto, u.nome AS usuario
                FROM movimentacoes_estoque m
                JOIN produtos p ON p.id = m.produto_id
                LEFT JOIN usuarios u ON u.id = m.usuario_id
                ORDER BY m.criado_em DESC';

        return ConexaoBanco::conectar()->query($sql)->fetchAll();
    }

    public function registrar(
        int $produtoId,
        int $usuarioId,
        string $tipo,
        int $quantidade,
        string $observacao
    ): void {
        if (!in_array($tipo, ['entrada', 'saida'], true) || $quantidade <= 0) {
            throw new RuntimeException('Dados da movimentação inválidos.');
        }

        $pdo = ConexaoBanco::conectar();
        $pdo->beginTransaction();

        try {
            $stmt = $pdo->prepare(
                'SELECT quantidade FROM produtos WHERE id = :id FOR UPDATE'
            );
            $stmt->execute(['id' => $produtoId]);
            $produto = $stmt->fetch();

            if (!$produto) {
                throw new RuntimeException('Produto não encontrado.');
            }

            $atual = (int) $produto['quantidade'];
            $nova = $tipo === 'entrada'
                ? $atual + $quantidade
                : $atual - $quantidade;

            if ($nova < 0) {
                throw new RuntimeException('Estoque insuficiente.');
            }

            $stmt = $pdo->prepare(
                'UPDATE produtos SET quantidade = :quantidade WHERE id = :id'
            );
            $stmt->execute([
                'quantidade' => $nova,
                'id' => $produtoId
            ]);

            $stmt = $pdo->prepare(
                'INSERT INTO movimentacoes_estoque
                (produto_id, usuario_id, tipo, quantidade, observacao)
                VALUES (:produto, :usuario, :tipo, :quantidade, :observacao)'
            );
            $stmt->execute([
                'produto' => $produtoId,
                'usuario' => $usuarioId,
                'tipo' => $tipo,
                'quantidade' => $quantidade,
                'observacao' => $observacao
            ]);

            $pdo->commit();
        } catch (\Throwable $erro) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            throw $erro;
        }
    }
}
