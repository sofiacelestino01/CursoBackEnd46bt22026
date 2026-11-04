<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Logger;
use App\Models\Usuario;

class AuthController extends Controller
{
    public function formulario(): void
    {
        $this->renderizar('login', ['token' => $this->tokenCsrf()]);
    }

    public function entrar(): void
    {
        $this->validarCsrf();

        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $senha = $_POST['senha'] ?? '';

        if (!$email || !is_string($senha)) {
            $this->redirecionar('/login');
        }

        $usuario = (new Usuario())->buscarPorEmail($email);

        if (!$usuario || !password_verify($senha, $usuario['senha'])) {
            Logger::registrar('WARNING', 'Falha de login', ['email' => $email]);
            $this->redirecionar('/login');
        }

        session_regenerate_id(true);

        $_SESSION['usuario'] = [
            'id' => (int) $usuario['id'],
            'nome' => $usuario['nome'],
            'email' => $usuario['email'],
            'perfil' => $usuario['perfil']
        ];

        Logger::registrar('INFO', 'Login realizado', [
            'usuario_id' => $usuario['id']
        ]);

        $this->redirecionar('/');
    }

    public function sair(): void
    {
        $this->validarCsrf();
        $_SESSION = [];
        session_regenerate_id(true);
        $this->redirecionar('/login');
    }
}
