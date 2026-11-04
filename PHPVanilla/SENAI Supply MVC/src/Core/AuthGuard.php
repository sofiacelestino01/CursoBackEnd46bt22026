<?php
declare(strict_types=1);

namespace App\Core;

class AuthGuard
{
    public static function exigirLogin(): void
    {
        if (empty($_SESSION['usuario'])) {
            header('Location: /login');
            exit;
        }
    }

    public static function exigirPerfil(array $perfis): void
    {
        self::exigirLogin();

        $perfil = $_SESSION['usuario']['perfil'] ?? '';

        if (!in_array($perfil, $perfis, true)) {
            http_response_code(403);
            exit('403 - Você não tem permissão para acessar esta página.');
        }
    }
}
