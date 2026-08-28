
<?php
declare(strict_types=1);

function aplicarDesconto(float &$preco, float $porcentagem): void
{
    $preco = $preco - ($preco * $porcentagem / 100);
}

$preco = 200.0;

echo "Antes: " . $preco . "\n";

aplicarDesconto($preco, 15.0);

echo "Depois: " . $preco;

