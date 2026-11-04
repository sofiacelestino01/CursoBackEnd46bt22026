Parte A — Questões teóricas
1. O Colapso do Código Espaguete

Manter consultas SQL, regras de validação e HTML no mesmo arquivo dificulta a manutenção porque qualquer alteração pode afetar outras partes do sistema. A separação por responsabilidades facilita os testes, a reutilização do código e a expansão da aplicação.

2. A Tríade MVC
- Model: trabalha com os dados e as regras de negócio.
- View: apresenta as informações para o usuário.
- Controller: recebe as requisições e coordena a comunicação entre Model e View.
As regras de negócio ficam principalmente na camada Model ou em serviços específicos, e não concentradas no Controller.

3. O Papel do Composer

O composer.json define as dependências e as configurações de autoload do projeto. O composer.lock registra as versões exatas das dependências instaladas. A pasta vendor/ não deve ser versionada porque pode ser recriada com o Composer, evitando arquivos desnecessários no Git.

4. A Especificação PSR-4

O autoload PSR-4 relaciona namespaces a diretórios. Se o composer.json tiver "App\\": "src/", a classe App\Controllers\ProdutoController será procurada em src/Controllers/ProdutoController.php. Assim, não precisamos utilizar require_once manualmente para cada classe.

5. Front Controller

O Front Controller centraliza as requisições em public/index.php. Isso facilita o controle das rotas e reduz o risco de expor arquivos internos, como configurações, credenciais e código-fonte.

6. Roteador HTTP

O roteador verifica o método HTTP e a URL da requisição. Assim, consegue diferenciar GET /produtos, utilizado para consultar produtos, de POST /produtos, que pode ser utilizado para enviar dados ao servidor.

7. Injeção de Dados na View

A função extract() transforma as chaves de um array em variáveis locais. Por exemplo, o array ['nome' => 'Produto'] disponibiliza a variável $nome para a View. É importante utilizar essa função com dados controlados para evitar conflitos de nomes.

8. Segurança contra XSS nas Views

A função htmlspecialchars() transforma caracteres especiais em entidades HTML. Isso impede que valores inseridos por usuários sejam interpretados diretamente como marcação HTML ou scripts na página.

Exemplo:
htmlspecialchars($produto['nome'], ENT_QUOTES, 'UTF-8');


9. Single Responsibility no Controller

O Controller deve coordenar as requisições, sem concentrar conexões PDO e consultas SQL. Essas operações pertencem à camada Model ou DAO. Além de melhorar a organização, utilizar Prepared Statements ajuda a prevenir SQL Injection.

10. Transição para o Framework Laravel

Os conceitos que continuam sendo utilizados no Laravel 11 são MVC, rotas HTTP, Controllers, Models, Views, autoload PSR-4, separação de responsabilidades e proteção contra XSS. A diferença é que o Laravel fornece ferramentas prontas para implementar esses conceitos.