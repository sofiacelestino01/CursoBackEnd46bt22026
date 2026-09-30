<?php

declare(strict_types=1);

// Carrega a classe de conexão
require_once "ConexaoBanco.php";

const ARQUIVO_CONFIG = __DIR__ . "/config/database.ini";

try {
    // Obtém a conexão duas vezes
    $conexao1 = ConexaoBanco::obterConexao(ARQUIVO_CONFIG);
    $conexao2 = ConexaoBanco::obterConexao(ARQUIVO_CONFIG);

    // Compara as duas instâncias
    $mesmaConexao = $conexao1 === $conexao2;

    echo "ID da conexão 1: " . spl_object_id($conexao1) . "\n";
    echo "ID da conexão 2: " . spl_object_id($conexao2) . "\n";

    if ($mesmaConexao) {
        echo "As duas variáveis usam a mesma conexão.\n";
        echo "Singleton funcionando corretamente!\n";
    } else {
        echo "Foram criadas conexões diferentes.\n";
    }
} catch (PDOException $e) {
    // Informa o erro sem mostrar detalhes internos
    echo "Não foi possível realizar o teste.\n";
}

