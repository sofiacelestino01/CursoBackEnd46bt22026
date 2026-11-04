<?php
declare(strict_types=1);

class ValorInvalidoException extends InvalidArgumentException {}
class SaldoInsuficienteException extends RuntimeException {}

class Titular
{
    public function __construct(
        public readonly string $cpf,
        public readonly string $nome
    ) {}
}

abstract class ContaBancaria
{
    protected float $saldo = 0.0;

    public function __construct(
        protected readonly string $numero,
        protected readonly Titular $titular
    ) {}

    public function getSaldo(): float
    {
        return $this->saldo;
    }

    public function getTitular(): Titular
    {
        return $this->titular;
    }

    public function depositar(float $valor): void
    {
        if ($valor <= 0) {
            throw new ValorInvalidoException('Valor inválido.');
        }
        $this->saldo += $valor;
    }

    abstract public function sacar(float $valor): void;

    abstract public function transferir(
        float $valor,
        ContaBancaria $destino
    ): void;
}

class ContaSalario extends ContaBancaria
{
    private int $saquesMes = 0;

    public function __construct(
        string $numero,
        Titular $titular,
        public readonly string $cnpjEmpregador
    ) {
        parent::__construct($numero, $titular);
    }

    public function depositarEmpregador(
        float $valor,
        string $cnpjAutenticado
    ): void {
        if ($cnpjAutenticado !== $this->cnpjEmpregador) {
            throw new DomainException('Empregador não autorizado.');
        }
        parent::depositar($valor);
    }

    public function sacar(float $valor): void
    {
        if ($valor <= 0) {
            throw new ValorInvalidoException('Valor inválido.');
        }
        $taxa = $this->saquesMes >= 2 ? 4.00 : 0.00;
        if ($this->saldo < $valor + $taxa) {
            throw new SaldoInsuficienteException('Saldo insuficiente.');
        }
        $this->saldo -= $valor + $taxa;
        $this->saquesMes++;
    }

    public function transferir(
        float $valor,
        ContaBancaria $destino
    ): void {
        if ($destino->getTitular()->cpf !== $this->titular->cpf) {
            throw new DomainException('Transferência para terceiro proibida.');
        }
        $this->sacar($valor);
        $destino->depositar($valor);
    }
}

$titular = new Titular('12345678900', 'Maria');
$conta = new ContaSalario('001', $titular, '12345678000199');

$conta->depositarEmpregador(1000, '12345678000199');
$conta->sacar(100);
echo 'Saldo: R$ ' . number_format($conta->getSaldo(), 2, ',', '.') . PHP_EOL;
