<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\ConexaoBanco;
use PDO;

//classe de conexão com o BD e Regras de Negócio

final class Usuario {
    //classe ligada a tabela de Usuário

    //método de Conexão com o BD
    private static function pdo(): PDO {
        $cfg = dirname(__DIR__,2) . "/config/database.ini"; //caminho das configurações do BD
        return ConexaoBanco::obterConexao($cfg);
    }

    //método para localizar o usuario por email
    public static function buscarPorEmail(string $email): ?array {
        //? pode ou não ter retorno de dados do usuario (aceita nulo)
        $sql = "SELECT id, nome, email, senha_hash, perfil FROM usuarios WHERE email = :email LIMIT 1";
        $stmt = self::pdo()->prepare($sql);
        $stmt->execute([':email' => trim($email)]);
        $resultado = $stmt->fetch();
        return $resultado ?: null;
    }
}