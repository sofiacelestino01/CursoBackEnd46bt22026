<?php

declare(strict_types=1);

class PecaDAO
{
    public function __construct(private PDO $pdo)
    {
    }

    // Busca uma peça e bloqueia seu registro durante a transação.
    private function buscarEstoque(int $id): ?int
    {
        $sql = 'SELECT quantidade FROM pecas_industriais WHERE id = :id FOR UPDATE';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $resultado = $stmt->fetchColumn();

        return $resultado === false ? null : (int) $resultado;
    }

    // Registra uma entrada ou saída de estoque.
    public function registrarMovimentacao(int $pecaId, int $quantidade, string $tipo): bool
    {
        if ($quantidade <= 0 || !in_array($tipo, ['entrada', 'saida'], true)) {
            return false;
        }

        try {
            $this->pdo->beginTransaction();
            $saldo = $this->buscarEstoque($pecaId);

            if ($saldo === null || ($tipo === 'saida' && $saldo < $quantidade)) {
                $this->pdo->rollBack();
                return false;
            }

            $novoSaldo = $tipo === 'entrada' ? $saldo + $quantidade : $saldo - $quantidade;
            $this->atualizarEstoque($pecaId, $novoSaldo);
            $this->pdo->commit();

            return true;
        } catch (PDOException $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }

            return false;
        }
    }

    // Atualiza o saldo de uma peça específica.
    private function atualizarEstoque(int $id, int $quantidade): void
    {
        $sql = 'UPDATE pecas_industriais SET quantidade = :quantidade WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':quantidade' => $quantidade, ':id' => $id]);
    }

    // Desativa uma peça sem apagar seu histórico.
    public function excluir(int $id): bool
    {
        $sql = 'UPDATE pecas_industriais SET ativo = FALSE WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([':id' => $id]);
    }

    // Lista apenas peças ativas.
    public function listarTodos(): array
    {
        $sql = 'SELECT * FROM pecas_industriais WHERE ativo = TRUE ORDER BY id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}