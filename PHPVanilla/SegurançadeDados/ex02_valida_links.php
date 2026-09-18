<?php

declare(strict_types=1);

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

$nome = $_POST['nome'] ?? '';
$url = $_POST['url'] ?? '';
$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($nome === '') {
        $erro = 'Digite seu nome.';
    } elseif (filter_var($url, FILTER_VALIDATE_URL) === false) {
        $erro = 'Digite uma URL válida.';
    } elseif (
        !str_starts_with($url, 'http://') &&
        !str_starts_with($url, 'https://')
    ) {
        $erro = 'Use apenas http:// ou https://.';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Validador de Links</title>

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
        }

        a {
            display: inline-block;
            background-color: #ff1493;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 8px;
        }

        a:hover {
            background-color: #e6007e;
        }
    </style>
</head>

<body>

<h1>Meu Portfólio</h1>

<form method="POST">
    <input type="text" name="nome" placeholder="Seu nome">
    <br><br>

    <input type="url" name="url" placeholder="Link do GitHub ou LinkedIn">
    <br><br>

    <button type="submit">Cadastrar</button>
</form>

<p><?= e($erro) ?></p>

<?php if ($erro === '' && $nome !== '' && $url !== ''): ?>

    <p><?= e($nome) ?></p>

    <a href="<?= e($url) ?>" target="_blank">
        Visitar Portfólio
    </a>

<?php endif; ?>

</body>
</html>




