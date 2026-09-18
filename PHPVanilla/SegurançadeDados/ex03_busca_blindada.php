<?php

declare(strict_types=1);

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

$busca = $_GET['q'] ?? '';

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Busca de Produtos</title>

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
            font-size: 17px;
        }
    </style>
</head>

<body>

<h1>Buscar Produto</h1>

<form method="GET">
    <input
        type="text"
        name="q"
        value="<?= e($busca) ?>"
        placeholder="Digite um produto"
    >

    <br><br>

    <button type="submit">Buscar</button>
</form>

<?php if ($busca !== ''): ?>
    <p>Você buscou por: <?= e($busca) ?></p>
<?php endif; ?>

</body>
</html>



