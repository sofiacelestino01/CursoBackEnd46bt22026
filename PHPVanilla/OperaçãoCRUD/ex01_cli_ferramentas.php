<?php

declare(strict_types=1);

require_once 'database.php';

// Executa o menu interativo no terminal.
while (true) {
    echo "\n1 - Cadastrar ferramenta\n2 - Listar ferramentas ativas\n3 - Sair\n";
    $opcao = trim((string) fgets(STDIN));

    if ($opcao === '1') {
        echo 'Nome da ferramenta: ';
        $nome = trim((string) fgets(STDIN));
        $stmt = $pdo->prepare('INSERT INTO ferramentas (nome, ativo) VALUES (:nome, TRUE)');
        $stmt->execute([':nome' => $nome]);
        echo "Ferramenta cadastrada!\n";
    } elseif ($opcao === '2') {
        $stmt = $pdo->prepare('SELECT id, nome FROM ferramentas WHERE ativo = TRUE ORDER BY id');
        $stmt->execute();

        foreach ($stmt->fetchAll() as $ferramenta) {
            echo $ferramenta['id'] . ' - ' . $ferramenta['nome'] . "\n";
        }
    } elseif ($opcao === '3') {
        break;
    } else {
        echo "Opção inválida!\n";
    }
}