<?php

declare(strict_types=1);

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

function sanitizarTexto(string $dado): string
{
    return strip_tags(trim($dado));
}

function validarColaborador(array $dados): array
{
    $erros = [];

    if ($dados['nome'] === '') {
        $erros[] = 'Nome obrigatório.';
    }

    if (filter_var($dados['email'], FILTER_VALIDATE_EMAIL) === false) {
        $erros[] = 'E-mail inválido.';
    }

    if (filter_var($dados['matricula'], FILTER_VALIDATE_INT) === false) {
        $erros[] = 'Matrícula inválida.';
    }

    if (filter_var($dados['salario'], FILTER_VALIDATE_FLOAT) === false) {
        $erros[] = 'Salário inválido.';
    }

    return $erros;
}

$nome = sanitizarTexto($_POST['nome'] ?? '');
$email = sanitizarTexto($_POST['email'] ?? '');
$matricula = sanitizarTexto($_POST['matricula'] ?? '');
$salario = sanitizarTexto($_POST['salario'] ?? '');

$erros = validarColaborador([
    'nome' => $nome,
    'email' => $email,
    'matricula' => $matricula,
    'salario' => $salario
]);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Colaborador</title>

    <style>
        body {
            background-color: #ffeaf4;
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 40px;
        }

        h1 {
            color: #ff1493;
        }

        h2 {
            color: #ff1493;
        }

        form {
            background-color: white;
            width: 400px;
            margin: 20px auto;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(255, 20, 147, 0.15);
        }

        input {
            width: 90%;
            padding: 10px;
            margin-bottom: 15px;
            border: 2px solid #ffb6d9;
            border-radius: 8px;
            font-size: 15px;
        }

        input:focus {
            outline: none;
            border-color: #ff1493;
        }

        button {
            background-color: #ff1493;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #e6007e;
        }

        p {
            color: #555;
            font-size: 16px;
        }
    </style>
</head>

<body>

<h1>Cadastro de Colaborador</h1>

<form method="POST">
    <input name="nome" placeholder="Nome">

    <input name="email" placeholder="E-mail">

    <input name="matricula" placeholder="Matrícula">

    <input name="salario" placeholder="Salário">

    <button type="submit">Cadastrar</button>
</form>

<?php if (!empty($erros)): ?>

    <?php foreach ($erros as $erro): ?>
        <p><?= e($erro) ?></p>
    <?php endforeach; ?>

<?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>

    <h2>Cadastro realizado!</h2>
    <p>Nome: <?= e($nome) ?></p>
    <p>E-mail: <?= e($email) ?></p>
    <p>Matrícula: <?= e($matricula) ?></p>
    <p>Salário: <?= e($salario) ?></p>

<?php endif; ?>

</body>
</html>



