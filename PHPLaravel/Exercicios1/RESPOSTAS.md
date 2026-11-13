# Lista de Exercícios — Laravel 11.x e Artisan CLI

## Parte A: Respostas Teóricas (resumidas)

**1. Evolução Arquitetural:** Construir o MVC artesanal ensinou na prática as três camadas (Rota → Controller → View/Model), o papel do roteador e a separação de responsabilidades. Por isso o Laravel 11 ficou fácil: ele organiza exatamente essas mesmas camadas, só que já prontas e mais completas.

**2. Nova Arquitetura do Laravel 11:** Foram removidos os arquivos de configuração pesados do `app/` (Http Kernel, Console Kernel e middleware registrados lá). O novo ponto central de configuração é o **`bootstrap/app.php`**, onde se configuram rotas, middlewares e exceções com uma API fluente (`withRouting()`, `withMiddleware()`).

**3. Padrão 12-Factor App (senha no database.php):** O 12-Factor exige que a configuração fique **fora do código** e possa mudar sem alterar o fonte. Senha gravada no `database.php` vai para o Git (vaza para toda a equipe/repos público), mistura ambiente com código e não pode ser trocada por ambiente (produção x local) sem editar o arquivo. O `.env` fica fora do Git e cada servidor tem o seu.

**4. Papel da APP_KEY:** A `APP_KEY` criptografa **cookies de sessão** e dados cifrados (ex.: colunas `encrypted` do Eloquent, tokens de reset de senha). Ao trocar a chave em produção, todas as sessões dos usuários são invalidadas e **dados cifrados no banco se tornam irrecuperáveis**.

**5. Isolamento de Diretórios:** A pasta `public/` é a única com o `index.php` (front controller). Se o servidor apontar para a raiz, arquivos internos como `.env` (senhas!), `composer.json` e `storage/` ficam acessíveis por URL, permitindo download direto e comprometimento total da aplicação.

**6. Artisan CLI x `php arquivo.php`:** Um script procedural roda "sozinho", sem acesso a nada do framework (config, banco, models). O `php artisan` carrega o container do Laravel, então o comando tem acesso a **Eloquent, configuração, filas e eventos** — além de seguir um padrão único e documentável de CLI da equipe.

**7. `.env.example`:** Como o `.env` real é ignorado no Git, o `.env.example` é o **contrato** que diz ao colega (ou ao DevOps) quais chaves o projeto precisa. Sem ele, a aplicação não sobe na máquina de outra pessoa porque faltam variáveis ou ela não sabe quais criar.

**8. Blade `{{ }}` x `{!! !!}`:** `{{ $var }}` aplica `htmlspecialchars()` — escapando HTML — e é **segura contra XSS**. `{!! $var !!}` imprime HTML cru: se o conteúdo vier de um usuário, permite injeção de script. Só use `{!! !!}` com conteúdo confiável/sanitizado.

**9. Controller curto (≤ 20 linhas):** O controller é a camada de **entrada** (HTTP), não de regra de negócio. Métodos curtos e sem SQL cru deixam o código testável, reaproveitável por outros locais (comandos, jobs) e fácil de ler — SQL cru pertence ao Model/Query Builder, lógica extensa a Services.

**10. Tinker:** É um **REPL interativo** (php artisan tinker) que roda código dentro do ambiente completo do Laravel, no terminal. Economiza tempo em laboratório para testar Eloquent, `config()`, models e rotas sem criar controller/rota de teste nem recarregar o navegador.


### Exercício 4 — comandos para rodar no Tinker

```sh
php artisan tinker
```

```php
config('app.timezone')          // fuso horário ativo
$ativo = new \App\Models\Ativo();  // instância em memória
$ativo->codigo_patrimonio = "PAT-001";
$ativo->nome = "Torno CNC";
$ativo->setor = "Usinagem";
$ativo->status = "operacional";
$ativo->toArray()               // representação em array do objeto
```

### Como testar

```sh
php artisan serve        # http://127.0.0.1:8000
php artisan about        # diagnóstico do ambiente
php artisan senai:status # Exercício 2
```


