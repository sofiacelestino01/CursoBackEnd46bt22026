<?php
declare(strict_types=1);

session_start();

// Configura o cookie de sessão com proteção
// Estas opções devem ser definidas antes de session_start() em uma aplicação real.

// Inicializa os dados das tentativas
$_SESSION['tentativas_login'] ??= 0;
$_SESSION['bloqueado_ate'] ??= 0;

$agora = time();

if ($agora < $_SESSION['bloqueado_ate']) {
    $restante = $_SESSION['bloqueado_ate'] - $agora;
    exit("Login bloqueado. Tente novamente em $restante segundos.");
}

echo "Digite a senha: ";
$senha = trim((string) fgets(STDIN));

// Senha de exemplo para demonstrar a atividade
$hashExemplo = password_hash('Senha123!', PASSWORD_DEFAULT);

if (password_verify($senha, $hashExemplo)) {
    $_SESSION['tentativas_login'] = 0;
    $_SESSION['bloqueado_ate'] = 0;

    echo "Login realizado com sucesso!" . PHP_EOL;
} else {
    $_SESSION['tentativas_login']++;

    echo "Senha incorreta!" . PHP_EOL;

    if ($_SESSION['tentativas_login'] >= 3) {
        $_SESSION['bloqueado_ate'] = time() + 60;
        $_SESSION['tentativas_login'] = 0;

        echo "Você foi bloqueado por 60 segundos." . PHP_EOL;
    }
}
