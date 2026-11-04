<?php
declare(strict_types=1);

class Transacao
{
    public function __construct(
        public readonly string $tipo,
        public readonly float $valor,
        public readonly DateTimeImmutable $dataHora,
        public readonly bool $sucesso
    ) {}
}

abstract class ContaBancaria
{
    protected float $saldo = 0;
    protected array $historico = [];

    public function depositar(float $valor): void
    {
        if ($valor <= 0) {
            throw new InvalidArgumentException('Valor inválido.');
        }
        $this->saldo += $valor;
        $this->historico[] = new Transacao(
            'Depósito', $valor, new DateTimeImmutable(), true
        );
    }

    public function sacar(float $valor): void
    {
        if ($valor <= 0) {
            throw new InvalidArgumentException('Valor inválido.');
        }
        if ($valor > $this->saldo) {
            $this->historico[] = new Transacao(
                'Saque', $valor, new DateTimeImmutable(), false
            );
            throw new RuntimeException('Saldo insuficiente.');
        }
        $this->saldo -= $valor;
        $this->historico[] = new Transacao(
            'Saque', $valor, new DateTimeImmutable(), true
        );
    }

    public function getExtrato(): array
    {
        return $this->historico;
    }

    public function getSaldo(): float
    {
        return $this->saldo;
    }
}

class ContaCorrente extends ContaBancaria {}

$conta = new ContaCorrente();
$conta->depositar(1000);
$conta->sacar(150);

try {
    $conta->sacar(2000);
} catch (RuntimeException $erro) {
    echo $erro->getMessage() . PHP_EOL;
}

echo PHP_EOL . "EXTRATO BANCÁRIO" . PHP_EOL;
echo str_repeat('-', 65) . PHP_EOL;
printf("%-20s %-22s %-12s %-10s\n", 'Tipo', 'Data e hora', 'Valor', 'Resultado');

foreach ($conta->getExtrato() as $transacao) {
    printf(
        "%-20s %-22s R$ %-9.2f %-10s\n",
        $transacao->tipo,
        $transacao->dataHora->format('d/m/Y H:i:s'),
        $transacao->valor,
        $transacao->sucesso ? 'Sucesso' : 'Falhou'
    );
}

echo str_repeat('-', 65) . PHP_EOL;
printf("Saldo consolidado: R$ %.2f\n", $conta->getSaldo());
