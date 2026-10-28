# SENAI Suply MVC - Especificação Inicial de Requisitos

## 1. Identificação

- Projeto: Senai Suply MVC
- Versão 1.0
- Estado: proposta inicial, sujeita a alterações
- Responsável: Equipe de Desenvolvimento I1D46B

## 2. Objetivos

Desenvolver uma aplicação web didátioca para consultar o catálogo de insumos insdustriais e acompanhar a quantidade em estoque, aplicando arquitetura MVC artesanl com PHP, Composer , PDO e PostgreSQL

## 3. Escopo

Este projeto exibira uma painel de estoque, lista de insumos, permitira cadastrar novos itens e apresentar uma tela de login com autenticação de usuário. 

### 3.1 Partes interessadas e usuários

- Almoxarife: consultar o catálogo e cadastrar insumos
- Gestor: acompanhar as quantidades agregadas no pianel
- Equipe de Desenvolvimento: implementar e validar os requisitos do sistema

### 3.2 Ambientes e dependências

- PHP 8.3 ou superior, Composer, extensão PDO para PostgreSQL
- Banco de Dados PostgreQL com o script schema.sql
- Servidor web configurado
- Navegador com suporte a HTML 5

## 4. Requisitos do Sistema

### 4.1 Requsitos Funcionais (RF)

- **RF-001** - Autenticação de Usuários: O sistema deve autenticar o usuário por e-mail e senha
- **RF-002** - Logout Seguro: O encerramento da sessão deve ocorrer exclusivamento via `POST/logout`
- **RF-003** - Guard de Autenticação: Rotas restritas devem direcionar usuário para login
- **RF-004** - Guard de Autorização por Perfil: retrição de Rotas por Perfil de Usuário
- **RF-005** - Catalogo de Produtos: `GET` listar produtos
- **RF-006** - Cadastrar Produtos: `POST` persistir novo produto
- **RF-007** - Atualizar Registro de Produtos: `UPDATE` de produtos
- **RF-008** - Registro de Movimentação: `POST`movimentação
- **RF-009** - Validação de Movimentações: impedir movimetações indevidas
- **RF-010** - histórico de Movimetações: `GET`listar as movimetações
- **RF-011** - Registro de Logs : aramazenar eventos de logs em logs/app.log

### 4.2 Requisitos Não Funcionais (RNF)

- **RNF-001** - Segurança de Senhas: Usar criptografia para salvar as senhas no banco
- **RNF-002** - Integridade Transacional (ACID): Movimentações devem usar PDO
- **RNF-003** - Prevenção XSS: sanitização de dados com `htmlspecialchars`
- **RNF-004** - Utilização de Arquitetura MVC: utilização de Model-View-Controller Artesanal

## Diagramas do Sistema

### Diarama das Entidades Relacionais (DER)

```mermaid
erDiagram
     title ["Diagram de Entidades Relacionais <br/> (Modelo Conceitual)"]

    usuarios{
        int id PK
        varchar nome
        varchar email
        varchar senha_hash
        varchar perfil
        timespamp criado_em
    }

    produtos{
        int id PK
        varchar nome
        numeric preco
        int estoque
        varchar categoria
        timestamp cadastrado_em
    }

    movimentacoes {
        int id PK
        int produto_id FK
        int usuario_id FK
        varchar tipo
        int quantidade
        varchar motivo
        tipestamp movimentado_em
    }

    usuarios ||--o{ movimentacoes : realiza
    produtos ||--o{ movimentacoes : registra
```

## Estrutura Completa de Diretórios do Projeto (Arquitetura MVC)

Crie rigorosamente a seguinte árvore de pastas e arquivos no seu espaço de trabalho 

```text
senai-supply-mvc/
├── README.md                   <- Requisitos e critérios de aceitação
├── composer.json               <- Mapeamento de Autoload PSR-4
├── config/
│   └── database.ini            <- Credenciais isoladas do Banco de Dados
├── logs/
│   └── app.log                 <- Arquivo de logs e auditoria da aplicação
├── public/
│   └── index.php               <- Front Controller (Ponto único de entrada)
├── schema.sql                  <- DDL de usuários, produtos e movimentações
└── src/
    ├── Controllers/
    │   ├── AuthController.php          <- Login, autenticação e logout
    │   ├── HomeController.php          <- Dashboard e métricas de estoque
    │   ├── MovimentacaoController.php  <- Registro e auditoria de movimentações
    │   └── ProdutoController.php       <- Catálogo e cadastro de insumos
    ├── Core/
    │   ├── ConexaoBanco.php    <- Provedor Singleton de conexão PDO
    │   ├── Controller.php      <- Classe base abstrata com renderização e CSRF
    │   ├── Guards/
    │   │   └── AuthGuard.php   <- Middleware/Guard de autenticação e perfis
    │   ├── Logger.php          <- Serviço centralizado de logs da aplicação
    │   └── Roteador.php        <- Roteador HTTP artesanal com suporte a Guards
    ├── Models/
    │   ├── Movimentacao.php    <- Regras e transação de movimentação (ACID)
    │   ├── Produto.php         <- Regras de negócio e catálogo de insumos
    │   └── Usuario.php         <- Persistência e busca segura de usuários
    └── Views/
        ├── layout/
        │   ├── header.php      <- Cabeçalho com sessão, perfil e logout
        │   └── footer.php      <- Rodapé corporativo compartilhado
        ├── auth/
        │   └── login.php       <- Formulário de autenticação com CSRF
        ├── home/
        │   └── index.php       <- Dashboard com métricas gerais
        ├── movimentacoes/
        │   ├── historico.php   <- Tabela de auditoria de movimentações
        │   └── novo.php        <- Formulário para registrar entrada ou saída
        └── produtos/
            ├── criar.php       <- Formulário de novo insumo
            └── listar.php      <- Tabela de insumos com atalho de movimentação

```

## Etapas de Desenvolvimento do Projeto

### Modelagem Relacional e Script DDL (`schema.sql`)

Criar o Banco de Dados e Executar o Script SQL para Criar as Tabelas

## Configurar o AutoLoad PSR-4 (composer.json)

Crair o arquivo `composer.json` na raiz do projeto 

- composer.json => gerenciador de dependências do projeto 

- PSR-4 => - PSR-4 => biblioteca de mapeamento de arquivos do projeto evita a necessidade de usar `required_onde`

> obs: antes de rodar o projeto: executar o comando no terminal `composer dump-autoload -o`

### Criação da Conexão com o Banco de Dados e Configuração de Conexão

Criar o arquivo `.gitignore` 

- .gitignore => evita subir para nuvem informações protegidas ou sigilosas do projeto


Criar os dados de configuração (`config/database.ini`)

- database.ini => informações de conexão com o banco 

Criar a Classe Singleton de Conexão com o Banco de Dados (`src/Core/ConexaoBanco.php`)

- ConexaoBanco.php => classe do tipo Singleton para conexão com o banco de dados

### Criação da classe de logs do Sistema