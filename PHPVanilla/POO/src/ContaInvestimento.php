<?php

declare(strict_types=1);

require_once __DIR__ . '/ContaBancaria.php';

class ContaInvestimento extends ContaBancaria
{
    public function __construct(
        string $numero,
        Titular $titular,
        private readonly float $taxaAdministracao = 0.02
    ) {
        parent::__construct($numero, $titular);

        if (!is_finite($this->taxaAdministracao)
            || $this->taxaAdministracao < 0) {
            throw new ValorInvalidoException(
                'A taxa de administração não pode ser negativa.'
            );
        }
    }

    public function getTaxaAdministracao(): float
    {
        return $this->taxaAdministracao;
    }

    public function calcularTaxaAdministracao(
        int $meses
    ): float {
        if ($meses < 0) {
            throw new ValorInvalidoException(
                'O período não pode ser negativo.'
            );
        }

        $reducao = $meses * 0.001;

        return max(0.0, $this->taxaAdministracao - $reducao);
    }

    public function resgatar(
        float $valor,
        int $dias,
        ContaBancaria $contaDestino
    ): float {
        $this->validarValor($valor);

        if ($dias < 0) {
            throw new ValorInvalidoException(
                'Os dias não podem ser negativos.'
            );
        }

        if ($contaDestino === $this) {
            throw new OperacaoNaoPermitidaException(
                'A conta de destino deve ser diferente.'
            );
        }

        if ($contaDestino->getTitular()->getCpf()
            !== $this->titular->getCpf()) {
            throw new OperacaoNaoPermitidaException(
                'O resgate só pode ir para conta do mesmo titular.'
            );
        }

        if ($valor > $this->saldo) {
            throw new SaldoInsuficienteException(
                'Saldo insuficiente para o resgate.'
            );
        }

        $taxaIof = $this->calcularTaxaIof($dias);
        $taxaIr = $this->calcularTaxaIr($dias);

        $iof = $valor * $taxaIof;
        $ir = ($valor - $iof) * $taxaIr;
        $valorLiquido = $valor - $iof - $ir;

        $this->saldo -= $valor;

        $this->registrarTransacao('Resgate', $valor);

        $contaDestino->depositar($valorLiquido);

        $this->notificar(
            'Resgate líquido de R$ ' . number_format(
                $valorLiquido,
                2,
                ',',
                '.'
            )
        );

        return $valorLiquido;
    }

    private function calcularTaxaIof(int $dias): float
    {
        if ($dias >= 30) {
            return 0.0;
        }

        return (30 - $dias) / 30;
    }

    private function calcularTaxaIr(int $dias): float
    {
        if ($dias <= 180) {
            return 0.225;
        }

        if ($dias <= 360) {
            return 0.20;
        }

        if ($dias <= 720) {
            return 0.175;
        }

        return 0.15;
    }

    public function getTipo(): string
    {
        return 'Conta Investimento';
    }
}
