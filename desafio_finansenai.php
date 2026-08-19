<?php

$categoriaCliente = "A";
$saldoDevedor = 1000.00;
$mesesAtraso = 12;

//RDefinir a Taxa de Juros de Acordo com a Classsificação do Cliente
$txJuros = match ($categoriaCliente) {
    "A" => 0.01 ,
    "B" => 0.02 ,
    "C" => 0.03 ,
    default => 0.05
};

//Demonstrar a Evolução da Divida ao Longo de 12 meses

for ($i=1; $i <= $mesesAtraso; $i++) { 

    //Regra Especial : Anistia no mês do juros 6
    if($i===6){
        echo "\nValor ao final do mês $i " . number_format($saldoDevedor,2,",",".");
        continue;
    }
    $jurosMes = $saldoDevedor * $txJuros;
    $saldoDevedor = $saldoDevedor + $jurosMes;

    

    echo "\nValor ao final do mês $i " . number_format($saldoDevedor,2,",",".");
}
