# Parte A: Exercícios Teóricos

 1. Conceito de função: Explique com suas palavras o que é uma função e cite duas vantagens de dividir um programa em funções.

- **Uma função é uma parte do código que serve para fazer uma tarefa específica. Usar funções ajuda a deixar o programa mais organizado e facilita a reutilização do código, porque não precisamos escrever a mesma coisa várias vezes.**

2. Princípio DRY: Por que repetir o mesmo bloco de código em várias partes do sistema pode causar problemas de manutenção? Como uma função ajuda a evitar essa repetição?

- **O princípio **DRY** significa evitar repetir o mesmo código várias vezes. Quando isso acontece, se precisar mudar alguma coisa, vai ter que alterar em vários lugares, o que pode causar erros. A função ajuda porque você escreve o código uma vez e pode usá-lo várias vezes só chamando a função. Assim, fica mais fácil de organizar e atualizar o programa.**

3. Parâmetros e retorno: Explique a diferença entre um parâmetro e um valor retornado por uma função. Use a função abaixo como exemplo:

```php
function calcularTotal(float $preco, int $quantidade): float {
    return $preco * $quantidade;
}
```

- **Parâmetro é o valor que a função recebe para fazer o cálculo. Nesse exemplo, $preco e $quantidade são os parâmetros. Já o return é o resultado que a função devolve depois de fazer o cálculo.**

`Por exemplo, se o preço for 10 e a quantidade for 3, a função faz 10 × 3 e retorna 30.`

4. Tipagem: Identifique o tipo de cada elemento na declaração `function cadastrar(string $nome, int $idade): bool.`

- **Na declaração function cadastrar `(string $nome, int $idade): bool`, o `string` indica que o parâmetro `$nome` deve receber um texto, enquanto o `int` indica que`$idade` deve receber um número inteiro. O `bool` indica que a função vai retornar um valor booleano, que pode ser true ou false. Já cadastrar é o nome da função.**

5. `void` e `return`: Qual é a diferença entre uma função que retorna string e uma função que retorna void? Dê um exemplo de uso para cada uma.

- **Uma função que retorna `string` produz e devolve um texto para quem chamou a função. Por exemplo, uma função pode receber um nome e retornar uma mensagem. Já uma função que retorna `void` não devolve nenhum valor, ela apenas realiza uma ação. Por exemplo, pode mostrar uma mensagem na tela**

6. Escopo: Por que a função abaixo não consegue acessar $cliente diretamente? Explique duas formas de corrigir o código e indique qual é a mais recomendada.

```php
$cliente = "Mariana";

function exibirCliente(): string {
    return $cliente;
}
```

- **A função não consegue acessar `$cliente` porque essa variável foi criada fora dela. Uma função só consegue acessar as variáveis que estão dentro dela. Uma forma de corrigir é passar `$cliente` como parâmetro da função. Outra forma é usar `global` para permitir que a função acesse a variável de fora. A forma mais recomendada é passar a variável como parâmetro, pois deixa o código mais organizado e fácil de reutilizar.**

7. Referência: O que muda quando um parâmetro é declarado como `float &$valor`? Explique a diferença entre alterar uma cópia e alterar a variável original.

- **Quando um parâmetro é declarado como `float & $valor`, o `&` significa que a função vai trabalhar diretamente com a variável original, e não com uma cópia dela. Assim, se a função alterar `$valor`, a variável original também será alterada. Sem o `&`, a função recebe uma cópia do valor, então qualquer mudança feita dentro dela não afeta a variável original.**

8. Funções nativas: Escolha cinco funções da tabela deste material e descreva: categoria, finalidade, parâmetros principais e valor retornado.

`strlen`: **categoria strings. Conta os caracteres de um texto. Recebe uma string e retorna um número inteiro.**

`strtoupper`: **categoria strings. Deixa o texto em letras maiúsculas. Recebe uma string e retorna o texto em maiúsculo.**

`count`: **categoria arrays. Conta os elementos de um array. Recebe um array e retorna um número inteiro.**

`is_numeric`: **categoria validação. Verifica se um valor é numérico. Recebe um valor e retorna `true` ou `false`.**

`date`: **categoria data e hora. Mostra uma data ou horário em um formato escolhido. Recebe o formato e retorna uma string.**

9. Previsão de saída: Qual será o resultado exibido pelo código abaixo? Explique o motivo.

```php
function aplicarDesconto(float $preco): float {
    return $preco * 0.90;
}

$valor = 100.00;
echo aplicarDesconto($valor);
echo $valor;
```
- **O resultado será: `90` Isso acontece porque a função pega o valor de **100** e aplica o desconto de 10%, então retorna **90**. Porém, a variável `$valor` continua sendo **100**, porque a função recebeu uma cópia do valor e não alterou a variável original**

10. Documentação: Pesquise na documentação oficial do PHP a função strlen() e anote sua sintaxe, o parâmetro recebido e o tipo de retorno.

- Segundo a documentação oficial do PHP, a função `strlen()` serve para **retornar o tamanho de uma string**. ([PHP][1])

* **Sintaxe:** `strlen(string $string): int`
* **Parâmetro:** `$string` — a string que terá o tamanho medido.
* **Retorno:** `int` — retorna o tamanho da string em **bytes**. ([PHP][1])

Exemplo: `strlen("Olá")` retorna o tamanho da string em bytes.





