<?php

declare(strict_types=1);

class Transacao
{
    public function __construct(
        private readonly string $tipo,
        private readonly float $valor,
        private readonly string $data,
        private readonly float $saldoAposTransacao
    ) {
        if (trim($this->tipo) === '') {
            throw new ValorInvalidoException(
                'O tipo da transação não pode ser vazio.'
            );
        }

        if ($this->valor <= 0) {
            throw new ValorInvalidoException(
                'O valor da transação deve ser positivo.'
            );
        }

        if ($this->saldoAposTransacao < 0) {
            throw new ValorInvalidoException(
                'O saldo não pode ser negativo.'
            );
        }
    }

    public function getTipo(): string
    {
        return $this->tipo;
    }

    public function getValor(): float
    {
        return $this->valor;
    }

    public function getData(): string
    {
        return $this->data;
    }

    public function getSaldoAposTransacao(): float
    {
        return $this->saldoAposTransacao;
    }
}
