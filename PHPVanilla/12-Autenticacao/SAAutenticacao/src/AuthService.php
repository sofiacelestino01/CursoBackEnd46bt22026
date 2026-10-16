<?php
declare(strict_types=1);

// Classe para verificação de usuários através da autenticação,
// criação de sessão e cookies do navegador.
final class AuthService
{
    private const TEMPO_INATIVIDADE_SEG = 900; // 15 minutos

    // Iniciar sessão de forma segura
    public static function iniciarSessaoSegura(): void
    {
        // Verifica se a sessão ainda não foi iniciada
        if (session_status() === PHP_SESSION_NONE) {

            // Define os parâmetros do cookie antes de iniciar a sessão
            session_set_cookie_params([
                "lifetime" => 0,
                "path" => "/",
                "httponly" => true,
                "samesite" => "Lax"
            ]);

            // Inicia a sessão
            session_start();
        }
    }

    // Gravar os dados do usuário na sessão
    public static function autenticar(array $usuario): void
    {
        self::iniciarSessaoSegura();

        // Gera um novo identificador de sessão por segurança
        session_regenerate_id(true);

        // Armazena os dados do usuário
        $_SESSION["usuario_id"] = (int) $usuario["id"];
        $_SESSION["usuario_nome"] = (string) $usuario["nome"];
        $_SESSION["usuario_email"] = (string) $usuario["email"];
        $_SESSION["usuario_perfil"] = (string) $usuario["perfil"];
        $_SESSION["ultimo_acesso"] = time();
    }

    // Verificar o tempo de inatividade
    public static function verificarExpiracao(): bool
    {
        self::iniciarSessaoSegura();

        // Se não houver registro de acesso, considera a sessão expirada
        if (!isset($_SESSION["ultimo_acesso"])) {
            return true;
        }

        // Verifica se ultrapassou o tempo limite de inatividade
        if ((time() - (int) $_SESSION["ultimo_acesso"]) > self::TEMPO_INATIVIDADE_SEG) {
            self::destruirSessao();
            return true;
        }

        // Atualiza o horário do último acesso
        $_SESSION["ultimo_acesso"] = time();

        return false;
    }

    // Destruir a sessão e limpar o cookie
    public static function destruirSessao(): void
    {
        self::iniciarSessaoSegura();

        // Limpa os dados armazenados na sessão
        $_SESSION = [];

        // Remove o cookie da sessão, se estiver habilitado
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                "",
                [
                    "expires" => time() - 42000,
                    "path" => $params["path"],
                    "domain" => $params["domain"],
                    "secure" => $params["secure"],
                    "httponly" => $params["httponly"],
                    "samesite" => $params["samesite"] ?? "Lax"
                ]
            );
        }

        // Encerra a sessão
        session_destroy();
    }
}
