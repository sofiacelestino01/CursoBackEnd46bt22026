# Lista de Exercícios — Controllers e Routes no Laravel


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


