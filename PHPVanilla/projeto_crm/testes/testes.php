<?php
// =============================================================
// testes/testes.php — Testes da biblioteca utilitarios.php
// Executar: php testes/testes.php (ou abrir no navegador)
// =============================================================

declare(strict_types=1);

require_once __DIR__ . '/../utilitarios.php';

$falhas = 0;
$testes = [];

/**
 * Função auxiliar que registra o resultado de um teste.
 */
function testar(string $descricao, bool $resultado): void
{
    global $testes, $falhas;
    if (!$resultado) {
        $falhas++;
    }
    $testes[] = [
        'descricao' => $descricao,
        'resultado' => $resultado ? 'PASSOU' : 'FALHOU',
    ];
}

// -------------------------------------------------------------
// Dados de teste
// -------------------------------------------------------------
$clientes = [
    ['nome' => '  ANA CLARA SILVA ', 'cpf' => '123.456.789-00', 'email' => 'ana.clara@email.com', 'contrato' => 1500.00, 'ativo' => true],
    ['nome' => 'Carlos Souza',       'cpf' => '987.654.321-00', 'email' => 'carlos.souza@email.com', 'contrato' => 850.50, 'ativo' => false],
];

// -------------------------------------------------------------
// TESTES DE FORMATAÇÃO
// -------------------------------------------------------------
testar('formatarNome: remove espaços das pontas e padroniza', formatarNome('  ANA CLARA SILVA ') === 'Ana Clara Silva');
testar('formatarNome: nome minúsculo vira padrão', formatarNome('joao pedro almeida') === 'Joao Pedro Almeida');

testar('limparCPF: remove pontos e traço', limparCPF('123.456.789-00') === '12345678900');
testar('limparCPF: remove espaços', limparCPF(' 123 456 789 00 ') === '12345678900');

testar('formatarCPF: volta para o formato com pontuação', formatarCPF('12345678900') === '123.456.789-00');

testar('formatarMoeda: formata centavos', formatarMoeda(1500.5) === 'R$ 1.500,50');
testar('formatarMoeda: valor inteiro', formatarMoeda(980.00) === 'R$ 980,00');

// -------------------------------------------------------------
// TESTES DE VALIDAÇÃO (dados válidos e inválidos)
// -------------------------------------------------------------
testar('validarNome: nome válido', validarNome('Ana Clara Silva') === true);
testar('validarNome: nome vazio é inválido', validarNome('   ') === false);
testar('validarNome: nome curto é inválido', validarNome('ab') === false);

testar('validarCPF: CPF válido', validarCPF('123.456.789-00') === true);
testar('validarCPF: CPF com letras é inválido', validarCPF('123.456.ABC-00') === false);
testar('validarCPF: CPF com poucos dígitos é inválido', validarCPF('123.456') === false);
testar('validarCPF: CPF vazio é inválido', validarCPF('') === false);
testar('validarCPF: CPF com dígitos repetidos é inválido', validarCPF('111.111.111-11') === false);

testar('validarEmail: e-mail válido', validarEmail('ana.clara@email.com') === true);
testar('validarEmail: e-mail sem @ é inválido', validarEmail('ana.email.com') === false);
testar('validarEmail: e-mail vazio é inválido', validarEmail('') === false);

testar('validarContrato: valor válido', validarContrato(1500.0) === true);
testar('validarContrato: contrato igual a zero é inválido', validarContrato(0.0) === false);
testar('validarContrato: contrato negativo é inválido', validarContrato(-10.0) === false);

// -------------------------------------------------------------
// TESTES DE BUSCA (cliente existente e inexistente)
// -------------------------------------------------------------
$encontrado = buscarCliente($clientes, 'ana clara silva');
testar('buscarCliente: encontra cliente ignorando caixa/espaços', is_array($encontrado) && $encontrado['email'] === 'ana.clara@email.com');

$naoEncontrado = buscarCliente($clientes, 'Fulano de Tal');
testar('buscarCliente: retorna null quando não encontra', $naoEncontrado === null);

// -------------------------------------------------------------
// TESTES DE CADASTRO (válido e inválido)
// -------------------------------------------------------------
$lista = $clientes;
testar('cadastrarCliente: cadastro válido retorna true', cadastrarCliente($lista, 'Paula Ribeiro', '789.123.456-33', 'paula@email.com', 1750.00) === true);
testar('cadastrarCliente: lista cresceu para 3', count($lista) === 3);

testar('cadastrarCliente: CPF inválido retorna false', cadastrarCliente($lista, 'Joao Errado', '111', 'joao@email.com', 100.0) === false);
testar('cadastrarCliente: e-mail inválido retorna false', cadastrarCliente($lista, 'Joao Errado', '11122233344', 'sem-arroba', 100.0) === false);
testar('cadastrarCliente: contrato zero retorna false', cadastrarCliente($lista, 'Joao Errado', '11122233344', 'joao@email.com', 0.0) === false);

// -------------------------------------------------------------
// TESTES DE CÁLCULO
// -------------------------------------------------------------
testar('calcularTotalContratosAtivos: soma só os ativos (1500)', calcularTotalContratosAtivos($clientes) === 1500.0);
testar('calcularMediaContratos: média de 2 contratos', calcularMediaContratos($clientes) === 1175.25);
testar('calcularMediaContratos: lista vazia retorna 0', calcularMediaContratos([]) === 0.0);
testar('contarClientesAtivos: 1 ativo na lista', contarClientesAtivos($clientes) === 1);
testar('contarClientes: total de clientes', contarClientes($clientes) === 2);
testar('maiorContrato: maior valor é 1500', maiorContrato($clientes) === 1500.0);

// -------------------------------------------------------------
// TESTES DE PASSAGEM POR REFERÊNCIA (&)
// -------------------------------------------------------------
$contrato = 1000.0;
aplicarReajuste($contrato, 10.0);
testar('aplicarReajuste: 10% em 1000 vira 1100 (altera o valor original)', $contrato === 1100.0);

$contrato2 = 850.50;
aplicarReajuste($contrato2, 50.0);
testar('aplicarReajuste: 50% em 850.50 vira 1275.75', $contrato2 === 1275.75);

// -------------------------------------------------------------
// TESTES DE LIMPEZA POR REFERÊNCIA
// -------------------------------------------------------------
$clienteSujo = ['nome' => '  MARIA  SANTOS ', 'cpf' => '222.333.444-55', 'email' => '  maria@email.com ', 'contrato' => 500.0, 'ativo' => true];
limparDadosCliente($clienteSujo);
testar('limparDadosCliente: nome e CPF limpos no array original', $clienteSujo['nome'] === 'Maria Santos' && $clienteSujo['cpf'] === '22233344455');

// -------------------------------------------------------------
// APRESENTAÇÃO DOS RESULTADOS
// -------------------------------------------------------------
$totalTestes = count($testes);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Testes do CRM Senai</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 6px 10px; }
        th { background: #1a3c6e; color: #fff; }
        .passou { color: green; font-weight: bold; }
        .falhou { color: red; font-weight: bold; }
    </style>
</head>
<body>
<h1>Relatório de Testes — CRM Senai</h1>
<p>
    Total: <?= $totalTestes ?> |
    Passaram: <?= $totalTestes - $falhas ?> |
    Falharam: <?= $falhas ?>
</p>
<table>
    <tr><th>#</th><th>Teste</th><th>Resultado</th></tr>
    <?php foreach ($testes as $i => $t): ?>
    <tr>
        <td><?= $i + 1 ?></td>
        <td><?= htmlspecialchars($t['descricao']) ?></td>
        <td class="<?= $t['resultado'] === 'PASSOU' ? 'passou' : 'falhou' ?>"><?= $t['resultado'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
