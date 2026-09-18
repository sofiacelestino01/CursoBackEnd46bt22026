<?php
declare(strict_types=1);

$nome = $_POST["nome_candidato"] ?? "";
$idade = $_POST["idade"] ?? "";
$curso = $_POST["curso_desejado"] ?? "";

$erroNome = "";
$erroIdade = "";
$erroCurso = "";
$erroTermos = "";

$cursosPermitidos = [
    "Desenvolvimento de Sistemas",
    "Mecatrônica",
    "Redes"
];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (strlen(trim($nome)) < 5) {
        $erroNome = "O nome deve ter pelo menos 5 caracteres.";
    }

    if (!is_numeric($idade) || (int)$idade < 16) {
        $erroIdade = "A idade deve ser maior ou igual a 16 anos.";
    }

    if (!in_array($curso, $cursosPermitidos)) {
        $erroCurso = "Selecione um curso válido.";
    }

    if (!isset($_POST["aceite_termos"])) {
        $erroTermos = "Você deve aceitar os termos.";
    }
}

$temErros = $erroNome !== "" ||
            $erroIdade !== "" ||
            $erroCurso !== "" ||
            $erroTermos !== "";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Inscrição SENAI</title>
</head>
<body>

<h1>Inscrição - Cursos Técnicos SENAI</h1>

<form method="POST">

    <label>Nome do candidato:</label>
    <input type="text"
           name="nome_candidato"
           value="<?= htmlspecialchars($nome) ?>">

    <?php if ($erroNome !== ""): ?>
        <p style="color: red;">
            <?= htmlspecialchars($erroNome) ?>
        </p>
    <?php endif; ?>

    <br>

    <label>Idade:</label>
    <input type="number"
           name="idade"
           value="<?= htmlspecialchars($idade) ?>">

    <?php if ($erroIdade !== ""): ?>
        <p style="color: red;">
            <?= htmlspecialchars($erroIdade) ?>
        </p>
    <?php endif; ?>

    <br>

    <label>Curso desejado:</label>

    <select name="curso_desejado">

        <option value="">Selecione um curso</option>

        <option value="Desenvolvimento de Sistemas">
            Desenvolvimento de Sistemas
        </option>

        <option value="Mecatrônica">
            Mecatrônica
        </option>

        <option value="Redes">
            Redes
        </option>

    </select>

    <?php if ($erroCurso !== ""): ?>
        <p style="color: red;">
            <?= htmlspecialchars($erroCurso) ?>
        </p>
    <?php endif; ?>

    <br>

    <label>
        <input type="checkbox" name="aceite_termos">
        Aceito os termos.
    </label>

    <?php if ($erroTermos !== ""): ?>
        <p style="color: red;">
            <?= htmlspecialchars($erroTermos) ?>
        </p>
    <?php endif; ?>

    <br>

    <button type="submit">Enviar inscrição</button>

</form>

<?php if ($_SERVER["REQUEST_METHOD"] === "POST" && !$temErros): ?>

    <h2>Inscrição realizada com sucesso!</h2>

    <p>
        Candidato:
        <?= htmlspecialchars($nome) ?>
    </p>

    <p>
        Curso:
        <?= htmlspecialchars($curso) ?>
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