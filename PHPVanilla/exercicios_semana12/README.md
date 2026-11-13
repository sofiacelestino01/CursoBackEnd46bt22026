# Semana 12 — Lista de Exercícios MVC

## Parte A — Questões Teóricas (resumidas)

1. **Colapso do código espaguete:** misturar SQL, validação e HTML no mesmo arquivo acopla camadas diferentes: qualquer mudança de layout pode quebrar regras de negócio, o código não pode ser testado nem reaproveitado, e vários desenvolvedores passam a editar o mesmo arquivo, dificultando manutenção e escalabilidade.

2. **Tríade MVC:** o **Model** cuida dos dados e das regras de negócio (SQL, validações); a **View** apenas exibe os dados em HTML; o **Controller** recebe a requisição, decide o que fazer e coordena Model e View. As regras de negócio ficam no **Model**.

3. **Composer:** o `composer.json` declara as dependências e o autoload desejado (do desenvolvedor); o `composer.lock` congela as versões exatas instaladas (gerado pelo Composer). A pasta `vendor/` não vai para o Git porque é código de terceiros recriável com `composer install` a partir do `composer.lock` — versionar só inflaria o repositório.

4. **PSR-4:** o autoloader troca o separador do namespace `\` pelo separador de pastas `/`, remove o prefixo `App\` (mapeado para `src/` no composer.json) e procura o arquivo com o mesmo nome da classe. `App\Controllers\ProdutoController` vira `src/Controllers/ProdutoController.php`.

5. **Front Controller:** com tudo centralizado em `public/index.php`, os arquivos-fonte (config, SQL, models) ficam fora da raiz pública e não podem ser acessados diretamente pela URL, evitando exposição de código-fonte, credenciais e execução indevida de scripts.

6. **Roteador HTTP:** as rotas são registradas por método HTTP em arrays separados (`$rotas['GET']` e `$rotas['POST']`), então `GET /produtos` e `POST /produtos` caem em ações diferentes mesmo com a mesma URI.

7. **extract() na View:** dentro do `renderizar()`, o `extract($dados)` transforma cada chave do array em uma variável local (ex.: `'produtos' => [...]` vira `$produtos`), que fica disponível na view incluída em seguida pelo `require`.

8. **htmlspecialchars():** escapa caracteres especiais (`<`, `>`, `&`, `"`, `'`), neutralizando XSS: se um usuário cadastra `<script>` num campo, o navegador exibe o texto em vez de executar o código.

9. **SRP no Controller:** SQL concatenado no Controller abre brecha de SQL Injection e fere a responsabilidade única — acesso a dados é papel do Model. O Controller só orquestra, sempre com Prepared Statements no Model.

10. **Laravel 11:** Front Controller (`public/index.php`), Rotas (`routes/web.php` com `Route::get/post`), Controllers (`app/Http/Controllers`), Models/Eloquent, Views Blade (equivalente às views PHP), PSR-4/Composer e validação/CSRF — os mesmos conceitos do MVC artesanal, agora prontos de fábrica.

