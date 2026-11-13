# Projeto CRM Senai — Central de Atendimento e Cadastro

Projeto em PHP puro (sem banco de dados e sem autenticação) que cadastra clientes, limpa e formata seus dados, calcula o valor dos contratos e gera um relatório resumido. Toda a lógica está em uma biblioteca de funções reutilizáveis, aplicando o princípio **DRY** (Don't Repeat Yourself).

## Estrutura do projeto

```
projeto_crm/
├── utilitarios.php   → Biblioteca com todas as funções do sistema
├── index.php         → Tela principal (importa a biblioteca com require_once)
├── README.md         → Este arquivo
└── testes/
    └── testes.php    → Testes automáticos das funções
```

## Como executar

### Opção 1 — Navegador (com XAMPP/WAMP)
1. Coloque a pasta `projeto_crm` dentro de `htdocs` (XAMPP) ou `www` (WAMP).
2. Abra no navegador:
   - Sistema: `http://localhost/projeto_crm/index.php`
   - Testes: `http://localhost/projeto_crm/testes/testes.php`

### Opção 2 — Terminal (PHP CLI)
```
cd projeto_crm
php -S localhost:8080
```
Depois acesse `http://localhost:8080/index.php` no navegador.

Para rodar os testes direto no terminal:
```
php testes/testes.php
```

## Dados dos clientes

O sistema parte de 2 clientes da especificação e acrescenta mais 3 (total de 5 após o cadastro simulado):
- Ana Clara Silva (R$ 1.500,00, ativa)
- Carlos Souza (R$ 850,50, inativo)
- Mariana Lopes Pereira (R$ 2.300,75, ativa)
- João Pedro Almeida (R$ 980,00, ativo)
- Paula Fernanda Ribeiro (cadastrada pelo sistema, R$ 1.750,00)

## Funcionalidades

1. **Listagem de clientes** — tabela HTML montada com `foreach`: nome, CPF, e-mail, contrato e situação.
2. **Busca por nome** — formulário na tela; retorna os dados do cliente ou a mensagem "não foi encontrado".
3. **Cadastro de cliente** — simulado, valida nome, CPF, e-mail e valor do contrato.
4. **Limpeza de dados** — `trim()` nos nomes e `str_replace()` nos CPFs.
5. **Formatação** — nomes padronizados e valores em moeda brasileira com `number_format()`.
6. **Resumo financeiro** — soma dos contratos ativos e média dos contratos.
7. **Reajuste por referência** — `aplicarReajuste(float &$contrato, float $percentual): void` altera o valor original.
8. **Relatório final** — total de clientes, clientes ativos e maior contrato.

## Funções da biblioteca (utilitarios.php)

| Função | Retorno |
|---|---|
| `formatarNome(string $nome): string` | Nome padronizado |
| `limparCPF(string $cpf): string` | CPF só com números |
| `formatarCPF(string $cpf): string` | CPF no formato 000.000.000-00 |
| `formatarMoeda(float $valor): string` | Valor em R$ brasileiro |
| `validarNome(string $nome): bool` | `true`/`false` |
| `validarCPF(string $cpf): bool` | `true`/`false` |
| `validarEmail(string $email): bool` | `true`/`false` |
| `validarContrato(float $valor): bool` | `true`/`false` |
| `buscarCliente(array $clientes, string $nome): ?array` | Array do cliente ou `null` |
| `cadastrarCliente(array &$clientes, ...): bool` | `true`/`false` |
| `calcularTotalContratosAtivos(array $clientes): float` | Soma dos ativos |
| `calcularMediaContratos(array $clientes): float` | Média |
| `contarClientesAtivos(array $clientes): int` | Quantidade de ativos |
| `contarClientes(array $clientes): int` | Quantidade total |
| `maiorContrato(array $clientes): float` | Maior contrato |
| `aplicarReajuste(float &$contrato, float $percentual): void` | `void` (altera o original) |
| `limparDadosCliente(array &$cliente): void` | `void` (altera o original) |

## Requisitos técnicos atendidos

- `declare(strict_types=1);` em todos os arquivos PHP;
- Funções com parâmetros tipados e tipos de retorno;
- Função com retorno `void`: `aplicarReajuste()` e `limparDadosCliente()`;
- Função que retorna `bool`: `validarCPF()`, `validarEmail()`, entre outras;
- Função que retorna `?array`: `buscarCliente()`;
- `foreach` para percorrer os clientes;
- Uso de `count()`, `strlen()`, `str_replace()`, `trim()` e `number_format()`;
- Uso de `if / elseif / else` nas validações;
- Passagem por referência (`&`) em `aplicarReajuste()` e `limparDadosCliente()`;
- `require_once` para importar `utilitarios.php`;
- Separação entre processamento (biblioteca) e apresentação (HTML).

## Casos de teste cobertos (testes/testes.php)

- Dados válidos: formatação de nome, CPF e moeda;
- Campos vazios: nome vazio, e-mail vazio, CPF vazio;
- CPF inválido: com letras, com poucos dígitos, com dígitos repetidos;
- Contrato igual a zero e negativo;
- Cliente inexistente na busca (retorna `null`);
- Cadastro válido e inválido;
- Cálculo do total, média, contagem e maior contrato;
- Reajuste de 10% e 50% alterando o valor original.

## Respostas às perguntas de reflexão

**1. Qual trecho do projeto seria mais difícil de corrigir se estivesse repetido em várias páginas?**
A regra de formatação de moeda brasileira com `number_format($valor, 2, ',', '.')`. Se ela estivesse copiada em 5 telas e o formato mudasse (por exemplo, para 3 casas decimais), seria preciso encontrar e corrigir os 5 lugares — e esquecer um geraria telas com valores diferentes. Centralizando em `formatarMoeda()`, a correção é feita em um único lugar.

**2. Por que a busca por cliente deve retornar null quando não encontra um resultado?**
Porque `null` é a forma padrão do PHP de dizer "nada foi encontrado". Assim quem usa a função pode testar com `if ($clienteEncontrado === null)` e exibir a mensagem "cliente não encontrado". Se retornasse um array vazio ou um array com lixo, o código da tela precisaria adivinhar o que significar aquele retorno, e poderia até exibir dados errados.

**3. Em qual situação a passagem por referência foi necessária? O que aconteceria sem o &?**
Em `aplicarReajuste(float &$contrato, float $percentual)`. Com o `&`, a função recebe o próprio valor do contrato e o modifica na memória, então `$clientes[0]['contrato']` passa de R$ 1.500,00 para R$ 1.650,00 de verdade. Sem o `&`, o PHP criaria uma cópia local do valor, o reajuste seria aplicado na cópia, o array original continuaria em R$ 1.500,00 e o relatório ficaria errado.

**4. Como a tipagem ajudou a encontrar erros durante o desenvolvimento?**
Com `strict_types=1` e tipos declarados (ex.: `formatarMoeda(float $valor): string`), o PHP recusa na hora uma chamada errada, como `formatarMoeda("1500")` — dispara um `TypeError` apontando a linha exata, em vez de formatar silenciosamente um texto e gerar um bug difícil de achar. Foi exatamente o tipo de erro (ordem/tipo de parâmetro invertido em `buscarCliente`) que quebrou a versão anterior do projeto.

**5. Que função adicional poderia ser criada para melhorar o sistema sem duplicar código?**
Uma função `exibirSituacao(bool $ativo): string`, que devolve "Ativo" ou "Inativo". Hoje essa escolha aparece na tabela e na busca; centralizando em uma função, mudar o texto (por exemplo, para "Habilitado"/"Desabilitado") seria feito em um único lugar, mantendo o DRY.
