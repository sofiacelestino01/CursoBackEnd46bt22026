<?php
declare(strict_types=1);

namespace App\Core;

use PDO;

class ConexaoBanco
{
    public static function conectar(): PDO
    {
        static $pdo = null;

        if ($pdo === null) {
            $host = getenv('DB_HOST') ?: '127.0.0.1';
            $port = getenv('DB_PORT') ?: '5432';
            $nome = getenv('DB_NAME') ?: 'senai_supply';
            $usuario = getenv('DB_USER') ?: 'postgres';
            $senha = getenv('DB_PASS') ?: '';

            $pdo = new PDO(
                "pgsql:host=$host;port=$port;dbname=$nome",
                $usuario,
                $senha,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        }

        return $pdo;
    }
}
