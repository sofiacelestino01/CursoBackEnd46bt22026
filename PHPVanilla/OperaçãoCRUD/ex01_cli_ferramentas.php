<?php
declare(strict_types=1);

require 'conexao.php';

// Mostra o menu no terminal.
while (true) {
    echo "\n1 - Cadastrar ferramenta\n";
    echo "2 - Listar ferramentas ativas\n";
    echo "3 - Sair\n";
    echo "Escolha: ";

    $opcao = trim(fgets(STDIN));

    if ($opcao === '1') {
        echo "Nome da ferramenta: ";
        $nome = trim(fgets(STDIN));

        // Cadastra usando parâmetros nomeados.
        $stmt = $pdo->prepare(
            "INSERT INTO ferramentas (nome, ativo)
             VALUES (:nome, TRUE)"
        );
        $stmt->execute([':nome' => $nome]);

        echo "Ferramenta cadastrada!\n";
    } elseif ($opcao === '2') {
        // Lista somente ferramentas ativas.
        $stmt = $pdo->prepare(
            "SELECT id, nome FROM ferramentas
             WHERE ativo = TRUE ORDER BY id"
        );
        $stmt->execute();

        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $ferramenta) {
            echo $ferramenta['id'] . " - " . $ferramenta['nome'] . "\n";
        }
    } elseif ($opcao === '3') {
        echo "Programa encerrado!\n";
        break;
    } else {
        echo "Opção inválida!\n";
    }
}
