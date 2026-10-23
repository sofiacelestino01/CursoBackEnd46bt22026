<?php
declare(strict_types=1);

// ContaCorrente é uma subclasse de ContaBancaria
// Regras de negócio: cheque especial e cobrança da taxa de saque

final class ContaCorrente extends ContaBancaria {

    // Atributos que não existem na ContaBancaria
    public const TARIFA_SAQUE = 2.50;

    // Construtor da ContaCorrente
    public function __construct(
        string $agencia,
        string $numeroConta,
        Titular $titular,
        float $saldoInicial = 0.0,
        private float $limiteChequeEspecial = 500.00
    ) {
        parent::__construct(
            $agencia,
            $numeroConta,
            $titular,
            $saldoInicial
        );
    }

    // Retornar o limite do cheque especial
    public function getLimiteChequeEspecial(): float
    {
        return $this->limiteChequeEspecial;
    }

    // Sacar dinheiro com cobrança de tarifa
    #[Override]
    public function sacar(float $valor): void {

        if ($valor <= 0.0) {
            throw new ValorInvalidoException($valor);
        }

        $custoTotal = $valor + self::TARIFA_SAQUE;

        $saldoTotalDisponivel =
            $this->saldo + $this->limiteChequeEspecial;

        // Verificar se existe saldo disponível
        if ($custoTotal > $saldoTotalDisponivel) {
            throw new SaldoInsuficienteException(
                $saldoTotalDisponivel,
                $custoTotal
            );
        }

        // Descontar o valor do saque e a tarifa
        $this->saldo -= $custoTotal;
    }
}
