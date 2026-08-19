# Curso BackEnd - 225h - Técnico em Desenvolvimento de Sistemas - SENAI

Profº Diogo TB

Escola SENAI Americana

2º Semestre 2026

## Objetivos do Curso 

- Desenvolver Alicações web Server Side, ultilizando a linguagem PHP;
- Aplicar Sistaxe Nativa PHP (Vanilla);
- Manipulação HTTP;
- Persistência de Dados;
- Seguraça contra SQL Injection/CSRF;
- Refatoração em POO (Programação Orienteda de Objetos);
- Arquitetura MVC (Model, View, Controller);
- Ultilização do Framework Laravel;


# obs:
- Framework - um conjunto de bibliotecas que ofeecem uma solução completa para o desenvolvimento de alguma coisa

## Cronograma do Semestre

Carga Horária: 105h 1º Semestre e 120h 2º Semestre

Duração: 20 Semanas 1º Semestre e 20 Semanas 2º Semestre

### Semana 1: Introdução ao BackEnd e Configuração do Ambiente PHP

### O que é BackEnd? 

O back-end é a aprte de uma aplicação que o usuário não vê, mas que faz tudo funcionar por trás das telas.

O Back-End é a parte de um sistema que funciona nos servidores, sendo responsável por executar a lógica da aplicação, processar informações e armazenar dados. 

Além disso, o BackEnd é responsável por atender ás solicitações do Frontend.

Sobre o mercado atual o cenário é bom, mas mais exigente do que era. Quem conhece só o básico enfrenta mais concorrência. Quem alia backend sólido com IA aplicada, cloud e inglês está num patamar completamente diferente — vagas internacionais remotas são uma realidade pra esse perfil.

O Backend é formado pelo servidor, banco de dados, lógica de programação com APIs e linguagens de programação/frameworks. Esses componentes trabalham juntos para processar dados, armazenar informações e garantir o funcionamento da aplicação.

 Ferramentas usadas para escrever o código do servidor, como Python, Node.js (JavaScript), Java e PHP.APIs: Os "caminhos" que permitem que o que você vê no celular converse com o servidor.

# Para que Serve

-Processar lógica de negócio: regras, cálculos, validações (ex: calcular frete, aplicar desconto, validar login)

-Gerenciar banco de dados: salvar, buscar, atualizar e deletar informações

-Autenticação e autorização: controlar quem pode acessar o quê (login, senhas, permissões)

-Fornecer APIs: criar "pontes" (endpoints) para o frontend ou outros sistemas consumirem dados

-Integração com serviços externos: pagamentos, e-mails, notificações, APIs de terceiros

-Segurança: proteger dados sensíveis, evitar ataques (SQL injection, XSS, etc.)

-Escalabilidade e performance: garantir que o sistema aguente muitos usuários ao mesmo tempo.

#### O Ciclo de Vida da Requisição HTTP

##### O que é HTTP?

*HTTP* , HYypertext Trasnfer Protocol, é um protocolo de comunicação utilizada  para trasferência de informações na www (Worl wide web) e em outros sistemas de redes.

O HTTP é a abase para que o cliente e um servidor web troquem informações Ele permiti a requisição e a resposta de recursos como imagens, arquivos e textos.

```mermaid

graph TD
    
    A[Navegador]
    B[HTTP]
    C[Servidor]

    A --> |request| B
    B --> |request| C
    C --> |response| B
    B --> |response| A

```

#### Como funciona na Prática o Backend

- **Ação do Usuário**: Envia uma Solicitação pela UI (Interface do Usuário). Exemplo de UI: Tela de Celular, Navegador da Internet, Alexa, IOT ...
- **Enviar uma Requisição**: A UI transforma ação do Usuário em uma Requisição HTTP.
- **O Processamentoo BackEnd**: O Código BackEnd recebe o pedido, valida os dados e decide o que fazer. Ex: consultar uma informação no BD(Base de Dados)
- **Resposta**: O servidor delvode o resultado para a UI. Ex: Um login Autorizado, Confirmaçaõ de uma Compra...

### Tipos de Requisição HTTP

Os tipos de requisição HTTP indicam a ação que o usuário deseja executar no servidor. As principais ações são:

- **GET**: Pede dados de um lugar especifico do servidor. "Não faz alterações no servidor"
- **DELETE**: Apaga um Dado no servidor
- **POST**: Envia dados novos para *criar* algo ou processar informações no servidor.
- **PUT/PATCH**: Modificar um dado já existente.
>PUT substitui o objeto inteiro. Você deve enviar todos os dados do registro. O PATCH atualiza apenas o que mudou. Você envia só os campos que quer trocar, sem mexer no resto.

---
### Iniciando o PHP 

*PHP* (Hypertext PreProcessor) é uma linguagem de programação interpretada e open source, focada no desenvolvimento de sistemas para WEB, pode ser usada junto com HTML para criação de páginas WEB dinâmica.

O PHP de fato é uma das linguagens de programação mais populares da atualidade. Ela permite que você crie aplicações web robustas, 
de uma maneira muito simplificada e direta. A linguagem tem diversos recursos que facilitam e aceleram o processo de desenvolvimento de sites e sistemas para a WEB e além do mais, ela ainda tem um ótimo ecossistema, uma excelente comunidade e um grande mercado de trabalho.
---
#### Instalando o PHP

- Fazer o Dowloand do PHP (php.net)
- ZIP - NTS(Non Thread Safe) 8.5
- Descompactar o Arquivo do PHP na pasta C:\asrc\php (Para Descompactar usar o 7Zip = Melhor) => nunca salvar arquivo ou programas na raiz do sistema(C:)
- Adcionar a Pasta do php(C:\src\php) as Variáveis de Ambiente do Sistema (PATH)
- Verificar a instalacão rodando o comando *php --version*

##### Criando Minha Primeira Aplicação em PHP

1. Antes de começar de Codar:
 
- Preparar meu VSCODE
    - Criar um Profile próprio para PHP
    - Instalar Extensões Necessária para Transformar o VSCode em uma IDE:
        - PHP Intelephese => permite a utilização de Snippets(atalhos de Código)
        - PHP Debug => Ajuda a encontar erros de códigos
        - PHP Cs Fixer => Formatação de códigos (Identação)
        - PHP Server => Ajuda na criação de um servidor local PHP
    - Desabilitamos o PHP Nativo do VSCode (@builtin PPHP)

2. Hello World (muito importante)

### Semana 2 - Variáveis, Constantes e Operadores em PHP

##### Estudo de Variáveis e Constantes em PHP

Declarar variáveis é alocar um espaço na memória que permite a inclusão e manipulação de dados

**Variáveis**

- devem ser declaradas usando "$" antes do nome da variável
- são não tipadas ( não precisa declara o tipo dela na criação)
- podem ser String, Numéricas ( interger e float ), Booleanas e Nulas. Não permite declaração de Undefined
- usar o declare(strict_types=1); na primeria linha do arquivos; => Blinda o sistema contra conflitos de tipos de variáveis 

**Constantes** 

- não podem ser mudadas ou redeclaradas após a criação 
- pode ser criada usando o "const" ou "define"
- não permite interpolação 

##### Estudo de Operadores

**Aritméticos**: são usados para realizar cálculos.
  |Operador | Nome | Exemplo | Resultado |
  |-|-|-|-| 
  | + | Adição | 10 + 5 | 15 |
  | - | Subtração | 10 - 5 | 5 |
  | * | Multiplicação | 10 * 5 | 50 |
  | / | Divisão | 10 / 5 | 2 |
  | % | Modulo(Resto) | 10 % 3 | 1 (10 dividido 3 da 3, sobra 1) |
  | ** | Expoente | 2 ** 3 | 8 (2 elevado a 3) |

obs: o Operador % é o melhor amigo de um programador, prmite ordenar listas e organizar fila e pilhas

**Relacionais**: Permite o Relacionamento entre dois ou mais valores, o resultado de uma operação é sempre uma booleana (verdadeiro ou falso).

| Operador | Significado | Exemplo | Resultado | 
| - | - | - | - | 
| > | Maior que | 18 > 18 | false |
| >= | Maior ou igual a | 18 >= 18 | true |
| < | Menor que | 10 < 20 | true |
| <= | Menor ou igual a | 10 <=5 | false
| == | Comparação de Valor | "10"==10 | true | 
| === | Comparação Estrita | "10"===10 | false |
| != | Diferente | "10"!=10 | false |
| !== | Estritamente Diferente | "10"!==10 | true |




**Lógicos**: Permite a Combinação entre sentenças. 

- Operador AND (E) => && : para o resultado ser verdadeiro, todas as combinações precisam ser verdadeiras
  - true && true => true
  - true && false => false

- Operador OR (OU) => || : para o resultado ser verdadeiro, Basta apenas uma condição ser verdadeira
    - false || true => true
    - false || false => false

- Operador NOT (Não) => ! : Inverte a lógica da Operação, 
    - !true => false
    - !false => true

---

### Semana 3 - Estrutura de Controle de Dados (Condicionais e Repetição)

- **Conteúdo**: Estrutura `if`, `else`,`eslseif`, operadores ternários, `match` => 
substituto do `swith/case`, loops `for`, `while` ,  `do-while` e `foreach`

#### Estruturas de Controle da Dados Ajudam no Processo de Automatização em Programas e Sistemas

##### Condicionais (IR, ELSE, ELSEIF)

**Formas de Uso**

- uso do `if` apenas:
Exemplo: aplicar desconto de 10% em compras acima de 100 Reais;

```mermaid

graph LR

   A[Comando] --> B{Condição} --> C[Ação]

```

```php

if($valorCompra > 100){
    $valorFinal = $valorCompra * 0.9;
}

```

- Uso do `if` e do `else`
Exemplo: Aplicar um desconto de 10% para compras acima de 100reais e 5% para as demais compras

```mermaid

graph LR

A[Comando] --> B[Condição]
B --> |true| C[Ação 1]
    B --> |false| D[Ação 2]

```

```php

if($valorCompra > 100){
    $valorFinal = $valorCompra * 0.9;
} else {
    $valorFinal = $valorCompra * 0.95;
}

```

- Uso `elseif` (If Encadeado) => estrutura usada para manipulação de dados em duas ou mais condicionais
Exemplo: Compras acima de 200 reais tem 15% de desconto, compras acima de 100 reais de 10% de desconto e demais compras tem 5% de desconto 

```mermaid

graph LR 
  
    A[Comando] --> B{Condição 1}
    B --> |true| C[Ação 1]
    B --> |false| D{Condição 2}
    D --> |true| E[Ação 2]
    D--> |false| F[Ação 3]

```

```php


if($valorCompra > 200) {
    $valorFinal = $valorCompra * 0.85;
} elseif ($valorCompra > 100) {
    $valorFinal = $valorCompra * 0.9;
} else {
    $valorFinal = $valorCompra * 0.95;
}

```

*obs*: sempre usar `elseif` para situações que precisam de mais de uma condição, ou seja, fazer encadeamento das condições

- Uso *ERRADO* do if


```php 

if($valorCompra > 200) {
    $valorFinal = $valorCompra * 0.85;
}
if($valorCompra > 100) {
    $valorFinal = $valorCompra * 0.9;
} else {
    $valorFinal = $valorCompra * 0.95;
}

```

##### Operadores Ternários

Um atalho para a estrutura condicional `if/else`, normalmente escrito em uma única linha de código.

` condição ? verdadeira : falsa `

Perfeito para decisões curtas de uma linha de comando 
Exemplo: Verificar se a pessoa é maior de idade (18);

```php

$idade = 20;
//O formato é (Condição) ? Verdadeiro : Falso;

$status - ($iade>=18) ? "Maior de idade" : "Menor de idade";
$status2 = ($idade>=60) ? "Idoso" : ($idade>=18) ? "Adulto" : "Criança" ;

echo $status //

```
##### Expressão Condicional `match` (PHP 8)

No mercado atual de PHP, não se uma mais uma `Switch/Case` para chegar valores fixos, usa-se o `match`. Ele compara um valor e retorna diretamente o resultado caso atenda a condição.

```mermaid

graph TD 
    A[Valor] --> B{Condicional}
    B --> C[Ação 1]
    B --> D[Ação 2]
    B --> E[Ação 3]
    B --> F[Ação 4]
    B --> G[Ação ...]
    B --> H[Ação default]

```


Exemplo: Selecionar o Dia da Semana a partir de um Nº 

```php

$diaSemanaNum = date("W"); // pega o Dia da Semana em formato mumério

$nomeDiaSemana = match($diaSemanaNum) {
    "0" => "Domingo",
    "1" => "Segunda",
    "2" => "Terça",
    "3" => "Quarta",
    "4" => "Quinta",
    "5" => "Sexta",
    "6" => "Sábado",
    "default" => "Dia Inválido"
};

echo "Hoje é : $nomeDiaSemana";

```
##### Laços de Repetição

Um laço de repetição faz com que um bloco de código rode várias vezes até que uma condição mande parar. 

- O Laço while (Enquanto)

Ele verifica se a condição é verdadeira ANTES de entrar no laço. Ideal quando você não sabe exatamente quantas vezes vai rodar o laço. 

```mermaid

graph LR

    A[Início: contador = 0] --> B{Verdade?}
    B -- Sim --> C[Repete]
    C --> D[executa código]
    D --> B
    B -- Não --> E[Fim do Laço]

```
Exemplo de Aplicação do White: jogo de adivinhação de um nº Secreto

```php

$numeroSecreto = rand(1,10);

$tentativas = 0;

$numeroEscolhido = 0;

while(numeroEscolhido != numeroSecreto){
    echo "Tente Novamente"
    //vou escolher outro Nº para adivinhar
    numeroEscolhido = rand(1,10);
    tentativas++;
}

echo "Acertou Miseravi!!! o nº secreto é $numeroEscolhido";

```

- O laço `do-while` (Faça - Enquanto)

A diferença é que ele executa o bloco pelo menos uma vez, mesmo que a condição seja false desde o início, pois ele só pergunta no final.

```mermaid

flowchart LR 

A([Início]) -> B[Ação]
    B --> C{Condição}
    C --true--> B
    C --false--> D([Fim])

```

Exemplo: Jogo de Adivinhação de um nº

```php

do{
    $numeroEscolhido = rand(1,10);

    if(numeroEscolhido == numeroSecreto){
        echo "Parabéns, Acertou!!!";
        break;
    }
    echo "Tente Novamente!!!";

} while(numeroEscolhido != numeroSecreto);

```

#### O Freio de Emergência: `break` e `continue`

As vezes precisamos interferir no laço enquanto ele está rodando

- `break` => **Para Tudo!** Quebra o laço interiro  e avai embora 
- `continue` => **Pula a rodada!** Ele ignora o código daquela rodada especifica e pula logo par a próxima repetição.

Exemplo de Aplicação do Código: Sistema de Controle do Elevador

```php 

for($andar = 1 ; $andar<=10; $andar++){
    if($andar ==4){
        echo "Andar $andar está em obras. Passando direto!";
        continue;
    }

    echo "Elevador parou no andar $andar"
}
```
---
##### Laço de Repetição 

Use o `for`quando você sabe quantas vezes precisa repetir uma ação ou quando precisa controle um contador. Ele possui três partes:

- inicialização,
- condição,
- incremento;

for(inicialização; condição; incremento){}

```mermaid

flowchart LR
    A[Início: i=0] --> B{i<10?}
    B --true--> C[Ação]
    C --> D[i++]
    D --> B
    B --false--> E[Fim]

```
Exemplo: Exibir todos os meses do Ano

```php
for($mes=1; $mes<=12; $mes++){
    echo "Mês $mes";
}
```
Nesse Exemplo, `$mes` começa em 1, o laço continua enquanto 
`$mes`for menor ou igual a 12 e, ao final de cada repetição, `$mes++`aumenta o contador em 1.

##### Laço de Repetição `foreach`´

Use o `foreach` quando precisar percorrer cada item de um **array*. Ele acessa os elementos diretamente, sem que você precise controlar o contador.

Exemplo: Imprimir todos os itens de um vetor 

```php

$frutas =[$frutas as $fruta]{
    echo "Fruta: $fruta";
}
```
Outro Exemplo: Acessar a chave e o valor de cada item:

```php 

$precos = [
    "Caderno" => 25.90,
    "Caneta" => 5.50,
    "Mochila" => 99.00
]; // vetor não ordenado chave => valor

foreach ($preco as $produto =>$preco){
    echo"$produto: R$number_format($preco,2)";
}
```
---
---

#### Desafio : Simulador de Cobrança (FINANSENAI)













