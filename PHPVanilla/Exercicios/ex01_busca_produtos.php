<?php
declare(strict_types=1);

$produtos = [
    ["nome" => "Notebook", "categoria" => "Informática", "preco" => 3500],
    ["nome" => "Mouse", "categoria" => "Acessórios", "preco" => 80],
    ["nome" => "Teclado", "categoria" => "Acessórios", "preco" => 150],
    ["nome" => "Monitor", "categoria" => "Informática", "preco" => 900],
    ["nome" => "Celular", "categoria" => "Eletrônicos", "preco" => 2000],
    ["nome" => "Fone", "categoria" => "Eletrônicos", "preco" => 250]
];

$nome = $_GET["nome"] ?? "";
$precoMaximo = $_GET["preco_maximo"] ?? "";

$resultados = $produtos;

if ($nome !== "" || $precoMaximo !== "") {
    $resultados = array_filter($produtos, function ($produto) use ($nome, $precoMaximo) {
        $nomeOk = $nome === "" || stripos($produto["nome"], $nome) !== false;
        $precoOk = $precoMaximo === "" || $produto["preco"] <= (float)$precoMaximo;

        return $nomeOk && $precoOk;
    });
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Busca de Produtos</title>
</head>
<body>

<h1>Catálogo de Produtos</h1>

<form method="GET">
    <label>Nome do produto:</label>
    <input type="text" name="nome" value="<?= htmlspecialchars($nome) ?>">

    <label>Preço máximo:</label>
    <input type="number" name="preco_maximo" step="0.01"
           value="<?= htmlspecialchars($precoMaximo) ?>">

    <button type="submit">Buscar</button>
</form>

<hr>

<?php if (count($resultados) > 0): ?>

    <?php foreach ($resultados as $produto): ?>

        <p>
            <strong><?= htmlspecialchars($produto["nome"]) ?></strong><br>
            Categoria: <?= htmlspecialchars($produto["categoria"]) ?><br>
            Preço: R$ <?= number_format($produto["preco"], 2, ",", ".") ?>
        </p>

    <?php endforeach; ?>

<?php else: ?>

    <p>Nenhum produto encontrado.</p>

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