<?php

declare(strict_types=1);

// Carrega uma seção específica do arquivo INI
function carregarAmbiente(string $ambiente): array
{
    $arquivo = __DIR__ . "/config/database.ini";
    $configuracao = parse_ini_file($arquivo, true);

    if (!isset($configuracao[$ambiente])) {
        throw new RuntimeException("Ambiente não encontrado.");
    }

    return $configuracao[$ambiente];
}

// Cria a conexão usando o ambiente escolhido
function conectarAmbiente(string $ambiente): PDO
{
    $dados = carregarAmbiente($ambiente);

    $dsn = "pgsql:host={$dados['db_host']};";
    $dsn .= "port={$dados['db_port']};dbname={$dados['db_name']}";

    return new PDO($dsn, $dados["db_user"], $dados["db_password"], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_STRINGIFY_FETCHES => false
    ]);
}

try {
    // Escolhe o ambiente que será utilizado
    $conexao = conectarAmbiente("development");

    echo "Ambiente conectado com sucesso!\n";
} catch (PDOException $e) {
    // Mostra somente uma mensagem segura
    echo "Não foi possível conectar ao ambiente.\n";
}

