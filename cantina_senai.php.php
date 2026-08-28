```php
<?php

$produtos = [
    1 => ["nome" => "Coxinha", "preco" => 6, "estoque" => 10],
    2 => ["nome" => "Suco", "preco" => 5, "estoque" => 8],
    3 => ["nome" => "Sanduíche", "preco" => 12, "estoque" => 5],
    4 => ["nome" => "Bolo", "preco" => 7.5, "estoque" => 6]
];

$pedido = [];
$opcao = 0;

do {

    echo "\n1 - Listar produtos";
    echo "\n2 - Adicionar produto";
    echo "\n3 - Ver pedido";
    echo "\n4 - Finalizar compra";
    echo "\n0 - Sair\n";

    $opcao = (int) readline("Escolha: ");

    match ($opcao) {

        1 => print("Produtos listados!\n"),

        2 => print("Adicionar produto!\n"),

        3 => print("Resumo do pedido!\n"),

        4 => print("Compra finalizada!\n"),

        0 => print("Saindo...\n"),

        default => print("Opção inválida!\n")
    };


    // LISTAR PRODUTOS
    if ($opcao == 1) {

        foreach ($produtos as $codigo => $produto) {
            echo "$codigo - " . $produto["nome"];
            echo " | R$ " . $produto["preco"];
            echo " | Estoque: " . $produto["estoque"] . "\n";
        }
    }


    // ADICIONAR PRODUTO
    elseif ($opcao == 2) {

        $codigo = (int) readline("Código do produto: ");

        if (!isset($produtos[$codigo])) {
            echo "Produto não existe!\n";
            continue;
        }

        $quantidade = 0;

        while (
            $quantidade <= 0 ||
            $quantidade > $produtos[$codigo]["estoque"]
        ) {

            $quantidade = (int) readline("Quantidade: ");

            if ($quantidade <= 0) {
                echo "Quantidade inválida!\n";
            }

            elseif ($quantidade > $produtos[$codigo]["estoque"]) {
                echo "Estoque insuficiente!\n";
            }
        }

        $produtos[$codigo]["estoque"] -= $quantidade;

        $pedido[] = [
            "nome" => $produtos[$codigo]["nome"],
            "preco" => $produtos[$codigo]["preco"],
            "quantidade" => $quantidade
        ];

        echo "Produto adicionado!\n";
    }


    // VER PEDIDO
    elseif ($opcao == 3) {

        if (empty($pedido)) {
            echo "Pedido vazio!\n";
        }

        else {

            foreach ($pedido as $item) {

                $subtotal =
                    $item["preco"] * $item["quantidade"];

                echo $item["nome"] .
                    " - Quantidade: " . $item["quantidade"] .
                    " - Subtotal: R$ " . $subtotal . "\n";
            }
        }
    }


    // FINALIZAR
    elseif ($opcao == 4) {

        $total = 0;

        for ($i = 0; $i < count($pedido); $i++) {
            $total +=
                $pedido[$i]["preco"] *
                $pedido[$i]["quantidade"];
        }

        echo "Total: R$ $total\n";

        $pagamento = (int) readline(
            "1-Pix 2-Cartão 3-Dinheiro: "
        );

        $final = match ($pagamento) {
            1 => $total * 0.95,
            2 => $total,
            3 => $total * 0.97,
            default => 0
        };

        if ($final == 0) {
            echo "Pagamento inválido!\n";
        } else {
            echo "Valor final: R$ $final\n";
        }

        break;
    }


    // SAIR
    elseif ($opcao == 0) {
        echo "Saindo...\n";
        break;
    }


    // OPÇÃO INVÁLIDA
    else {
        echo "Opção inválida!\n";
        continue;
    }

} while (true);

?>
```
