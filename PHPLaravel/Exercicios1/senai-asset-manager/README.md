# LISTA DE EXERCÍCIOS — CONTROLLERS E ROUTES NO LARAVEL

## PARTE A — QUESTÕES TEÓRICAS DE FIXAÇÃO

### 1. Semântica RESTful

**Por que uma ação de exclusão de dados nunca deve ser implementada através de uma requisição HTTP do tipo GET? Explique o risco associado a robôs de busca.**

O método GET deve ser utilizado exclusivamente para consultar e recuperar informações, sem modificar os dados armazenados no sistema. Implementar uma exclusão utilizando esse método viola os princípios da arquitetura REST e pode causar problemas de segurança e integridade dos dados.

Um dos principais riscos está relacionado aos robôs de busca, navegadores e outros sistemas automatizados que podem acessar URLs automaticamente. Caso uma rota GET execute uma exclusão, esses acessos podem provocar a remoção de registros sem a intenção do usuário. Por isso, operações de exclusão devem utilizar o método HTTP DELETE.

### 2. Idempotência

**O que significa o conceito de idempotência no protocolo HTTP e por que o método PUT é considerado idempotente enquanto o POST não é?**

Idempotência é uma propriedade de determinados métodos HTTP que garante que a execução repetida de uma mesma requisição produza o mesmo estado final no servidor.

O método PUT é considerado idempotente porque substitui ou atualiza um recurso para um estado específico. Mesmo que a mesma requisição seja enviada várias vezes, o resultado final permanece igual.

Já o POST não é necessariamente idempotente, pois geralmente é utilizado para criar novos registros. Quando uma mesma requisição POST é enviada várias vezes, pode ocorrer a criação de vários registros diferentes no banco de dados.

**Exemplo:** enviar um PUT para atualizar o nome de um cliente mantém o mesmo resultado após várias execuções. Já enviar um POST de cadastro repetidamente pode criar vários clientes.

### 3. Resource Controllers

**Quais são as 7 ações canônicas geradas pelo comando `php artisan make:controller --resource` e qual é a responsabilidade de cada uma?**

Resource Controllers são controllers que seguem uma estrutura padronizada para implementar as operações CRUD (Create, Read, Update e Delete). O Laravel disponibiliza sete métodos principais:

1. **`index()`**: responsável por listar todos os registros de determinado recurso, normalmente exibindo uma tabela com os dados cadastrados.

2. **`create()`**: apresenta o formulário utilizado para cadastrar um novo registro, permitindo que o usuário informe os dados necessários.

3. **`store()`**: recebe os dados enviados pelo formulário, realiza as validações necessárias e armazena o novo registro no banco de dados.

4. **`show()`**: apresenta as informações detalhadas de um registro específico, geralmente identificado por um ID.

5. **`edit()`**: apresenta o formulário de edição preenchido com os dados atuais do registro selecionado.

6. **`update()`**: recebe os dados modificados, valida as informações e atualiza o registro existente no banco de dados.

7. **`destroy()`**: executa a exclusão de um registro, removendo-o do sistema conforme as regras estabelecidas pela aplicação.

Essas sete ações facilitam a organização do código, padronizam as operações e reduzem a necessidade de criar rotas manualmente para cada funcionalidade.

### 4. Injeção de Dependências

**Como o Service Container do Laravel entrega automaticamente uma instância de Request ao método do controller sem que tenhamos que instanciá-la com `new Request()`?**

O Service Container é um recurso do Laravel responsável por gerenciar e disponibilizar as dependências utilizadas pela aplicação.

Quando um método de um controller declara uma classe como parâmetro, por exemplo `Request $request`, o Laravel identifica automaticamente o tipo solicitado e utiliza seu sistema de resolução de dependências para fornecer a instância correspondente.

Dessa maneira, não é necessário utilizar `new Request()`, pois o próprio framework disponibiliza o objeto com as informações da requisição HTTP atual, incluindo parâmetros, dados enviados pelos formulários, cabeçalhos e informações do usuário.

**Exemplo:**

```php
public function store(Request $request): RedirectResponse
{
    $dados = $request->all();

    // Processamento dos dados recebidos.
}
```

Esse mecanismo torna o código mais organizado, reutilizável e fácil de manter.

### 5. Method Spoofing

**Por que os navegadores web não conseguem enviar requisições nativas de PUT e DELETE através de formulários HTML convencionais? Como o Laravel contorna essa limitação?**

Os formulários HTML convencionais possuem suporte nativo apenas aos métodos GET e POST. Por isso, não conseguem enviar diretamente requisições PUT, PATCH e DELETE.

Para contornar essa limitação, o Laravel utiliza uma técnica chamada Method Spoofing, que consiste em adicionar um campo oculto ao formulário informando qual método HTTP deverá ser considerado pelo framework.

Isso é realizado por meio da diretiva Blade `@method()`.

**Exemplo:**

```blade
<form action="{{ route('clientes.update', $cliente->id) }}" method="POST">
    @csrf
    @method('PUT')

    <button type="submit">Atualizar</button>
</form>
```

Nesse exemplo, o navegador envia uma requisição POST, mas o Laravel interpreta a operação como PUT, permitindo a atualização do registro.

### 6. Ataques CSRF

**O que é um ataque do tipo Cross-Site Request Forgery e como a diretiva Blade `@csrf` impede que sites maliciosos forjem requisições em nome do usuário?**

CSRF (Cross-Site Request Forgery) é um tipo de ataque em que um site malicioso tenta induzir um usuário autenticado a realizar uma ação não autorizada em outro sistema.

Esse ataque pode explorar uma sessão já autenticada no navegador, fazendo com que uma requisição seja enviada sem o conhecimento ou a intenção do usuário.

Para evitar esse problema, o Laravel disponibiliza proteção contra CSRF por meio de tokens de segurança. A diretiva Blade `@csrf` gera automaticamente um campo oculto contendo um token associado à sessão do usuário.

Quando uma requisição é enviada, o Laravel verifica se o token recebido é válido. Caso esteja ausente ou incorreto, a requisição é rejeitada.

**Exemplo:**

```blade
<form action="{{ route('clientes.store') }}" method="POST">
    @csrf

    <button type="submit">Cadastrar</button>
</form>
```

Essa proteção é fundamental para garantir a segurança das operações realizadas por formulários na aplicação.

### 7. Constraints de Rota

**Para que servem métodos de restrição como `whereNumber('id')` ou `whereAlphaNumeric('codigo')` e qual código de status HTTP o Laravel retorna quando o formato é violado?**

Constraints são restrições aplicadas aos parâmetros dinâmicos das rotas para controlar quais formatos de valores podem ser recebidos pela aplicação.

O Laravel disponibiliza métodos específicos para facilitar essa validação:

- **`whereNumber('id')`**: permite somente valores numéricos no parâmetro ID.
- **`whereAlphaNumeric('codigo')`**: permite somente letras e números no parâmetro código.
- **`where('ano', '[0-9]{4}')`**: permite somente valores compostos por exatamente quatro dígitos numéricos.

**Exemplo:**

```php
Route::get('/clientes/{id}', [ClienteController::class, 'show'])
    ->whereNumber('id');
```

Nesse caso, a rota aceita endereços com IDs numéricos. Caso o parâmetro não corresponda ao formato estabelecido, o Laravel não reconhece a rota e retorna o código HTTP **404 (Not Found)**.

As constraints ajudam a evitar parâmetros inválidos e tornam o sistema de rotas mais previsível e organizado.

### 8. Rotas Nomeadas

**Cite duas vantagens corporativas de utilizar a função auxiliar `route('clientes.show', $id)` nas views em vez de escrever strings estáticas como `"/clientes/{$id}"`.**

As rotas nomeadas permitem identificar cada endereço da aplicação por um nome específico, facilitando sua utilização em controllers, views e formulários.

Duas vantagens importantes são:

1. **Facilidade de manutenção:** caso o endereço de uma rota seja alterado, basta atualizar sua definição no arquivo de rotas. Os links que utilizam o helper `route()` continuam funcionando, desde que o nome da rota seja mantido.

2. **Organização e padronização:** permite utilizar referências centralizadas para gerar URLs, evitando a repetição de caminhos fixos em diferentes arquivos do projeto.

**Exemplo:**

```blade
<a href="{{ route('clientes.show', $cliente->id) }}">
    Visualizar cliente
</a>
```

Dessa forma, a aplicação fica mais flexível, organizada e fácil de manter.

### 9. Single Responsibility no Controller

**Por que a validação de formulários com `$request->validate()` ou Form Requests deve ser mantida enxuta dentro do controller para respeitar o limite de 20 linhas por função?**

O princípio Single Responsibility estabelece que cada método deve possuir uma responsabilidade específica, evitando que diferentes tarefas sejam concentradas em uma única função.

No Laravel, a validação pode ser realizada diretamente com `$request->validate()` ou utilizando classes específicas chamadas Form Requests.

Manter os métodos dos controllers enxutos facilita a leitura, manutenção e identificação de erros. Além disso, evita que o controller concentre responsabilidades que poderiam ser organizadas em outras partes da aplicação.

O limite de 20 linhas estabelecido na atividade é uma orientação de Clean Code para incentivar métodos menores, objetivos e com responsabilidades bem definidas.

**Exemplo:**

```php
public function store(Request $request): RedirectResponse
{
    $dados = $request->validate([
        'razao_social' => 'required|min:3',
        'cnpj' => 'required|unique:clientes,cnpj',
        'setor' => 'required'
    ]);

    Cliente::create($dados);

    return redirect()->route('clientes.index');
}
```

### 10. A Ferramenta route:list

**Como o comando `php artisan route:list` auxilia equipes multidisciplinares a documentar e auditar os endpoints disponíveis em uma API ou aplicação web?**

O comando `php artisan route:list` é uma ferramenta disponibilizada pelo Artisan para apresentar todas as rotas registradas na aplicação Laravel.

Sua execução exibe informações importantes, como:

- **Method:** método HTTP utilizado pela rota, como GET, POST, PUT, PATCH ou DELETE.
- **URI:** endereço utilizado para acessar o recurso.
- **Name:** nome atribuído à rota, quando existente.
- **Action:** controller e método responsáveis pelo processamento da requisição.
- **Middleware:** mecanismos de proteção e controle de acesso aplicados à rota.

Essa ferramenta facilita o trabalho de desenvolvedores, testadores e responsáveis pela manutenção do sistema, pois permite visualizar os endpoints disponíveis, identificar rotas duplicadas, verificar os métodos HTTP utilizados e conferir a aplicação de middlewares.

Também é possível utilizar filtros para visualizar apenas determinadas rotas.

**Exemplo:**

```bash
php artisan route:list --path=clientes
```

Esse comando apresenta somente as rotas relacionadas a clientes, facilitando a análise e a auditoria de funcionalidades específicas da aplicação.

