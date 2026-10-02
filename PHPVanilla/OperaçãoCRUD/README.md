## Parte A: Exercícios Teóricos de Fixação


1. **Definição de CRUD: O que significa o acrônimo CRUD e qual é a correspondência direta de cada uma de suas letras com as instruções SQL no PostgreSQL?**

*Resposta* : CRUD significa Create, Read, Update e Delete. No SQL, eles correspondem respectivamente a INSERT para criar dados, SELECT para consultar, UPDATE para alterar e DELETE para excluir.

2. **Anatomia do SQL Injection: Explique com suas próprias palavras como um atacante consegue alterar a lógica de uma consulta quando o código utiliza concatenação de strings com $_GET ou $_POST.**

*Resposta* : O SQL Injection acontece quando o programa coloca diretamente um valor recebido pelo usuário dentro de uma consulta SQL usando concatenação. Dessa forma, o atacante pode enviar um texto que altera a estrutura da consulta e faz o banco interpretar parte do texto como um comando SQL.

3. **Mecanismo das Prepared Statements: Por que o envio de uma consulta em duas etapas (prepare e depois execute) impede que um texto digitado pelo usuário seja executado como instrução SQL pelo banco?**

*Resposta* : As Prepared Statements separam a estrutura da consulta dos dados enviados pelo usuário. Primeiro o banco recebe a consulta com prepare() e depois recebe os valores com execute() ou bindValue(). Assim, o texto informado pelo usuário é tratado como dado e não como parte do comando SQL.

4. **Marcadores Nomeados: Qual é a vantagem de utilizar marcadores nomeados como :sku e :preco em vez de pontos de interrogação posicionais (?) em instruções SQL complexas?**

*Resposta* : Os marcadores nomeados deixam o código mais fácil de entender e organizar. Com nomes como :sku, :preco e :id, fica mais fácil identificar qual valor pertence a cada campo, principalmente em consultas maiores.

5. **Diferença entre Bindings: Explique a diferença de comportamento entre os métodos $stmt->bindValue() e $stmt->bindParam().**

*Resposta* : O bindValue() associa diretamente o valor informado ao parâmetro. Já o bindParam() trabalha com uma variável por referência e utiliza o valor dessa variável no momento da execução da consulta. Por isso, bindValue() é mais simples quando não precisamos alterar o valor da variável antes da execução.

6. **Tipagem no PDO: Qual é o risco de omitir o tipo de dado (ex: PDO::PARAM_INT) ao vincular uma variável que deveria ser estritamente numérica em uma cláusula LIMIT?**

*Resposta* : Se o tipo não for informado corretamente, o valor pode ser tratado de maneira diferente da esperada. Utilizar PDO::PARAM_INT deixa claro que o parâmetro deve ser tratado como inteiro, sendo especialmente importante em valores como LIMIT e OFFSET.

7. **Padrão DAO: Qual é o benefício do padrão Data Access Object (DAO) em termos de manutenibilidade de software e do princípio de responsabilidade única (SOLID)?**

*Resposta* : O DAO separa as operações de acesso ao banco de dados do restante do sistema. Assim, uma classe como PecaDAO fica responsável pelas consultas relacionadas às peças. Isso facilita a manutenção e segue o princípio da responsabilidade única, pois cada classe possui uma função específica.

8. **Operações de Update: Por que a ausência de uma cláusula WHERE em um comando UPDATE é considerada um incidente gravíssimo em ambientes de produção?**

*Resposta* : Sem a cláusula WHERE, o UPDATE pode alterar todos os registros da tabela. Isso pode causar uma alteração em grande quantidade de dados de forma acidental. Por isso, é importante utilizar uma condição, normalmente com o ID do registro que deve ser alterado.

9. **Impacto da LGPD: De acordo com a Lei Geral de Proteção de Dados (LGPD), quais são as penalidades e impactos que uma organização pode sofrer caso ocorra vazamento de dados de clientes por falha de SQL Injection?**

*Resposta* : Um vazamento de dados pessoais pode gerar consequências para a organização, como advertências, multas, obrigação de comunicar o incidente quando aplicável e necessidade de corrigir as falhas de segurança. A LGPD também prevê multa de até 2% do faturamento da empresa no Brasil, limitada a R$ 50 milhões por infração, além de possíveis impactos financeiros e de reputação.
