<?php
declare(strict_types=1);

namespace App\Core;

class Controller
{
    protected function renderizar(string $view, array $dados = []): void
    {
        extract($dados);
        ob_start();
        require dirname(__DIR__) . '/Views/' . $view . '.php';
        $conteudo = ob_get_clean();
        require dirname(__DIR__) . '/Views/layout.php';
    }

    protected function redirecionar(string $rota): never
    {
        header('Location: ' . $rota);
        exit;
    }

    protected function validarCsrf(): void
    {
        $token = $_POST['_token'] ?? '';
        $sessao = $_SESSION['_token'] ?? '';

        if (!is_string($token) || !is_string($sessao) ||
            $sessao === '' || !hash_equals($sessao, $token)) {
            http_response_code(419);
            exit('Token de segurança inválido. Atualize a página.');
        }
    }

    protected function tokenCsrf(): string
    {
        if (empty($_SESSION['_token'])) {
            $_SESSION['_token'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['_token'];
    }
}
