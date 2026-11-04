<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\ConexaoBanco;

class Usuario
{
    public function buscarPorEmail(string $email): array|false
    {
        $sql = 'SELECT * FROM usuarios WHERE email = :email LIMIT 1';
        $stmt = ConexaoBanco::conectar()->prepare($sql);
        $stmt->execute(['email' => $email]);

        return $stmt->fetch();
    }
}
