<?php
declare(strict_types=1);

$email = $_POST["email"] ?? "";
$senha = $_POST["senha"] ?? "";

$erro = "";
$loginRealizado = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $erro = "Digite um e-mail válido.";
    } elseif (strlen($senha) < 6) {
        $erro = "A senha deve ter no mínimo 6 caracteres.";
    } elseif ($email === "admin@senai.br" && $senha === "senhaSegura123") {
        $loginRealizado = true;
    } else {
        $erro = "Credenciais inválidas";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login Seguro</title>
</head>
<body>

<h1>Login</h1>

<?php if ($loginRealizado): ?>

    <div>
        <h2>Bem-vindo!</h2>
        <p>Login realizado com sucesso.</p>
    </div>

<?php else: ?>

    <form method="POST">

        <label>E-mail:</label>
        <input type="email" name="email"
               value="<?= htmlspecialchars($email) ?>">

        <br><br>

        <label>Senha:</label>
        <input type="password" name="senha">

        <br><br>

        <button type="submit">Entrar</button>

    </form>

    <?php if ($erro !== ""): ?>

        <p style="color: red;">
            <?= htmlspecialchars($erro) ?>
        </p>

    <?php endif; ?>

<?php endif; ?>

</body>
</html>
<style>
    body {
        background-color: #f7cfdf;
        font-family: Arial;
    }

    h1 {
        color: #ff1493;
    }

    h2 {
        color: #ff1493;
    }

    button {
        background-color: #ff1493;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 5px;
    }

    input {
        padding: 7px;
        border: 1px solid #ff1493;
        border-radius: 5px;
    }

    select {
        padding: 7px;
        border: 1px solid #ff1493;
        border-radius: 5px;
    }
</style>