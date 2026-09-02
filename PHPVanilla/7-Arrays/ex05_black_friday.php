<?php

declare(strict_types=1);

$carrinho = [
    ["produto" => "Notebook", "preco" => 4000.00],
    ["produto" => "Mouse", "preco" => 150.00],
    ["produto" => "Teclado", "preco" => 300.00]
];

$carrinhoBlackFriday = array_map(
    function($item) {

        $item["preco"] = $item["preco"] * 0.80;

        return $item;
    },
    $carrinho
);

foreach ($carrinhoBlackFriday as $item) {

    echo "Produto: " . $item["produto"];
    echo "\n";

    echo "Preço: R$ " . $item["preco"];
    echo "\n";
}

