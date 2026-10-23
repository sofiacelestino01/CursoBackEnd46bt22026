## LISTA DE EXERCÍCIOS DE FIXAÇÃO E PRÁTICA

**Parte A: Exercícios Teóricos de Fixação**

1. Procedural vs. OO: Quais são os três principais riscos técnicos de manter regras financeiras críticas implementadas puramente através de arrays associativos e scripts procedurais

**Resposta**
Os três principais riscos são a duplicação de código, a dificuldade de manutenção e a falta de proteção dos dados, podendo causar erros nas operações financeiras.

2. Ciclo de Vida do Objeto: O que ocorre na memória Heap do servidor quando a instrução new ContaCorrente(...) é executada? Qual é o papel do método __construct() nesse processo?

**Resposta**
Quando executamos new ContaCorrente(...), um objeto é criado na memória Heap do servidor. O método __construct() é executado automaticamente para inicializar o objeto com os dados informados.

3. A Pseudo-Variável $this: Explique por que o comando $this->saldo é obrigatório para acessar um atributo dentro da classe, diferenciando-o de uma variável local $saldo.

**Resposta**
O $this->saldo serve para acessar o saldo que pertence ao objeto atual. Já $saldo é uma variável local, que pode ser usada dentro de um método. O $this ajuda a diferenciar o atributo do objeto de uma variável local.

4. Encapsulamento e Invariantes: Por que um desenvolvedor sênior de back-end nunca deve criar um método public function setSaldo(float $novoSaldo) para uma conta bancária?

**Resposta**
Devemos evitar um método setSaldo() porque ele permitiria alterar o saldo diretamente, sem verificar as regras da conta bancária. Isso poderia deixar o saldo com um valor inválido e comprometer a segurança do sistema. O correto é usar métodos como depositar() e sacar(), que verificam as regras antes de modificar o saldo.

5. Modificadores de Acesso: Qual é a diferença prática entre os modificadores private e protected quando subclasses entram em cena através do extends?

**Resposta**
O private permite acessar um atributo ou método somente dentro da própria classe. Já o protected permite o acesso dentro da própria classe e também nas classes filhas que herdam dela usando extends.

6. Constructor Property Promotion:  Como o recurso de promoção de propriedades introduzido no PHP 8 reduz o boilerplate e melhora a legibilidade do código?

**Resposta**
Permite declarar os atributos diretamente nos parâmetros do construtor. Assim, precisamos escrever menos código, sem ter que declarar os atributos separadamente e depois atribuir os valores a eles. Isso deixa o código mais simples e fácil de ler.

7. Propriedades readonly: Explique o mecanismo de segurança proporcionado pela palavra-chave readonly em atributos de classes de valor como Titular ou CPF.

**Resposta**
 A palavra-chave readonly impede que uma propriedade seja alterada depois de receber seu valor inicial. Por exemplo, na classe Titular, ela ajuda a evitar mudanças acidentais no nome e no CPF depois que o objeto é criado.

8. Classes Abstratas: Por que faz todo sentido no modelo bancário que a classe ContaBancaria seja declarada como abstract enquanto ContaCorrente e ContaPoupanca são classes concretas?

**Resposta**
Porque ContaBancaria serve como um modelo geral para os outros tipos de conta. Já ContaCorrente e ContaPoupanca possuem características próprias e podem ser usadas para criar objetos. Por isso, a classe principal pode ser abstrata, enquanto as outras são concretas.

9. Polimorfismo: Como o método transferir(float $valor, ContaBancaria $destino) consegue operar transferências entre quaisquer tipos de contas filhas sem precisar saber qual é a classe exata da conta de destino?

**Resposta**
 Isso é possível porque ContaCorrente e ContaPoupanca herdam da classe ContaBancaria. Assim, o método pode receber qualquer uma dessas contas sem precisar verificar qual é o tipo exato dela, desde que as classes sigam as regras necessárias para a transferência.

10. Exceções de Domínio: Por que é uma péssima prática retornar false ou null quando uma operação de saque é rejeitada por falta de saldo?

**Resposta**
Porque false ou null não explicam claramente por que o saque não foi realizado. Usando uma exceção como SaldoInsuficienteException, o sistema consegue informar o motivo do erro e tratá-lo corretamente com try e catch.