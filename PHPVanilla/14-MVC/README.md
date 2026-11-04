Parte A: Questões Teóricas de Fixação
1. O Colapso do Código Espaguete

Manter consultas SQL, regras de validação e HTML no mesmo arquivo dificulta a manutenção, pois mistura responsabilidades diferentes. Isso torna o código mais complexo, aumenta a chance de erros e dificulta a reutilização e a expansão do sistema.

2. A Tríade MVC
- Model: gerencia os dados e as regras de negócio.
- View: apresenta as informações ao usuário por meio da interface.
- Controller: recebe as requisições, coordena o processamento e encaminha os dados para a View.
As regras de negócio devem ficar principalmente no Model.

3. O Papel do Composer

O composer.json define as dependências e as configurações do projeto. O composer.lock registra as versões exatas das dependências instaladas. A pasta vendor/ não deve ser versionada no Git porque contém bibliotecas instaladas pelo Composer e pode ser recriada com o comando composer install.

4. A Especificação PSR-4

O Autoloader PSR-4 utiliza o namespace App\Controllers\ProdutoController para localizar o arquivo correspondente. Com o mapeamento App\\ para src/, ele encontra automaticamente src/Controllers/ProdutoController.php, sem precisar de vários comandos require.

5. Front Controller

A principal vantagem de segurança é centralizar as requisições em public/index.php e impedir o acesso direto aos arquivos internos do sistema. Isso protege arquivos de configuração, códigos-fonte e credenciais contra exposição pública.

6. Roteador HTTP

O Roteador verifica o método HTTP e a URL da requisição. Assim, diferencia GET /produtos, utilizado para consultar produtos, de POST /produtos, utilizado normalmente para cadastrar um produto.

7. Injeção de Dados na View

A função extract() transforma as chaves de um array em variáveis PHP locais. No método renderizar(), ela permite que os dados enviados pelo Controller sejam utilizados diretamente na View.

8. Segurança contra XSS nas Views

A função htmlspecialchars() converte caracteres especiais em entidades HTML, dificultando a execução de scripts maliciosos inseridos por usuários. Isso ajuda a prevenir ataques XSS e protege os dados exibidos nas páginas.

9. Single Responsibility no Controller

O Controller não deve conter comandos SQL nem criar conexões diretamente com new PDO() porque sua responsabilidade é coordenar as requisições. O acesso ao banco deve ficar em classes específicas, como DAO ou Repository, facilitando a manutenção, os testes e a reutilização do código.

10. Transição para o Framework Laravel

Os conceitos utilizados no MVC artesanal também aparecem no Laravel 11, como:
- MVC: separação entre Model, View e Controller.
- Rotas: definição dos caminhos e métodos HTTP.
- Composer: gerenciamento de dependências.
- PSR-4: carregamento automático de classes.
- Front Controller: entrada centralizada pelo public/index.php.
- Views: utilização do mecanismo Blade para apresentar dados.
- Controllers: processamento e coordenação das requisições.
- Models e Eloquent ORM: representação e manipulação dos dados.
- Segurança: validação, proteção contra XSS e consultas parametrizadas.
Esses conceitos facilitam a compreensão do Laravel, pois o framework organiza e amplia práticas que já existem no MVC artesanal.Parte A: Questões Teóricas de Fixação
1. O Colapso do Código Espaguete

Manter consultas SQL, regras de validação e HTML no mesmo arquivo dificulta a manutenção, pois mistura responsabilidades diferentes. Isso torna o código mais complexo, aumenta a chance de erros e dificulta a reutilização e a expansão do sistema.

2. A Tríade MVC
- Model: gerencia os dados e as regras de negócio.
- View: apresenta as informações ao usuário por meio da interface.
- Controller: recebe as requisições, coordena o processamento e encaminha os dados para a View.
As regras de negócio devem ficar principalmente no Model.

3. O Papel do Composer

O composer.json define as dependências e as configurações do projeto. O composer.lock registra as versões exatas das dependências instaladas. A pasta vendor/ não deve ser versionada no Git porque contém bibliotecas instaladas pelo Composer e pode ser recriada com o comando composer install.

4. A Especificação PSR-4

O Autoloader PSR-4 utiliza o namespace App\Controllers\ProdutoController para localizar o arquivo correspondente. Com o mapeamento App\\ para src/, ele encontra automaticamente src/Controllers/ProdutoController.php, sem precisar de vários comandos require.

5. Front Controller

A principal vantagem de segurança é centralizar as requisições em public/index.php e impedir o acesso direto aos arquivos internos do sistema. Isso protege arquivos de configuração, códigos-fonte e credenciais contra exposição pública.

6. Roteador HTTP

O Roteador verifica o método HTTP e a URL da requisição. Assim, diferencia GET /produtos, utilizado para consultar produtos, de POST /produtos, utilizado normalmente para cadastrar um produto.

7. Injeção de Dados na View

A função extract() transforma as chaves de um array em variáveis PHP locais. No método renderizar(), ela permite que os dados enviados pelo Controller sejam utilizados diretamente na View.

8. Segurança contra XSS nas Views

A função htmlspecialchars() converte caracteres especiais em entidades HTML, dificultando a execução de scripts maliciosos inseridos por usuários. Isso ajuda a prevenir ataques XSS e protege os dados exibidos nas páginas.

9. Single Responsibility no Controller

O Controller não deve conter comandos SQL nem criar conexões diretamente com new PDO() porque sua responsabilidade é coordenar as requisições. O acesso ao banco deve ficar em classes específicas, como DAO ou Repository, facilitando a manutenção, os testes e a reutilização do código.

10. Transição para o Framework Laravel

Os conceitos utilizados no MVC artesanal também aparecem no Laravel 11, como:
- MVC: separação entre Model, View e Controller.
- Rotas: definição dos caminhos e métodos HTTP.
- Composer: gerenciamento de dependências.
- PSR-4: carregamento automático de classes.
- Front Controller: entrada centralizada pelo public/index.php.
- Views: utilização do mecanismo Blade para apresentar dados.
- Controllers: processamento e coordenação das requisições.
- Models e Eloquent ORM: representação e manipulação dos dados.
- Segurança: validação, proteção contra XSS e consultas parametrizadas.
Esses conceitos facilitam a compreensão do Laravel, pois o framework organiza e amplia práticas que já existem no MVC artesanal.