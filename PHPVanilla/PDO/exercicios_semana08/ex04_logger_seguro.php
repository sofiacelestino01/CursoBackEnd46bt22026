<?php

declare(strict_types=1);

// Registra mensagens no arquivo de log
function registrarLog(string $nivel, string $mensagem): void
{
    $arquivo = __DIR__ . "/logs/sistema.log";
    $data = date("Y-m-d H:i:s");

    $linha = "[$data] [$nivel] $mensagem" . PHP_EOL;

    file_put_contents($arquivo, $linha, FILE_APPEND);
}

// Cria o arquivo de log caso a pasta ainda não exista
function criarPastaLogs(): void
{
    $pasta = __DIR__ . "/logs";

    if (!is_dir($pasta)) {
        mkdir($pasta, 0777, true);
    }
}

criarPastaLogs();

try {
    // Simula uma conexão que funcionou
    $pdo = new PDO(
        "pgsql:host=127.0.0.1;port=5432;dbname=senai_dev",
        "postgres",
        "sua_senha"
    );

    registrarLog("INFO", "Conexão com o banco realizada.");
    echo "Conexão realizada com sucesso.";
} catch (PDOException $e) {
    // Registra o erro técnico somente no log
    registrarLog("ERROR", $e->getMessage());

    echo "Não foi possível conectar ao banco.";
}

