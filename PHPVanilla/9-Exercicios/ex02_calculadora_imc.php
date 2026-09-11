<?php
declare(strict_types=1);

function calcularIMC(float $peso, float $altura): float
{
    return $peso / ($altura * $altura);
}

function classificarIMC(float $imc): string
{
    if ($imc < 18.5) {
        return "Abaixo do peso";
    }

    if ($imc < 25) {
        return "Normal";
    }

    if ($imc < 30) {
        return "Sobrepeso";
    }

    return "Obesidade";
}

$nome = $_POST["nome"] ?? "";
$peso = $_POST["peso"] ?? "";
$altura = $_POST["altura"] ?? "";

$erro = "";
$imc = null;
$classificacao = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!is_numeric($peso) || (float)$peso < 20 || (float)$peso > 300) {
        $erro = "O peso deve estar entre 20 e 300 kg.";
    } elseif (!is_numeric($altura) || (float)$altura < 0.5 || (float)$altura > 2.5) {
        $erro = "A altura deve estar entre 0.5 e 2.5 metros.";
    } else {
        $imc = calcularIMC((float)$peso, (float)$altura);
        $classificacao = classificarIMC($imc);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Calculadora de IMC</title>
</head>
<body>

<h1>Calculadora de IMC</h1>

<form method="POST">

    <label>Nome:</label>
    <input type="text" name="nome"
           value="<?= htmlspecialchars($nome) ?>">

    <br><br>

    <label>Peso (kg):</label>
    <input type="number" name="peso" step="0.1"
           value="<?= htmlspecialchars($peso) ?>">

    <br><br>

    <label>Altura (m):</label>
    <input type="number" name="altura" step="0.01"
           value="<?= htmlspecialchars($altura) ?>">

    <br><br>

    <button type="submit">Calcular</button>

</form>

<?php if ($erro !== ""): ?>

    <p style="color: red;">
        <?= htmlspecialchars($erro) ?>
    </p>

<?php endif; ?>

<?php if ($imc !== null): ?>

    <?php
    $estilo = "";

    if ($classificacao === "Normal") {
        $estilo = "green";
    } elseif ($classificacao === "Sobrepeso") {
        $estilo = "orange";
    } elseif ($classificacao === "Obesidade") {
        $estilo = "red";
    }
    ?>

    <div style="color: <?= $estilo ?>;">
        <h2>Resultado</h2>

        <p>
            <?= htmlspecialchars($nome) ?>,
            seu IMC é <?= number_format($imc, 2, ",", ".") ?>.
        </p>

        <p>
            Classificação:
            <?= htmlspecialchars($classificacao) ?>
        </p>
    </div>

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


