<?php 
 
declare(strict_types=1); 
 
function e(string $texto): string 
{ 
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8'); 
} 
 
$nome = $_POST['nome'] ?? ''; 
$mensagem = $_POST['mensagem'] ?? ''; 
$erro = ''; 
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    if (strlen(trim($nome)) < 3) { 
        $erro = 'Digite um nome com pelo menos 3 caracteres.'; 
    } elseif (strlen(trim($mensagem)) < 5) { 
        $erro = 'Digite uma mensagem com pelo menos 5 caracteres.'; 
    } 
} 
?> 
 
<!DOCTYPE html> 
<html lang="pt-BR"> 
<head> 
    <meta charset="UTF-8"> 
    <title>Mural de Recados</title>

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

        input,
        textarea {
            width: 90%;
            padding: 10px;
            border: 2px solid #ffb6d9;
            border-radius: 8px;
            font-size: 15px;
        }

        textarea {
            height: 100px;
            resize: none;
        }

        input:focus,
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
        }

        strong {
            color: #ff1493;
        }
    </style>
</head>

<body> 
 
<h1>Mural de Recados</h1> 
 
<form method="POST"> 
    <input type="text" name="nome" placeholder="Seu nome"> 
    <br><br> 
 
    <textarea name="mensagem" placeholder="Sua mensagem"></textarea> 
    <br><br> 
 
    <button type="submit">Enviar</button> 
</form> 
 
<p><?= e($erro) ?></p> 
 
<?php if ($erro === '' && $nome !== '' && $mensagem !== ''): ?> 
 
    <h2>Recado:</h2> 
 
    <p> 
        <strong><?= e($nome) ?>:</strong> 
        <?= nl2br(e($mensagem)) ?> 
    </p> 
 
<?php endif; ?> 
 
</body> 
</html>



