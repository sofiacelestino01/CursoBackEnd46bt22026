<?php
// =============================================================
// utilitarios.php — Biblioteca de funções do CRM Senai
// Projeto: Central de Atendimento e Cadastro do CRM Senai
// =============================================================

declare(strict_types=1);

// -------------------------------------------------------------
// FUNÇÕES DE FORMATAÇÃO
// -------------------------------------------------------------

/**
 * Remove espaços extras e padroniza o nome
 * (somente a primeira letra de cada palavra em maiúsculo).
 */
function formatarNome(string $nome): string
{
    $limpo = trim($nome);                 // remove espaços das pontas
    $limpo = preg_replace('/\s+/', ' ', $limpo); // espaços duplos viram 1
    return mb_convert_case($limpo, MB_CASE_TITLE, 'UTF-8');
}

/**
 * Remove pontos, traços e espaços do CPF,
 * deixando apenas os 11 números.
 */
function limparCPF(string $cpf): string
{
    $cpf = str_replace(['.', '-', ' '], '', $cpf);
    return trim($cpf);
}

/**
 * Formata um valor float no padrão de moeda brasileira.
 * Exemplo: 1500.5 -> "R$ 1.500,50"
 */
function formatarMoeda(float $valor): string
{
    return 'R$ ' . number_format($valor, 2, ',', '.');
}

/**
 * Coloca o CPF no formato 000.000.000-00 (se tiver 11 dígitos).
 */
function formatarCPF(string $cpf): string
{
    $cpf = limparCPF($cpf);
    if (strlen($cpf) === 11) {
        return substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2);
    }
    return $cpf; // se não tiver 11 dígitos, devolve como está
}

// -------------------------------------------------------------
// FUNÇÕES DE VALIDAÇÃO (retornam bool)
// -------------------------------------------------------------

/**
 * Valida o nome: não pode ser vazio e precisa ter pelo menos 3 letras.
 */
function validarNome(string $nome): bool
{
    $nome = trim($nome);
    if ($nome === '') {
        return false;
    }
    if (strlen($nome) < 3) {
        return false;
    }
    return true;
}

/**
 * Valida o CPF: precisa ter 11 dígitos depois da limpeza
 * e não pode ser uma sequência de números repetidos.
 */
function validarCPF(string $cpf): bool
{
    $cpf = limparCPF($cpf);

    if (strlen($cpf) !== 11) {
        return false;
    }
    if (!ctype_digit($cpf)) {
        return false;
    }

    // Rejeita CPFs tipo 111.111.111-11
    if (count(count_chars($cpf, 1)) === 1) {
        return false;
    }

    return true;
}

/**
 * Valida o e-mail usando a própria função do PHP.
 */
function validarEmail(string $email): bool
{
    return filter_var(trim($email), FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Valida o valor do contrato: precisa ser maior que zero.
 */
function validarContrato(float $valor): bool
{
    if ($valor <= 0) {
        return false;
    }
    return true;
}

// -------------------------------------------------------------
// FUNÇÕES DE BUSCA E CADASTRO
// -------------------------------------------------------------

/**
 * Busca um cliente pelo nome (compara sem acento de espaço/caixa).
 * Retorna o array do cliente ou null se não encontrar.
 */
function buscarCliente(array $clientes, string $nome): ?array
{
    $nomeBusca = mb_strtolower(formatarNome($nome), 'UTF-8');

    foreach ($clientes as $cliente) {
        $nomeAtual = mb_strtolower(formatarNome($cliente['nome']), 'UTF-8');
        if ($nomeAtual === $nomeBusca) {
            return $cliente;
        }
    }

    return null; // cliente não encontrado
}

/**
 * Cadastra (simula) um novo cliente no array.
 * Retorna true se cadastrou, false se algum dado for inválido.
 */
function cadastrarCliente(array &$clientes, string $nome, string $cpf, string $email, float $contrato): bool
{
    if (!validarNome($nome)) {
        return false;
    }
    if (!validarCPF($cpf)) {
        return false;
    }
    if (!validarEmail($email)) {
        return false;
    }
    if (!validarContrato($contrato)) {
        return false;
    }

    $clientes[] = [
        'nome'     => formatarNome($nome),
        'cpf'      => formatarCPF($cpf),
        'email'    => trim($email),
        'contrato' => $contrato,
        'ativo'    => true,
    ];

    return true;
}

// -------------------------------------------------------------
// FUNÇÕES DE CÁLCULO (resumo financeiro e relatório)
// -------------------------------------------------------------

/**
 * Soma os contratos apenas dos clientes ativos.
 */
function calcularTotalContratosAtivos(array $clientes): float
{
    $total = 0.0;

    foreach ($clientes as $cliente) {
        if ($cliente['ativo']) {
            $total += $cliente['contrato'];
        }
    }

    return $total;
}

/**
 * Calcula a média de TODOS os contratos.
 */
function calcularMediaContratos(array $clientes): float
{
    $totalClientes = count($clientes);

    if ($totalClientes === 0) {
        return 0.0;
    }

    $soma = 0.0;
    foreach ($clientes as $cliente) {
        $soma += $cliente['contrato'];
    }

    return $soma / $totalClientes;
}

/**
 * Conta quantos clientes estão ativos.
 */
function contarClientesAtivos(array $clientes): int
{
    $ativos = 0;

    foreach ($clientes as $cliente) {
        if ($cliente['ativo']) {
            $ativos++;
        }
    }

    return $ativos;
}

/**
 * Retorna o maior contrato cadastrado (0.0 se a lista estiver vazia).
 */
function maiorContrato(array $clientes): float
{
    $maior = 0.0;

    foreach ($clientes as $cliente) {
        if ($cliente['contrato'] > $maior) {
            $maior = $cliente['contrato'];
        }
    }

    return $maior;
}

/**
 * Conta o total de clientes do array.
 */
function contarClientes(array $clientes): int
{
    return count($clientes);
}

// -------------------------------------------------------------
// PASSAGEM POR REFERÊNCIA (&)
// -------------------------------------------------------------

/**
 * Aplica um reajuste percentual no contrato.
 * O & altera o valor ORIGINAL do cliente (passagem por referência).
 */
function aplicarReajuste(float &$contrato, float $percentual): void
{
    $contrato += $contrato * ($percentual / 100);
}

/**
 * Limpa os dados de um cliente por referência:
 * remove espaços do nome e a pontuação do CPF.
 * Retorno void — ela só modifica o array original.
 */
function limparDadosCliente(array &$cliente): void
{
    $cliente['nome'] = formatarNome($cliente['nome']);
    $cliente['cpf']  = limparCPF($cliente['cpf']);
    $cliente['email'] = trim($cliente['email']);
}
