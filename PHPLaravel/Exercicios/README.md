# Lista de Exercícios — Controllers e Routes no Laravel

## Sobre esta entrega

- **Projeto base:** `PHPLaravel/1.Introducao/senai-asset-manager`
- **Entrega executável:** `PHPLaravel/Exercicios/senai-asset-manager`
- **Framework:** Laravel 13 / PHP 8.5
- **Banco de dados:** o mesmo PostgreSQL já configurado no `.env` do projeto base (`senai_asset`)
- **Dependências novas:** nenhuma. Foram utilizados apenas recursos nativos do Laravel e o padrão visual das views existentes.
- **Dados simulados:** os contratos e fornecedores são massas de teste em memória, seguindo o mesmo padrão já usado pelo `AtivoController` (métricas mockadas). Não foram criadas tabelas novas para não alterar o escopo do exercício.

### Como executar

```bash
cd PHPLaravel/Exercicios/senai-asset-manager
php artisan serve
```

Acesse `http://localhost:8000`.

---

## Relatório rápido por atividade

### Parte A — Questões teóricas

- **O que é:** respostas conceituais sobre semântica RESTful, idempotência, Resource Controllers, injeção de dependência, Method Spoofing, CSRF, constraints, rotas nomeadas, responsabilidade única e `route:list`.
- **Onde foi realizada:** no próprio `PHPLaravel/Exercicios/README.md`, na seção **PARTE A**.
- **Como foi realizada:** cada questão foi respondida com a definição do conceito, o motivo técnico e a relação com o projeto. Exemplo: a exclusão usa `DELETE` + `@csrf` + `@method('DELETE')`; o `PUT` é explicado como idempotente porque repete o mesmo estado final; o `@csrf` é explicado como token de sessão validado pelo middleware `VerifyCsrfToken`.

### Atividade 1 — Rota com múltiplos parâmetros e constraints compostas

- **O que é:** uma rota `GET` com dois parâmetros dinâmicos, sendo um cliente numérico e um ano com exatamente quatro dígitos.
- **Onde foi realizada:**
  - `senai-asset-manager/routes/web.php` → criação da rota `clientes.contratos`.
  - `senai-asset-manager/app/Http/Controllers/ClienteController.php` → método `contratosPorAno(int $cliente, int $ano)`.
  - `senai-asset-manager/resources/views/clientes/contratos.blade.php` → view com a tabela de contratos.
- **Como foi realizada:**
  - A rota foi criada com `Route::get("/clientes/{cliente}/contratos/{ano}", ...)`.
  - O parâmetro `{cliente}` recebeu `whereNumber("cliente")`.
  - O parâmetro `{ano}` recebeu `where("ano", "[0-9]{4}")`.
  - O controller busca o cliente com `Cliente::findOrFail($cliente)` e filtra os contratos simulados por cliente e ano.
  - A view mostra cliente, CNPJ, ano e os contratos encontrados.
- **Como testar:**
  - `/clientes/2/contratos/2026` → **200**.
  - `/clientes/2/contratos/26` → **404** (ano inválido).
  - `/clientes/abc/contratos/2026` → **404** (cliente não numérico).

### Atividade 2 — Resource Controller parcial com `only()`

- **O que é:** uma rota pública somente leitura para fornecedores, usando um Resource Controller sem as ações de criação, edição e exclusão.
- **Onde foi realizada:**
  - `senai-asset-manager/routes/web.php` → `Route::resource("fornecedores", ...)->only(["index", "show"])`.
  - `senai-asset-manager/app/Http/Controllers/FornecedorController.php` → controller gerado com `php artisan make:controller FornecedorController --resource`.
  - `senai-asset-manager/resources/views/fornecedores/index.blade.php` → lista pública.
  - `senai-asset-manager/resources/views/fornecedores/show.blade.php` → ficha pública.
- **Como foi realizada:**
  - O controller foi gerado via Artisan com a flag `--resource`.
  - Foram implementados apenas `index()` e `show()`, porque a rota é somente leitura.
  - O `->only(["index", "show"])` removeu `create`, `store`, `edit`, `update` e `destroy`.
  - Foi usado `->parameters(["fornecedores" => "fornecedor"])` para o parâmetro da rota ficar com o nome correto.
  - Foi aplicado `whereNumber("fornecedor")` para aceitar apenas IDs numéricos.
- **Como testar:**
  - `php artisan route:list --path=fornecedores` → mostra apenas `fornecedores.index` e `fornecedores.show`.
  - `/fornecedores` → **200**.
  - `/fornecedores/1` → **200**.
  - `/fornecedores/1/edit` → **404** (rota omitida).
  - `/fornecedores/abc` → **404** (constraint).

### Atividade 3 — Injeção de Dependência e leitura de cabeçalhos HTTP

- **O que é:** uma rota que recebe `Request` por injeção de dependência e devolve dados de telemetria da requisição em JSON.
- **Onde foi realizada:**
  - `senai-asset-manager/routes/web.php` → rota `clientes.telemetria`.
  - `senai-asset-manager/app/Http/Controllers/ClienteController.php` → método `origemRequisicao(Request $request)`.
- **Como foi realizada:**
  - O método declara `Request $request` e o Service Container entrega a requisição atual automaticamente.
  - O IP foi obtido com `$request->ip()`.
  - O navegador/cliente foi obtido com `$request->userAgent()`.
  - Também foram retornados método HTTP, rota e timestamp.
  - A resposta usa `response()->json([...])`.
  - A rota foi declarada antes do `Route::resource("clientes", ...)` para não ser capturada por `/clientes/{cliente}`.
- **Como testar:**
  - `GET /clientes/telemetria` → **200** com JSON contendo `ip`, `user_agent`, `metodo`, `rota` e `timestamp`.

### Atividade 4 — Agrupamento de rotas administrativas

- **O que é:** um grupo de rotas com prefixo `/admin`, nomes iniciados por `admin.` e middleware de proteção.
- **Onde foi realizada:**
  - `senai-asset-manager/routes/web.php` → grupo `Route::prefix("admin")->name("admin.")->middleware("throttle:60,1")`.
  - `senai-asset-manager/app/Http/Controllers/ClienteController.php` → método `auditoriaClientes()`.
  - `senai-asset-manager/resources/views/admin/auditoria/clientes.blade.php` → painel com o total de parceiros ativos.
- **Como foi realizada:**
  - O grupo usa `prefix("admin")` para montar a URI `/admin/...`.
  - O grupo usa `name("admin.")` para que a rota interna seja `admin.auditoria.clientes`.
  - O grupo usa `middleware("throttle:60,1")` para limitar a 60 requisições por minuto.
  - O método conta os clientes com `Cliente::query()->where("status", "ATIVO")->count()`.
  - A view exibe o total e permite recarregar a auditoria.
- **Como testar:**
  - `php artisan tinker --execute="echo route('admin.auditoria.clientes');"` → `http://localhost:8000/admin/auditoria/clientes`.
  - `GET /admin/auditoria/clientes` → **200**.
  - `php artisan route:list --path=admin` → mostra a rota `admin.auditoria.clientes`.

### Atividade 5 — Alteração parcial com verbo PATCH

- **O que é:** uma rota `PATCH` para alterar somente o status do cliente, alternando entre `ATIVO` e `SUSPENSO`.
- **Onde foi realizada:**
  - `senai-asset-manager/routes/web.php` → rota `clientes.status`.
  - `senai-asset-manager/app/Http/Controllers/ClienteController.php` → método `alterarStatus(Request $request, int $id)`.
  - `senai-asset-manager/resources/views/clientes/index.blade.php` → botão rápido com `@method('PATCH')`.
- **Como foi realizada:**
  - A rota foi criada com `Route::patch("/clientes/{id}/status", ...)`.
  - O parâmetro `{id}` recebeu `whereNumber("id")`.
  - O controller valida o campo `status` com `required|in:ATIVO,SUSPENSO`.
  - O controller atualiza **somente** o campo `status` com `Cliente::findOrFail($id)->update(["status" => $dados["status"]])`.
  - O formulário usa `method="POST"`, `@csrf`, `@method('PATCH')` e um campo oculto com o status oposto.
  - O botão exibe “Suspender” quando o cliente está ativo e “Ativar” quando está suspenso.
- **Como testar:**
  - Clicar no botão na listagem de clientes.
  - Verificar no DevTools que a requisição é um `POST` com `_method: PATCH` e `_token`.
  - O servidor responde com **302** e o status do cliente muda no banco.
  - No teste realizado, o cliente foi para `SUSPENSO` e depois restaurado para `ATIVO`.

### Qualidade aplicada em todas as atividades

- **O que é:** padronização técnica exigida pelo checklist.
- **Onde foi realizada:** em todos os arquivos PHP do projeto e nas views alteradas.
- **Como foi realizada:**
  - `declare(strict_types=1);` nos 35 arquivos PHP fora `vendor` e views Blade.
  - Comentários e documentação em pt-BR.
  - Métodos com no máximo 20 linhas.
  - `@csrf` em formulários `POST`, `PUT`, `PATCH` e `DELETE`.
  - `@method()` para Method Spoofing.
  - `route('nome.da.rota')` em links e formulários.
  - Constraints ativas nos parâmetros dinâmicos.
  - Validação e atualização separadas por responsabilidade.

---

# PARTE A — QUESTÕES TEÓRICAS DE FIXAÇÃO

## 1. Semântica RESTful

O método `GET` é definido pelo protocolo HTTP como **seguro** e **idempotente**: ele deve apenas consultar informações, sem alterar o estado do servidor. Uma exclusão via `GET` quebra esse contrato e permite que a ação seja disparada por agentes que não têm intenção de excluir nada, como:

- robôs de busca que rastreiam links;
- navegadores que fazem pré-carregamento (`prefetch`) de páginas;
- antivírus e sistemas de cache;
- um simples clique acidental ou um link compartilhado.

O risco é a **exclusão em massa sem autenticação ou confirmação**. A ação correta é `DELETE /clientes/{id}`, enviada por formulário com `@method('DELETE')` e protegida por `@csrf`.

## 2. Idempotência

Idempotência significa que **repetir a mesma requisição várias vezes produz o mesmo estado final** no servidor.

- `PUT /clientes/10` com o mesmo corpo atualiza o cliente 10 para aquele estado. Se a requisição for repetida, o resultado final continua sendo o mesmo cliente 10 com os mesmos dados.
- `POST /clientes` cria um **novo** recurso a cada execução. Duas requisições iguais podem gerar dois clientes diferentes, por isso o `POST` não é idempotente.
- `PATCH` também pode não ser idempotente quando a operação é incremental, por exemplo “somar 10 ao saldo”.

## 3. Resource Controllers

O comando `php artisan make:controller ClienteController --resource` gera as sete ações canônicas:

| Ação | Verbo | URI típica | Responsabilidade |
|---|---|---|---|
| `index()` | GET | `/clientes` | Listar os registros |
| `create()` | GET | `/clientes/create` | Exibir o formulário de cadastro |
| `store()` | POST | `/clientes` | Validar e salvar um novo registro |
| `show()` | GET | `/clientes/{cliente}` | Exibir um registro específico |
| `edit()` | GET | `/clientes/{cliente}/edit` | Exibir o formulário de edição |
| `update()` | PUT/PATCH | `/clientes/{cliente}` | Validar e atualizar um registro |
| `destroy()` | DELETE | `/clientes/{cliente}` | Excluir um registro |

## 4. Injeção de Dependências

O **Service Container** do Laravel resolve as dependências dos métodos de controller por meio de **reflexão**. Quando o método declara `Request $request`, o container identifica o tipo solicitado, localiza o binding da requisição HTTP atual e injeta a instância já preparada pelo framework.

Por isso não é necessário escrever `new Request()`: a requisição já foi criada pelo kernel do Laravel e o container apenas a entrega ao método.

```php
public function store(Request $request): RedirectResponse
{
    $dados = $request->validate([...]);

    // ...
}
```

## 5. Method Spoofing

Formulários HTML tradicionais suportam nativamente apenas `GET` e `POST`. Os navegadores não enviam `PUT`, `PATCH` ou `DELETE` diretamente pelo atributo `method` de um `<form>`.

O Laravel contorna essa limitação com **Method Spoofing**:

1. O formulário é enviado por `POST`;
2. A diretiva `@method('PUT')`, `@method('PATCH')` ou `@method('DELETE')` gera um campo oculto `_method`;
3. O middleware do Laravel lê esse campo e despacha a requisição para o verbo correto.

```blade
<form action="{{ route('clientes.update', $cliente['id']) }}" method="POST">
    @csrf
    @method('PUT')
    <!-- campos -->
</form>
```

## 6. Ataques CSRF

**Cross-Site Request Forgery** é um ataque em que um site malicioso induz o navegador da vítima a enviar uma requisição autenticada para outro site. O navegador anexa automaticamente os cookies da sessão, então a requisição parece legítima.

A diretiva `@csrf` gera um campo oculto `_token` com um valor imprevisível associado à sessão. O middleware `VerifyCsrfToken` compara o token enviado com o token da sessão. Se eles não coincidirem, o Laravel bloqueia a requisição com **HTTP 419 (Page Expired)**. Um site externo não consegue ler o token da página legítima por causa da política de mesma origem do navegador.

## 7. Constraints de Rota

Constraints restringem o formato dos parâmetros dinâmicos antes de o controller ser executado:

- `whereNumber('id')`: aceita apenas dígitos;
- `whereAlphaNumeric('codigo')`: aceita letras e números;
- `where('ano', '[0-9]{4}')`: aceita exatamente quatro dígitos.

Quando o valor não corresponde à restrição, a rota **não é considerada uma correspondência** e o Laravel retorna **HTTP 404 (Not Found)**. Isso evita consultas desnecessárias ao banco e reduz a superfície de entrada de dados inválidos.

## 8. Rotas Nomeadas

Usar `route('clientes.show', $id)` em vez de `"/clientes/{$id}"` traz vantagens corporativas:

1. **Fonte única de verdade:** se a URI mudar, basta alterar a definição da rota. Todos os links, formulários e redirecionamentos continuam funcionando.
2. **Segurança e codificação:** o helper trata a montagem da URL e a codificação dos parâmetros, reduzindo erros de concatenação e links quebrados.
3. **Testabilidade e legibilidade:** o nome da rota expressa a intenção (`clientes.show`) e pode ser usado em testes e em outros módulos sem conhecer a URI final.
4. **Menos acoplamento:** views e controllers não precisam saber se a URL tem prefixo, idioma ou versão.

## 9. Single Responsibility no Controller

Cada método deve ter **uma responsabilidade clara**. Validação, regra de negócio, persistência e resposta são etapas diferentes. Manter a validação enxuta dentro do controller:

- facilita a leitura e a revisão de código;
- respeita o limite de 20 linhas por função;
- evita duplicação quando a mesma regra é usada em `store()` e `update()`;
- permite extrair a validação para um **Form Request** quando as regras crescerem;
- deixa o controller focado em orquestrar a requisição e a resposta.

Em cenários maiores, a regra de negócio deve ir para um Service ou para o Model, deixando o controller apenas como ponto de entrada HTTP.

## 10. Ferramenta `route:list`

O comando `php artisan route:list` apresenta a matriz de rotas da aplicação: método HTTP, URI, nome, controller/ação e middlewares. Ele ajuda equipes multidisciplinares a:

- documentar os endpoints disponíveis;
- auditar quais ações estão públicas ou protegidas;
- detectar conflitos de URI e rotas duplicadas;
- verificar se um resource foi realmente limitado com `only()` ou `except()`;
- validar o impacto de uma alteração antes do deploy.

Variações úteis:

```bash
php artisan route:list --path=clientes
php artisan route:list --path=fornecedores
php artisan route:list -v
php artisan route:list --json
```

---

# PARTE B — EXERCÍCIOS PRÁTICOS

## Exercício 1 — Rota com múltiplos parâmetros e constraints compostas

**Rota implementada em `routes/web.php`:**

```php
Route::get("/clientes/{cliente}/contratos/{ano}", [ClienteController::class, "contratosPorAno"])
    ->name("clientes.contratos")
    ->whereNumber("cliente")
    ->where("ano", "[0-9]{4}");
```

**Método em `app/Http/Controllers/ClienteController.php`:**

```php
public function contratosPorAno(int $cliente, int $ano): View
{
    $parceiro = Cliente::findOrFail($cliente);
    $contratos = collect($this->contratosMockados())
        ->where("cliente_id", $cliente)
        ->where("ano", $ano)
        ->values();

    return view("clientes.contratos", [
        "cliente" => $parceiro,
        "contratos" => $contratos,
        "ano" => $ano,
        "titulo" => "Contratos {$ano}: {$parceiro["razao_social"]}"
    ]);
}
```

A view `resources/views/clientes/contratos.blade.php` exibe o cliente, o ano e a tabela de contratos. Os dados são simulados em `contratosMockados()` para manter o foco do exercício em rotas e controllers.

**Testes realizados:**

```text
200 /clientes/2/contratos/2026   → ano válido
404 /clientes/2/contratos/26     → ano com 2 dígitos
404 /clientes/abc/contratos/2026 → cliente não numérico
```

---

## Exercício 2 — Resource Controller parcial com `only()`

**Rota implementada em `routes/web.php`:**

```php
Route::resource("fornecedores", FornecedorController::class)
    ->parameters(["fornecedores" => "fornecedor"])
    ->only(["index", "show"])
    ->whereNumber("fornecedor");
```

O `FornecedorController` foi gerado com:

```bash
php artisan make:controller FornecedorController --resource
```

Como a rota é pública e somente leitura, apenas `index()` e `show()` foram implementados. O `->only()` remove `create`, `store`, `edit`, `update` e `destroy` da matriz de rotas. O `->parameters()` garante que o parâmetro se chame `{fornecedor}`, permitindo que o `whereNumber()` funcione corretamente.

**Comprovação com `php artisan route:list --path=fornecedores`:**

```text
 GET|HEAD fornecedores .. fornecedores.index › FornecedorController@index
 GET|HEAD fornecedores/{fornecedor} .. fornecedores.show › FornecedorController@show

 Showing [2] routes
```

As rotas de criação, edição e exclusão não aparecem. Acesso direto a `/fornecedores/1/edit` retorna **404**.

---

## Exercício 3 — Injeção de Dependência e cabeçalhos HTTP

**Rota implementada em `routes/web.php`:**

```php
Route::get("/clientes/telemetria", [ClienteController::class, "origemRequisicao"])
    ->name("clientes.telemetria");
```

**Método em `app/Http/Controllers/ClienteController.php`:**

```php
public function origemRequisicao(Request $request): JsonResponse
{
    return response()->json([
        "ip" => $request->ip(),
        "user_agent" => $request->userAgent(),
        "metodo" => $request->method(),
        "rota" => $request->path(),
        "timestamp" => now()->toIso8601String()
    ]);
}
```

A rota foi declarada **antes** do `Route::resource("clientes", ...)` para não ser capturada por `/clientes/{cliente}`.

**Resposta obtida em `GET /clientes/telemetria`:**

```json
{
  "ip": "127.0.0.1",
  "user_agent": "curl/8.21.0",
  "metodo": "GET",
  "rota": "clientes/telemetria",
  "timestamp": "2026-11-11T20:01:39+00:00"
}
```

---

## Exercício 4 — Agrupamento administrativo com prefixo, nome e middleware

**Rota implementada em `routes/web.php`:**

```php
Route::prefix("admin")
    ->name("admin.")
    ->middleware("throttle:60,1")
    ->group(function (): void {
        Route::get("/auditoria/clientes", [ClienteController::class, "auditoriaClientes"])
            ->name("auditoria.clientes");
    });
```

O grupo aplica:

- prefixo de URI `admin/`;
- prefixo de nome `admin.`;
- middleware `throttle:60,1` (limite de 60 requisições por minuto).

**Método em `ClienteController`:**

```php
public function auditoriaClientes(): View
{
    $totalAtivos = Cliente::query()->where("status", "ATIVO")->count();

    return view("admin.auditoria.clientes", [
        "totalAtivos" => $totalAtivos,
        "titulo" => "Auditoria de Parceiros Ativos"
    ]);
}
```

**Teste da geração da URL:**

```bash
php artisan tinker --execute="echo route('admin.auditoria.clientes');"
```

Resultado:

```text
http://localhost:8000/admin/auditoria/clientes
```

A rota também aparece em `php artisan route:list --path=admin` e o acesso direto retorna **200**.

---

## Exercício 5 — Alteração parcial com PATCH

**Rota implementada em `routes/web.php`:**

```php
Route::patch("/clientes/{id}/status", [ClienteController::class, "alterarStatus"])
    ->name("clientes.status")
    ->whereNumber("id");
```

**Método em `ClienteController`:**

```php
public function alterarStatus(Request $request, int $id): RedirectResponse
{
    $dados = $request->validate([
        "status" => "required|in:ATIVO,SUSPENSO"
    ]);

    Cliente::findOrFail($id)->update(["status" => $dados["status"]]);

    return redirect()->route("clientes.index")
        ->with("sucesso", "Status do parceiro atualizado com sucesso!");
}
```

**Botão na view `resources/views/clientes/index.blade.php`:**

```blade
<form action="{{ route('clientes.status', $c['id']) }}" method="POST">
    @csrf
    @method('PATCH')
    <input type="hidden" name="status" value="{{ $c['status'] === 'ATIVO' ? 'SUSPENSO' : 'ATIVO' }}">
    <button type="submit" class="btn-status">
        {{ $c['status'] === 'ATIVO' ? 'Suspender' : 'Ativar' }}
    </button>
</form>
```

O botão alterna entre **ATIVO** e **SUSPENSO**. O formulário usa `POST` como transporte, `@method('PATCH')` para o Method Spoofing e `@csrf` para a proteção contra CSRF.

**Teste realizado:**

```text
HTTP PATCH /clientes/2/status → 302 (redirecionamento)
Status no banco após a requisição → SUSPENSO
Status restaurado ao final do teste → ATIVO
```

---

# Mapa de arquivos

| Arquivo | Alteração |
|---|---|
| `routes/web.php` | Rotas dos exercícios 1 a 5, correção do `whereNumber("cliente")` e resource parcial de fornecedores |
| `app/Http/Controllers/ClienteController.php` | Métodos `contratosPorAno`, `origemRequisicao`, `auditoriaClientes` e `alterarStatus` |
| `app/Http/Controllers/FornecedorController.php` | Controller gerado com `--resource`, com `index` e `show` públicos |
| `resources/views/clientes/index.blade.php` | Link de contratos, link de auditoria e botão PATCH de status |
| `resources/views/clientes/contratos.blade.php` | View do exercício 1 |
| `resources/views/fornecedores/index.blade.php` | Lista pública de fornecedores |
| `resources/views/fornecedores/show.blade.php` | Ficha pública de fornecedor |
| `resources/views/admin/auditoria/clientes.blade.php` | Painel de auditoria administrativa |

---

# CHECKLIST DE QUALIDADE E BOAS PRÁTICAS

- [x] Todas as ações do CRUD de clientes usam verbos HTTP semânticos (`GET`, `POST`, `PUT/PATCH`, `DELETE`).
- [x] O `ClienteController` foi gerado via Artisan com a flag `--resource`.
- [x] As rotas de formulário `POST`, `PUT`, `PATCH` e `DELETE` contêm `@csrf`.
- [x] Os formulários de edição, exclusão e status usam Method Spoofing (`@method('PUT')`, `@method('DELETE')`, `@method('PATCH')`).
- [x] As URLs de links e formulários usam o helper `route('nome.da.rota')`.
- [x] `store()` e `update()` recebem `Request $request` via Injeção de Dependências.
- [x] Os parâmetros dinâmicos possuem constraints ativas (`whereNumber`, `whereAlphaNumeric`, `where` com regex).
- [x] Todos os métodos possuem no máximo 20 linhas.
- [x] Os 35 arquivos PHP do projeto (fora `vendor` e views Blade) possuem `declare(strict_types=1);`.
- [x] Comentários e documentação técnica estão em português do Brasil (pt-BR).

---

# Observações finais

- A pasta `PHPLaravel/Exercicios/senai-asset-manager` é uma cópia executável do projeto `senai-asset-manager`, mantendo o mesmo padrão de controllers, models, views Blade e configuração de banco.
- Os dados de contratos e fornecedores são simulados para que o laboratório foque em **Controllers e Routes**, sem exigir novas migrações.
- Caso a atividade evolua para persistência real, o próximo passo natural é criar os models `Contrato` e `Fornecedor` com suas migrations e relacionamentos, mantendo as mesmas rotas e constraints já implementadas.
