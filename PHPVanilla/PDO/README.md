## LISTA DE EXERCÍCIOS DE FIXAÇÃO E PRÁTICA - CONEXÃO BANCO DE DADOS PDO

**Parte A: Exercícios Teóricos de Fixação**

1. Abstração de Dados: O que é o PDO no PHP e por que ele é preferível em relação a extensões especializadas procedurais como o antigo pgsql em projetos corporativos?

**Resposta**
O PDO é uma ferramenta do PHP que permite fazer a conexão e trabalhar com bancos de dados. Ele é muito usado porque facilita o trabalho com diferentes tipos de banco e também possui recursos de segurança. Já o pgsql é uma extensão específica para PostgreSQL .

2. Ciclo do DSN: Explique o que é a string DSN e detalhe a finalidade de cada um dos parâmetros configurados para o PostgreSQL (host, port, dbname).

**Resposta**
A DSN é uma parte da conexão que informa ao PHP onde está o banco de dados e qual banco ele deve acessar. O host indica o endereço do servidor, o port indica a porta usada pelo PostgreSQL e o dbname informa o nome do banco de dados .

3. Padrão de Portas: Qual é a porta padrão de escuta do SGBD PostgreSQL (5432) e como ela é referenciada dentro da string de conexão?

**Resposta**
A porta padrão utilizada pelo PostgreSQL é a 5432. Essa porta é usada para que os programas consigam se comunicar com o servidor do banco de dados. Na string de conexão do PDO, ela é informada usando port=5432. Caso o PostgreSQL esteja configurado para utilizar outra porta, esse valor também precisaria ser alterado na conexão.

4. Flags de Integridade: O que acontece quando definimos o atributo PDO::ATTR_ERRMODE com o valor PDO::ERRMODE_EXCEPTION? Qual seria o comportamento padrão caso essa flag não fosse definida?

**Resposta**
Quando usamos PDO::ATTR_ERRMODE com PDO::ERRMODE_EXCEPTION, o PDO passa a gerar uma exceção sempre que acontece algum erro relacionado ao banco de dados. Isso é útil porque podemos usar try e catch para identificar e tratar esses erros de uma forma mais organizada. Se essa configuração não for definida, o PDO utiliza o modo PDO::ERRMODE_SILENT, no qual os erros não são lançados automaticamente como exceções e precisam ser verificados pelo próprio código .

5. Fetch Mode: Qual é a vantagem de utilizar PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC para o consumo de memória RAM do servidor?

**Resposta**
O PDO::FETCH_ASSOC faz com que os dados retornados de uma consulta sejam organizados em arrays associativos, usando o nome das colunas como referência. Isso é vantajoso porque evita que os mesmos dados sejam retornados também por índices numéricos. Dessa forma, principalmente quando existem muitos registros, pode haver uma economia no uso da memória RAM do servidor, além de deixar o resultado mais fácil de entender e utilizar no código .

6. Padrão Singleton: Por que abrir uma nova conexão com new PDO() a cada consulta executada no PostgreSQL pode esgotar o limite de max_connections do servidor?

**Resposta**
Quando o sistema cria uma nova conexão usando new PDO() para cada consulta, várias conexões diferentes podem ser abertas ao mesmo tempo. O PostgreSQL possui um limite máximo de conexões, definido pela configuração max_connections. Se muitas conexões forem abertas, esse limite pode ser atingido e o banco pode começar a recusar novas conexões. O padrão Singleton ajuda nesse caso porque permite reutilizar uma única instância da conexão em vez de criar uma nova toda vez que ela for necessária .

7. Encapsulamento do Singleton: Por que o construtor da classe ConexaoBanco precisa ser declarado como private e quais métodos mágicos devem ser bloqueados para garantir a unicidade da instância?

**Resposta**
O construtor da classe ConexaoBanco precisa ser declarado como private para impedir que outras partes do sistema criem objetos da classe diretamente usando new. Dessa forma, a própria classe consegue controlar a criação da conexão. Além disso, os métodos mágicos __clone() e __wakeup() devem ser bloqueados. O __clone() evita que a instância seja duplicada e o __wakeup() impede que ela seja recriada por meio de desserialização. Assim, é possível manter a ideia de uma única instância da conexão .

8. Segurança de Credenciais: Por que nunca devemos deixar o usuário e senha do banco de dados salvos de forma estática (hardcoded) dentro dos scripts PHP do projeto?

**Resposta**
Não devemos colocar o usuário e a senha do banco diretamente dentro dos arquivos PHP porque essas informações podem acabar sendo expostas. Por exemplo, se o projeto for enviado para um repositório no GitHub ou compartilhado com outras pessoas, as credenciais podem ficar visíveis. Se alguém conseguir essas informações, poderá tentar acessar o banco de dados sem autorização. Por isso, o mais recomendado é utilizar variáveis de ambiente ou algum sistema seguro para armazenar as credenciais .

9. Tratamento de Exceções & LGPD: Por que a exibição direta de $e->getMessage() de uma PDOException na tela do navegador é considerada uma falha grave de segurança (Information Disclosure)?

**Resposta**
Mostrar diretamente o conteúdo de $e->getMessage() no navegador pode ser perigoso porque a mensagem de erro pode apresentar informações internas do sistema. Ela pode revelar nomes de tabelas, comandos SQL, caminhos de arquivos, endereço do banco ou outras informações que deveriam ficar protegidas. Essas informações podem ajudar uma pessoa mal-intencionada a encontrar vulnerabilidades no sistema. Por isso, o ideal é registrar os detalhes do erro nos logs do servidor e mostrar para o usuário apenas uma mensagem genérica, evitando também a exposição desnecessária de informações que podem envolver dados protegidos pela LGPD .