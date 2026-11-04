<?php
declare(strict_types=1);

class ValorInvalidoException extends InvalidArgumentException {}
class SaldoInsuficienteException extends RuntimeException {}

class Titular
{
    public function __construct(
        public readonly string $nome,
        public readonly string $cpf
    ) {}
}

abstract class ContaBancaria
{
    protected float $saldo = 0;

    public function __construct(
        protected readonly Titular $titular
    ) {}

    public function getSaldo(): float
    {
        return $this->saldo;
    }

    public function depositar(float $valor): void
    {
        if ($valor <= 0) {
            throw new ValorInvalidoException('Valor inválido.');
        }
        $this->saldo += $valor;
    }

    abstract public function sacar(float $valor): void;
}

class ContaCorrente extends ContaBancaria
{
    public function sacar(float $valor): void
    {
        if ($valor <= 0) {
            throw new ValorInvalidoException('Valor inválido.');
        }
        if ($valor > $this->saldo) {
            throw new SaldoInsuficienteException('Saldo insuficiente.');
        }
        $this->saldo -= $valor;
    }

    public function receberResgate(float $valor): void
    {
        $this->depositar($valor);
    }
}

class ContaInvestimento extends ContaBancaria
{
    public function taxaAdministracao(): float
    {
        if ($this->saldo >= 100000) {
            return 0.005;
        }
        if ($this->saldo >= 10000) {
            return 0.01;
        }
        return 0.02;
    }

    public function sacar(float $valor): void
    {
        $this->resgatar($valor);
    }

    public function resgatar(float $valor, ?ContaCorrente $destino = null): float
    {
        if ($valor <= 0) {
            throw new ValorInvalidoException('Valor inválido.');
        }
        if ($valor > $this->saldo) {
            throw new SaldoInsuficienteException('Saldo insuficiente.');
        }

        $imposto = $valor * 0.15;
        $taxa = $valor * $this->taxaAdministracao();
        $liquido = $valor - $imposto - $taxa;

        $this->saldo -= $valor;

        if ($destino !== null) {
            $destino->receberResgate($liquido);
        }

        return $liquido;
    }
}

$titular = new Titular('Maria', '12345678900');
$investimento = new ContaInvestimento($titular);
$corrente = new ContaCorrente($titular);

$investimento->depositar(20000);
$liquido = $investimento->resgatar(1000, $corrente);

echo "Valor líquido resgatado: R$ " .
    number_format($liquido, 2, ',', '.') . PHP_EOL;
echo "Saldo da conta investimento: R$ " .
    number_format($investimento->getSaldo(), 2, ',', '.') . PHP_EOL;
echo "Saldo da conta corrente: R$ " .
    number_format($corrente->getSaldo(), 2, ',', '.') . PHP_EOL;
