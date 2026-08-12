<?php 
declare(strict_types=1);

//Motor de Análise de Créditos

// Regras do Négocio:
// Regra da Idade: O cliente precisa ter 18 anos ou mais e menos de 70 anos 
// Regra da Parcela (renda): O valor da parcela do empréstimo NÃO pode ser maior que 30% da renda mensal do cliente
// Regra VIP: Se o cliente tiver um "Score de Crédito" maior que 800, ele tem aprovação automática Idade: O cliente precisa ter 18 anos ou mais e menos de 70 anos 
// Aprovaçaõ Final: O Crédito é liberado se (Regra1 e Regra2 forem superadas) OU Se (Regra 3 passar).

//1. Dados que vieram do aplicativo do celular do Cliente
$idadeCliente = 25;
$rendaMensal = 4000.00;
$valorEmprestimo = 10000.00;
$numeroParcelas = 24;
$scoreCredito = 750; //pontuação vai de 0 a 1000

//2. Cálculos Aritméticos
$taxaJuros = 0.02; //Juros e 2º ao mês
$valorJurostotal = $valorEmprestimo * $taxaJuros *$numeroParcelas; // Juros Simples
$valorTotalPagar = $valorEmprestimo + $valorJurostotal;
$valorParcela = $valorTotalPagar / $numeroParcelas;

//3. O Cérebro da Operação: Avaliação das Regras do Negócio
//Regra 1: Maior Igual a 18 e Menor que 70
$idadeValida = ($idadeCliente >= 18) && ($idadeCliente < 70);

//Regra 2: Parcela não pode ser maior que 30% da renda (renda*0.30)
$limiteRenda =  $rendaMensal * 0.30;
$rendaSuficiente =  $valorParcela <= $limiteRenda;

//Regra 3: ClienteVIP (Score > 800)
$isClienteVip = $scoreCredito > 800;

//Aprovação Final = idade e renda Verdadeiras ou é clienteVIP
$aprovado = ($idadeValida && $rendaSuficiente) || $isClienteVip;



?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avaliaçaõ de Crédito</title>
</head>
<body>
    <h2>Análise de Crédito</h2>
    <hr>
    <?php echo "<h4> Valor da Parcela: R$ ". number_format($valorParcela, 2,",","."). "</h4>"; ?>
     <h4>Idade Válida: <?php echo ($idadeValida ? "sim" : "não") ?></h4> 
     <h4>Renda Suficiente: <?php echo ($rendaSuficiente ? "sim" : "não") ?></h4>   
     <h4>Cliente VIP: <?php echo ($isClienteVip ? "sim" : "não") ?></h4>
     <h4>Resultado Final: <?php echo ($aprovado ? "sim" : "não") ?></h4>


</body>
</html>