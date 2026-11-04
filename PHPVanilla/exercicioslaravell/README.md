## Parte A — Questões teóricas
1. Evolução Arquitetural

*Na construção do MVC artesanal da Semana 12, aprendi a separar as responsabilidades do sistema entre Model, View e Controller. O Model trabalha com os dados, a View apresenta as informações e o Controller recebe as requisições e controla o fluxo da aplicação. O Laravel facilita esse processo, pois já possui uma estrutura organizada e ferramentas prontas.*

2. A Nova Arquitetura do Laravel 11

*O Laravel 11 simplificou a estrutura inicial do projeto, reduzindo a quantidade de arquivos de configuração. O principal ponto central de configuração da aplicação passou a ser o arquivo bootstrap/app.php, que permite configurar rotas, middleware e tratamento de exceções.*

3. Padrão 12-Factor App

*Gravar senhas diretamente em config/database.php é uma prática insegura, pois as credenciais podem acabar expostas no Git ou compartilhadas com outras pessoas. O correto é utilizar variáveis de ambiente no arquivo .env, que deve ser ignorado pelo Git.*

4. O Papel da APP_KEY

*Alterar a APP_KEY em uma aplicação que já está em produção pode impedir a leitura de dados criptografados anteriormente, como cookies e informações armazenadas com criptografia. Isso pode invalidar sessões e prejudicar o funcionamento do sistema.*

5. Isolamento de Diretórios

*O servidor deve apontar para a pasta public/, pois ela contém o ponto de entrada da aplicação, o arquivo index.php. Isso evita a exposição de arquivos internos, como .env, arquivos de configuração e código-fonte.*

6. Artisan CLI

*O comando php arquivo.php executa diretamente um script PHP. Já o php artisan utiliza a interface de linha de comando do Laravel, oferecendo comandos para criar arquivos, executar migrações, iniciar o servidor e diagnosticar a aplicação.*

7. O Arquivo .env.example

*O arquivo .env.example serve como modelo de configuração para os integrantes da equipe. Ele permite que cada desenvolvedor configure seu próprio ambiente sem precisar compartilhar senhas ou outras informações confidenciais.*

8. Motor de Templates Blade

*A diretiva {{ $variavel }} escapa automaticamente caracteres HTML, ajudando a prevenir ataques XSS. Já {!! $variavel !!} exibe o conteúdo sem escapar, podendo permitir a execução de código HTML ou JavaScript malicioso se os dados não forem confiáveis.*

9. Responsabilidade do Controller

*Um Controller deve ter métodos curtos e focados em uma única responsabilidade para facilitar a leitura, os testes e a manutenção. Consultas complexas e regras de negócio devem ser organizadas em classes apropriadas, como Models ou serviços. O limite de 20 linhas é uma regra de qualidade adotada no exercício, não uma exigência oficial do Laravel.*

10. A Ferramenta Tinker

*O comando php artisan tinker abre um terminal interativo que permite executar código PHP dentro do ambiente Laravel. Ele ajuda a testar modelos, consultar configurações, verificar relacionamentos e experimentar operações sem precisar criar uma rota ou uma página específica.*