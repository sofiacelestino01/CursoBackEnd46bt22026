<?php

declare(strict_types=1);

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

$arquivo = 'chat.json';
$mensagem = trim($_POST['mensagem'] ?? '');
$erro = '';

$mensagens = file_exists($arquivo)
    ? json_decode(file_get_contents($arquivo), true)
    : [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($mensagem === '') {
        $erro = 'Digite uma mensagem.';
    } elseif (strlen($mensagem) > 250) {
        $erro = 'A mensagem deve ter no máximo 250 caracteres.';
    } else {
        $mensagens[] = $mensagem;
        file_put_contents($arquivo, json_encode($mensagens));
        $mensagem = '';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Chat da Operação</title>

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

        textarea {
            width: 90%;
            height: 100px;
            padding: 10px;
            border: 2px solid #ffb6d9;
            border-radius: 8px;
            font-size: 15px;
            resize: none;
        }

        textarea:focus {
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

<h1>Chat da Operação</h1>

<form method="POST">
    <textarea name="mensagem" placeholder="Digite sua mensagem"></textarea>
    <br><br>

    <button type="submit">Enviar</button>
</form>

<p><?= e($erro) ?></p>

<?php foreach ($mensagens as $msg): ?>
    <p><?= nl2br(e($msg)) ?></p>
<?php endforeach; ?>

</body>
</html>



