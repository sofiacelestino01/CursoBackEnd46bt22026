<?php

declare(strict_types=1);

require_once __DIR__ . '/ContaBancaria.php';

class ContaPoupanca extends ContaBancaria
{
    public function __construct(
        string $numero,
        Titular $titular,
        private readonly float $taxaRendimento = 0.005
    ) {
        parent::__construct($numero, $titular);

        if (!is_finite($this->taxaRendimento)
            || $this->taxaRendimento < 0) {
            throw new ValorInvalidoException(
                'A taxa de rendimento não pode ser negativa.'
            );
        }
    }

    public function getTaxaRendimento(): float
    {
        return $this->taxaRendimento;
    }

    public function aplicarRendimento(): void
    {
        if ($this->saldo <= 0 || $this->taxaRendimento <= 0) {
            return;
        }

        $rendimento = $this->saldo * $this->taxaRendimento;

        $this->saldo += $rendimento;

        $this->registrarTransacao(
            'Rendimento',
            $rendimento
        );

        $this->notificar(
            'Rendimento de R$ ' . number_format(
                $rendimento,
                2,
                ',',
                '.'
            )
        );
    }

    public function getTipo(): string
    {
        return 'Conta Poupança';
    }
}
