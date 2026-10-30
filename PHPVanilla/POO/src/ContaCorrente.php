<?php

declare(strict_types=1);

require_once __DIR__ . '/ContaBancaria.php';

class ContaCorrente extends ContaBancaria
{
    public function __construct(
        string $numero,
        Titular $titular,
        private readonly float $limiteChequeEspecial = 0.0
    ) {
        parent::__construct($numero, $titular);

        if (!is_finite($this->limiteChequeEspecial)
            || $this->limiteChequeEspecial < 0) {
            throw new ValorInvalidoException(
                'O limite do cheque especial não pode ser negativo.'
            );
        }
    }

    public function getLimiteChequeEspecial(): float
    {
        return $this->limiteChequeEspecial;
    }

    public function sacar(float $valor): void
    {
        $this->validarValor($valor);

        if ($valor > $this->saldo + $this->limiteChequeEspecial) {
            throw new SaldoInsuficienteException(
                'Saldo e limite do cheque especial insuficientes.'
            );
        }

        $this->saldo -= $valor;

        $this->registrarTransacao('Saque', $valor);

        $this->notificar(
            'Saque de R$ ' . number_format(
                $valor,
                2,
                ',',
                '.'
            )
        );
    }

    public function getTipo(): string
    {
        return 'Conta Corrente';
    }
}
