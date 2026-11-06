# Meu Primeiro Projeto Laravel - SENAI Asset Manager (Sistema de gestão de ativos Industriais e Maquinários)

## 1. Criação da Aplicação

abrir o termianr do VSCode na pasta desejada e adicionar o projeto usando o composer

```bash
php --version #verifica a versão do php instalada

composer --version #verifica a versãao do composer instalada

#cria o projeto dentro da pasta atual
composer create-project laravel/laravel nome-do-projeto

#acessa a pasta do projeto
cd nome-do-projeto
```

## 2. Configuração de Arquivo de Blindagem `.env`

- Abrir o arquivo e configurar os paraâmetros

- Configurar as informações das variáveis de ambiente para o projeto

- Inserir a chave de criptrografia caso nã tenha

`php artisan key:generate`

## Criação de uma Classe Model 

Gerar o Model para Representar as máquinas e equipamentos do sistema

criar uma classe chamada Ativo

`php artisan make:model Ativo`

`app/Models/Ativo.php` - arquivo criado

## 3. Criação de um Controller 

Gerar um Controller para gerenciar as máquinas e equipamentos (Ativo)

`php artisan make:controller AtivoController --resource`

`app/Http/Controllers/AtivoController.php` - arquivo criado

## 4. Rotas de Navegação da Aplicação

`routes/web.php`

criação de duas rotas de tipo get

uma de ativos mokados
uma de status da infra

## 5. Camada de Visualização `Blade`

`resources/views/`

criar a pasta de ativos
e criar index.blade.php

- blade é a engine de visualização do laravel, que permite criar páginas web dinâmicas com sintaxe simples e direta
- faz uso do databind => é o processo de vincular dados do backend (controlador ou do modelo) a elementos da interface do usuários (UI)
- databind no blade é feito com a sintaxe `{{ $variavel }}`

## Inicialização e Homologação 

Inspecionar 

`php artisan about`

Homolocar 
`php artisan serve`

## 7. Roteiro de Homologação e Teste

Execute a sequência de 7 testes de validação técnica no laboratório:

1. **Teste 1 — Servidor HTTP Ativo:**  
   Inicie o servidor com `php artisan serve` e acesse `http://localhost:8000/`.  
   *Resultado Esperado:* A página corporativa do *SENAI Asset Manager* é renderizada perfeitamente, exibindo os 4 cards de métricas (42 ativos, 37 em operação, 4 em manutenção e 88.5% de eficiência).

2. **Teste 2 — Resposta da Rota de Diagnóstico JSON:**  
   Acesse a URL `http://localhost:8000/status` (ou clique no botão verde do painel).  
   *Resultado Esperado:* O navegador exibe a resposta estruturada em JSON semântico:
   ```json
   {
       "plataforma": "SENAI Asset Manager",
       "ambiente": "local",
       "versao_php": "8.3.x",
       "status": "ONLINE",
       "timestamp": "2026-10-30T16:45:00-03:00"
   }
   ```

3. **Teste 3 — Inspeção de Rotas com Artisan:**  
   No terminal, execute `php artisan route:list`.  
   *Resultado Esperado:* As rotas `ativos.index` e `ativos.status` aparecem associadas às ações do `AtivoController`.

4. **Teste 4 — Auditoria de Blindagem do Arquivo `.env`:**  
   Abra o terminal e verifique se o `.env` está protegido pelo Git:
   ```bash
   git status --ignored
   ```
   *Resultado Esperado:* O arquivo `.env` aparece listado na seção de arquivos ignorados (`Ignored files`). Ele **nunca** deve aparecer como arquivo rastreado (*Untracked/Staged*)!

5. **Teste 5 — Teste de Execução no Terminal Interativo (Tinker):**  
   Abra o REPL do Laravel:
   ```bash
   php artisan tinker
   ```
   Digite os seguintes comandos dentro do Tinker:
   ```php
   config('app.name');
   // Retorna: "SENAI Asset Manager"
   
   now()->format('d/m/Y H:i:s');
   // Retorna a data e hora atual no fuso configurado
   
   exit;
   ```

6. **Teste 6 — Auditoria da Chave Criptográfica:**  
   Experimente apagar temporariamente o valor da `APP_KEY` no `.env` e recarregue a página no navegador.  
   *Resultado Esperado:* O Laravel bloqueia a execução e exibe a mensagem de segurança alertando sobre a ausência da chave de criptografia.  
   *Restauração:* Execute `php artisan key:generate` para restabelecer a segurança e recarregue a página.

7. **Teste 7 — Verificação do Painel de Saúde (`php artisan about`):**  
   Execute `php artisan about` no terminal.  
   *Resultado Esperado:* Todos os indicadores técnicos devem estar validados em verde.

---

# Continuação do Projeto: contrução da getão de parceiros industriais (módulo cliente)

## Criação do model e migração do banco de dados

Crie o model e o arquivo de migração para a tabela `clientes`

`php artisan make:Model Cliente -m`

-m => diretamente relacionada a migração o banco de daddos

## Gera e Implementar `ClienteController`

`php artisan make:controller ClienteController --resource`

é criado o arquivo 

`app/Http/Controllers/ClienteController.php`
