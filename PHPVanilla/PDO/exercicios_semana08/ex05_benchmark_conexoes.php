<?php

declare(strict_types=1);

require_once "ConexaoBanco.php";

const ARQUIVO_CONFIG = __DIR__ . "/config/database.ini";
const QUANTIDADE = 50;

// Cria uma nova conexão em cada repetição
function testarSemSingleton(): array
{
    $inicio = microtime(true);
    $memoriaInicial = memory_get_usage();
    $dados = parse_ini_file(ARQUIVO_CONFIG);

    for ($i = 0; $i < QUANTIDADE; $i++) {
        $dsn = "pgsql:host={$dados['db_host']};";
        $dsn .= "port={$dados['db_port']};";
        $dsn .= "dbname={$dados['db_name']}";

        $conexao = new PDO(
            $dsn,
            $dados["db_user"],
            $dados["db_password"],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_STRINGIFY_FETCHES => false
            ]
        );

        $conexao = null;
    }

    return medirResultado($inicio, $memoriaInicial);
}

// Reutiliza a mesma conexão
function testarComSingleton(): array
{
    $inicio = microtime(true);
    $memoriaInicial = memory_get_usage();

    $conexao = ConexaoBanco::obterConexao(ARQUIVO_CONFIG);

    for ($i = 0; $i < QUANTIDADE; $i++) {
        $conexao->query("SELECT 1");
    }

    return medirResultado($inicio, $memoriaInicial);
}

// Calcula tempo e memória utilizados
function medirResultado(float $inicio, int $memoriaInicial): array
{
    return [
        "tempo" => microtime(true) - $inicio,
        "memoria" => memory_get_usage() - $memoriaInicial
    ];
}

try {
    $semSingleton = testarSemSingleton();
    $comSingleton = testarComSingleton();
} catch (PDOException $e) {
    echo "Não foi possível realizar o teste.";
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Benchmark de Conexões</title>
</head>

<body>

    <h1>Benchmark de Conexões</h1>

    <table border="1" cellpadding="8">
        <tr>
            <th>Método</th>
            <th>Tempo (segundos)</th>
            <th>Memória (bytes)</th>
        </tr>

        <tr>
            <td>Nova conexão</td>
            <td><?= number_format($semSingleton["tempo"], 6) ?></td>
            <td><?= $semSingleton["memoria"] ?></td>
        </tr>

        <tr>
            <td>Singleton</td>
            <td><?= number_format($comSingleton["tempo"], 6) ?></td>
            <td><?= $comSingleton["memoria"] ?></td>
        </tr>
    </table>

</body>

</html>
