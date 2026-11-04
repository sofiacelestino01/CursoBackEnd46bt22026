<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\ConexaoBanco;

class Produto
{
    public function listar(): array
    {
        return ConexaoBanco::conectar()
            ->query('SELECT * FROM produtos ORDER BY nome')
            ->fetchAll();
    }

    public function cadastrar(
        string $nome,
        string $descricao,
        int $quantidade,
        int $minimo
    ): void {
        $sql = 'INSERT INTO produtos (nome, descricao, quantidade, estoque_minimo)
                VALUES (:nome, :descricao, :quantidade, :minimo)';

        $stmt = ConexaoBanco::conectar()->prepare($sql);
        $stmt->execute([
            'nome' => $nome,
            'descricao' => $descricao,
            'quantidade' => $quantidade,
            'minimo' => $minimo
        ]);
    }
}
