<?php
declare(strict_types=1);

namespace App\Core;

class Logger
{
    public static function registrar(
        string $nivel,
        string $mensagem,
        array $contexto = []
    ): void {
        $arquivo = dirname(__DIR__, 2) . '/logs/app.log';

        $registro = [
            'data' => date('Y-m-d H:i:s'),
            'nivel' => strtoupper($nivel),
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'desconhecido',
            'mensagem' => $mensagem,
            'contexto' => $contexto
        ];

        file_put_contents(
            $arquivo,
            json_encode($registro, JSON_UNESCAPED_UNICODE) . PHP_EOL,
            FILE_APPEND | LOCK_EX
        );
    }
}
