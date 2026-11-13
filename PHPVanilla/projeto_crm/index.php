<?php
// =============================================================
// index.php — Tela principal do CRM Senai
// Importa a biblioteca e exibe os resultados em HTML.
// =============================================================

declare(strict_types=1);

require_once 'utilitarios.php';

// -------------------------------------------------------------
// DADOS INICIAIS (simulados em array)
// -------------------------------------------------------------
$clientes = [
    [
        'nome'     => '  ANA CLARA SILVA ',
        'cpf'      => '123.456.789-00',
        'email'    => 'ana.clara@email.com',
        'contrato' => 1500.00,
        'ativo'    => true,
    ],
    [
        'nome'     => 'Carlos Souza',
        'cpf'      => '987.654.321-00',
        'email'    => 'carlos.souza@email.com',
        'contrato' => 850.50,
        'ativo'    => false,
    ],
    // +2 clientes acrescentados
    [
        'nome'     => '   mariana   lopes   pereira ',
        'cpf'      => '456.789.123-11',
        'email'    => 'mariana.pereira@email.com',
        'contrato' => 2300.75,
        'ativo'    => true,
    ],
    [
        'nome'     => ' joao pedro almeida ',
        'cpf'      => '321.654.987-22',
        'email'    => 'joao.almeida@email.com',
        'contrato' => 980.00,
        'ativo'    => true,
    ],
];

// -------------------------------------------------------------
// PROCESSAMENTO (chamadas das funções da biblioteca)
// -------------------------------------------------------------

// Limpa e padroniza os dados de todos os clientes
foreach ($clientes as $i => $cliente) {
    limparDadosCliente($clientes[$i]); // passagem por referência
}

// Cadastro simulado de um novo cliente
$cadastroOk = cadastrarCliente($clientes, 'paula fernanda ribeiro', '789.123.456-33', 'paula.ribeiro@email.com', 1750.00);

// Busca por nome
$nomeBusca = $_GET['busca'] ?? '';
$clienteEncontrado = null;
$buscaFeita = false;
if (trim($nomeBusca) !== '') {
    $buscaFeita = true;
    $clienteEncontrado = buscarCliente($clientes, $nomeBusca);
}

// Reajuste por referência: aplica 10% no contrato do 1º cliente
aplicarReajuste($clientes[0]['contrato'], 10.0);

// Resumo financeiro
$totalAtivos   = calcularTotalContratosAtivos($clientes);
$mediaContratos = calcularMediaContratos($clientes);
$qtdTotal      = contarClientes($clientes);
$qtdAtivos     = contarClientesAtivos($clientes);
$maior         = maiorContrato($clientes);

// -------------------------------------------------------------
// APRESENTAÇÃO (HTML)
// -------------------------------------------------------------
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>CRM Senai — Central de Atendimento</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background: #f4f6f8; }
        h1 { color: #1a3c6e; }
        h2 { color: #2c5f9e; border-bottom: 2px solid #2c5f9e; padding-bottom: 4px; }
        table { border-collapse: collapse; width: 100%; background: #fff; }
        th, td { border: 1px solid #ccc; padding: 8px 12px; text-align: left; }
        th { background: #2c5f9e; color: #fff; }
        tr:nth-child(even) { background: #eef3f9; }
        .ativo { color: green; font-weight: bold; }
        .inativo { color: red; font-weight: bold; }
        .ok { color: green; }
        .erro { color: red; }
        .resumo { background: #fff; padding: 15px; border-left: 5px solid #2c5f9e; }
    </style>
</head>
<body>

<h1>Central de Atendimento e Cadastro do CRM Senai</h1>

<h2>1. Lista de Clientes</h2>
<table>
    <tr>
        <th>Nome</th>
        <th>CPF</th>
        <th>E-mail</th>
        <th>Contrato</th>
        <th>Situação</th>
    </tr>
    <?php foreach ($clientes as $cliente): ?>
    <tr>
        <td><?= htmlspecialchars(formatarNome($cliente['nome'])) ?></td>
        <td><?= htmlspecialchars(formatarCPF($cliente['cpf'])) ?></td>
        <td><?= htmlspecialchars($cliente['email']) ?></td>
        <td><?= formatarMoeda($cliente['contrato']) ?></td>
        <td class="<?= $cliente['ativo'] ? 'ativo' : 'inativo' ?>">
            <?= $cliente['ativo'] ? 'Ativo' : 'Inativo' ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<h2>2. Cadastro de Cliente (simulado)</h2>
<?php if ($cadastroOk): ?>
    <p class="ok">Cliente "Paula Fernanda Ribeiro" cadastrado com sucesso! (Dados validados: nome, CPF, e-mail e contrato)</p>
<?php else: ?>
    <p class="erro">Falha no cadastro do cliente.</p>
<?php endif; ?>

<h2>3. Busca por Nome</h2>
<form method="get" action="index.php">
    <input type="text" name="busca" placeholder="Digite o nome do cliente" value="<?= htmlspecialchars($nomeBusca) ?>">
    <button type="submit">Buscar</button>
</form>

<?php if ($buscaFeita): ?>
    <?php if ($clienteEncontrado !== null): ?>
        <div class="resumo">
            <strong>Cliente encontrado:</strong><br>
            Nome: <?= htmlspecialchars(formatarNome($clienteEncontrado['nome'])) ?><br>
            CPF: <?= htmlspecialchars(formatarCPF($clienteEncontrado['cpf'])) ?><br>
            E-mail: <?= htmlspecialchars($clienteEncontrado['email']) ?><br>
            Contrato: <?= formatarMoeda($clienteEncontrado['contrato']) ?><br>
            Situação: <?= $clienteEncontrado['ativo'] ? 'Ativo' : 'Inativo' ?>
        </div>
    <?php else: ?>
        <p class="erro">Cliente "<?= htmlspecialchars($nomeBusca) ?>" não foi encontrado.</p>
    <?php endif; ?>
<?php endif; ?>

<h2>4. Reajuste de Contrato (passagem por referência)</h2>
<p>
    Foi aplicado um reajuste de <strong>10%</strong> no contrato de
    <strong><?= htmlspecialchars(formatarNome($clientes[0]['nome'])) ?></strong>.<br>
    Valor original: R$ 1.500,00 &rarr; Valor reajustado: <strong><?= formatarMoeda($clientes[0]['contrato']) ?></strong>
</p>

<h2>5. Resumo Financeiro</h2>
<div class="resumo">
    <strong>Soma dos contratos ativos:</strong> <?= formatarMoeda($totalAtivos) ?><br>
    <strong>Média dos contratos:</strong> <?= formatarMoeda($mediaContratos) ?>
</div>

<h2>6. Relatório Final</h2>
<div class="resumo">
    <strong>Quantidade total de clientes:</strong> <?= $qtdTotal ?><br>
    <strong>Clientes ativos:</strong> <?= $qtdAtivos ?><br>
    <strong>Maior contrato cadastrado:</strong> <?= formatarMoeda($maior) ?>
</div>

</body>
</html>
