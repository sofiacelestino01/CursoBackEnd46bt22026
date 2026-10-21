<?php
declare(strict_types=1);

// Valida se a senha possui a complexidade exigida
function validarSenha(string $senha): bool
{
    return strlen($senha) >= 8
        && preg_match('/[A-Z]/', $senha) === 1
        && preg_match('/[a-z]/', $senha) === 1
        && preg_match('/[0-9]/', $senha) === 1
        && preg_match('/[^a-zA-Z0-9]/', $senha) === 1;
}

echo "=== Cadastro de Colaborador ===" . PHP_EOL;

echo "Nome: ";
$nome = trim((string) fgets(STDIN));

echo "E-mail: ";
$email = trim((string) fgets(STDIN));

echo "Senha: ";
$senha = trim((string) fgets(STDIN));

if (!validarSenha($senha)) {
    echo "Senha inválida! Use 8 caracteres, maiúscula, minúscula, número e símbolo." . PHP_EOL;
    exit;
}

// Gera o hash seguro da senha
$hash = password_hash($senha, PASSWORD_ARGON2ID);

if ($hash === false) {
    exit("Não foi possível gerar o hash." . PHP_EOL);
}

echo "Dados validados com sucesso!" . PHP_EOL;
echo "Nome: " . $nome . PHP_EOL;
echo "E-mail: " . $email . PHP_EOL;
echo "Hash gerado: " . $hash . PHP_EOL;

// Integre aqui o cadastro usando a classe UsuarioDAO.
