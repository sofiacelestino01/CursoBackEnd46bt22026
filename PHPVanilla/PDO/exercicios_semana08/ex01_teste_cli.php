<?php

declare(strict_types=1);

// Carrega a classe de conexão
require_once "ConexaoBanco.php";

const ARQUIVO_CONFIG = __DIR__ . "/config/database.ini";

try {
    // Tenta criar a conexão com o banco
    $conexao = ConexaoBanco::obterConexao(ARQUIVO_CONFIG);

    // Consulta a versão do PostgreSQL
    $resultado = $conexao->query("SELECT version()");
    $versao = $resultado->fetchColumn();

    echo "Conexão realizada com sucesso!\n";
    echo "PostgreSQL acessível na porta 5432.\n";
    echo "Versão: " . $versao . "\n";
} catch (PDOException $e) {
    // Mostra uma mensagem simples para o terminal
    echo "Não foi possível conectar ao PostgreSQL.\n";
    echo "Verifique a porta, o banco e as configurações.\n";
}

