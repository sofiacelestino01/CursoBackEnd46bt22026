## Parte A: Exercícios Teóricos de Fixação

1. **Procedural vs. OO: Quais são os três principais riscos técnicos de manter regras financeiras críticas implementadas puramente através de arrays associativos e scripts procedurais?**

   **Resposta:** Os três principais riscos são a falta de encapsulamento, a duplicação de regras e a dificuldade de manutenção. Sem a proteção dos atributos, qualquer parte do código pode alterar o saldo indevidamente. Além disso, regras duplicadas podem gerar inconsistências e dificultar a identificação de erros.

2. **Ciclo de Vida do Objeto: O que ocorre na memória Heap do servidor quando a instrução `new ContaCorrente(...)` é executada? Qual é o papel do método `__construct()` nesse processo?**

   **Resposta:** Quando executamos `new ContaCorrente(...)`, o PHP cria um objeto na memória e inicializa suas propriedades. O método `__construct()` é chamado automaticamente para receber os dados iniciais e preparar o objeto para utilização.

3. **A Pseudo-Variável `$this`: Explique por que o comando `$this->saldo` é obrigatório para acessar um atributo dentro da classe, diferenciando-o de uma variável local `$saldo`.**

   **Resposta:** O `$this` representa o objeto atual. Assim, `$this->saldo` acessa o atributo `saldo` pertencente ao objeto. Já `$saldo` é uma variável local do método, que não representa necessariamente o atributo da classe.

4. **Encapsulamento e Invariantes: Por que um desenvolvedor sênior de back-end nunca deve criar um método `public function setSaldo(float $novoSaldo)` para uma conta bancária?**

   **Resposta:** Porque esse método permitiria alterar o saldo diretamente, sem garantir que a operação seja válida ou registrada no histórico. O ideal é modificar o saldo por métodos controlados, como `depositar()` e `sacar()`, que aplicam as regras de negócio.

5. **Modificadores de Acesso: Qual é a diferença prática entre os modificadores `private` e `protected` quando subclasses entram em cena através do `extends`?**

   **Resposta:** O modificador `private` permite o acesso ao atributo somente dentro da própria classe. Já o `protected` permite o acesso dentro da classe e também nas subclasses que herdam dela por meio de `extends`.

6. **Constructor Property Promotion: Como o recurso de promoção de propriedades introduzido no PHP 8 reduz o *boilerplate* e melhora a legibilidade do código?**

   **Resposta:** A promoção de propriedades permite declarar os atributos diretamente nos parâmetros do construtor, utilizando modificadores como `private` e `protected`. Isso elimina a necessidade de declarar os atributos separadamente e atribuir cada parâmetro manualmente, deixando o código mais curto e organizado.

7. **Propriedades `readonly`: Explique o mecanismo de segurança proporcionado pela palavra-chave `readonly` em atributos de classes de valor como `Titular` ou `CPF`.**

   **Resposta:** A palavra-chave `readonly` impede que uma propriedade seja reatribuída depois de inicializada. Isso ajuda a preservar informações como CPF e identificadores durante a execução do programa. Entretanto, a palavra-chave não substitui a validação dos dados recebidos.

8. **Classes Abstratas: Por que faz todo sentido no modelo bancário que a classe `ContaBancaria` seja declarada como `abstract` enquanto `ContaCorrente` e `ContaPoupanca` são classes concretas?**

   **Resposta:** A classe `ContaBancaria` representa as características comuns a diferentes tipos de contas, mas não deve ser instanciada diretamente. Ao declará-la como abstrata, obrigamos as subclasses concretas, como `ContaCorrente` e `ContaPoupanca`, a implementar os comportamentos específicos exigidos pelo modelo.

9. **Polimorfismo: Como o método `transferir(float $valor, ContaBancaria $destino)` consegue operar transferências entre quaisquer tipos de contas filhas sem precisar saber qual é a classe exata da conta de destino?**

   **Resposta:** Isso acontece porque todas as subclasses herdam de `ContaBancaria`. O parâmetro aceita qualquer objeto que seja uma conta bancária ou uma instância de suas subclasses. Dessa forma, o método utiliza os comportamentos definidos pela classe-base sem precisar verificar a classe concreta do destino.

10. **Exceções de Domínio: Por que é uma péssima prática retornar `false` ou `null` quando uma operação de saque é rejeitada por falta de saldo?**

    **Resposta:** Retornar `false` ou `null` pode dificultar a identificação do motivo da falha e permitir que o código ignore o problema. Utilizar uma exceção personalizada, como `SaldoInsuficienteException`, comunica claramente o motivo da rejeição e permite tratar o erro de forma específica.