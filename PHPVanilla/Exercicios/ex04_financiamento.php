<?php
declare(strict_types=1);

$valorVeiculo = $_POST["valor_veiculo"] ?? "";
$valorEntrada = $_POST["valor_entrada"] ?? "";
$numeroParcelas = $_POST["numero_parcelas"] ?? "";

$erro = "";
$valorFinanciado = 0;
$totalJuros = 0;
$valorParcela = 0;

$parcelasPermitidas = [12, 24, 36, 48, 60];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!is_numeric($valorVeiculo) || (float)$valorVeiculo <= 0) {
        $erro = "Informe um valor válido para o veículo.";
    } elseif (!is_numeric($valorEntrada) || (float)$valorEntrada < 0) {
        $erro = "Informe uma entrada válida.";
    } elseif ((float)$valorEntrada < (float)$valorVeiculo * 0.20) {
        $erro = "A entrada deve ser de pelo menos 20% do valor do veículo.";
    } elseif (!in_array((int)$numeroParcelas, $parcelasPermitidas)) {
        $erro = "Número de parcelas inválido.";
    } else {

        $valorFinanciado = (float)$valorVeiculo - (float)$valorEntrada;

        $totalJuros = $valorFinanciado * 0.015 * (int)$numeroParcelas;

        $totalFinanciado = $valorFinanciado + $totalJuros;

        $valorParcela = $totalFinanciado / (int)$numeroParcelas;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Financiamento</title>
</head>
<body>

<h1>Financiamento de Veículos</h1>

<form method="POST">

    <label>Valor do veículo:</label>
    <input type="number" name="valor_veiculo" step="0.01"
           value="<?= htmlspecialchars($valorVeiculo) ?>">

    <br><br>

    <label>Valor da entrada:</label>
    <input type="number" name="valor_entrada" step="0.01"
           value="<?= htmlspecialchars($valorEntrada) ?>">

    <br><br>

    <label>Número de parcelas:</label>

    <select name="numero_parcelas">

        <option value="">Selecione</option>

        <option value="12">12</option>
        <option value="24">24</option>
        <option value="36">36</option>
        <option value="48">48</option>
        <option value="60">60</option>

    </select>

    <br><br>

    <button type="submit">Calcular</button>

</form>

<?php if ($erro !== ""): ?>

    <p style="color: red;">
        <?= htmlspecialchars($erro) ?>
    </p>

<?php elseif ($_SERVER["REQUEST_METHOD"] === "POST"): ?>

    <h2>Memória de Cálculo</h2>

    <p>
        Valor Financiado:
        R$ <?= number_format($valorFinanciado, 2, ",", ".") ?>
    </p>

    <p>
        Total de Juros:
        R$ <?= number_format($totalJuros, 2, ",", ".") ?>
    </p>

    <p>
        Valor de Cada Parcela:
        R$ <?= number_format($valorParcela, 2, ",", ".") ?>
    </p>

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
