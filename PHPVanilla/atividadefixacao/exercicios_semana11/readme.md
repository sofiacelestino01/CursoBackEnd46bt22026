### Parte A: Questões Teóricas de Fixação

**1. Procedural vs. OO:**  
Os três principais riscos são a dificuldade de manutenção, a duplicação de código e a falta de segurança na manipulação dos dados financeiros, permitindo alterações indevidas nos saldos.

**2. Ciclo de Vida do Objeto:**  
Ao executar `new ContaCorrente(...)`, um novo objeto é criado na memória Heap do servidor. O método `__construct()` é executado automaticamente para inicializar o objeto com os valores recebidos.

**3. A Pseudo-Variável `$this`:**  
O `$this->saldo` acessa o atributo saldo pertencente ao objeto atual. Já `$saldo` representa uma variável local, que existe apenas no escopo em que foi declarada.

**4. Encapsulamento e Invariantes:**  
Porque permitiria alterar o saldo diretamente, sem validar as regras bancárias. O saldo deve ser modificado por operações controladas, como depósitos e saques, garantindo a integridade financeira.

**5. Modificadores de Acesso:**  
O `private` permite acesso somente dentro da própria classe. O `protected` permite acesso dentro da classe e de suas subclasses, por meio de `extends`.

**6. Constructor Property Promotion:**  
Esse recurso do PHP 8 permite declarar e inicializar propriedades diretamente nos parâmetros do construtor, reduzindo a repetição de código e melhorando a legibilidade.

**7. Propriedades `readonly`:**  
A palavra-chave `readonly` impede que uma propriedade seja modificada após sua inicialização, protegendo dados que devem permanecer constantes, como o CPF de um titular.

**8. Classes Abstratas:**  
A classe `ContaBancaria` é abstrata porque representa um modelo geral de conta e não deve ser instanciada diretamente. `ContaCorrente` e `ContaPoupanca` são concretas, pois representam tipos específicos de contas que podem ser instanciados.

**9. Polimorfismo:**  
O método recebe qualquer objeto que herde de `ContaBancaria`. Assim, pode realizar transferências entre diferentes tipos de contas sem precisar verificar a classe exata do destino.

**10. Exceções de Domínio:**  
Retornar `false` ou `null` pode dificultar a identificação do motivo da falha. Uma exceção de domínio comunica claramente que o saque foi rejeitado por falta de saldo e permite tratar o erro adequadamente.

