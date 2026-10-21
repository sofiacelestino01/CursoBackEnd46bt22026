<?php
declare(strict_types=1);

session_start();

// Verifica a permissão mínima exigida
function verificarPermissao(string $perfilMinimo): void
{
    if (!isset($_SESSION['perfil'])) {
        http_response_code(403);
        exit("Acesso negado. Faça login para continuar.");
    }

    $perfis = ['OPERADOR' => 1, 'ADMIN' => 2];
    $perfilUsuario = $_SESSION['perfil'];

    if (!isset($perfis[$perfilUsuario])
        || !isset($perfis[$perfilMinimo])
        || $perfis[$perfilUsuario] < $perfis[$perfilMinimo]) {
        http_response_code(403);
        exit("Acesso negado. Você não tem permissão para esta página.");
    }
}

// Exemplo de teste
verificarPermissao('ADMIN');

echo "Acesso autorizado!";
