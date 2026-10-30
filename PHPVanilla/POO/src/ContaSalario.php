<?php

declare(strict_types=1);

require_once __DIR__ . '/ContaBancaria.php';

class ContaSalario extends ContaBancaria
{
    private int $saquesNoMes = 0;

    private string $mesReferencia;

    public function __construct(
        string $numero,
        Titular $titular,
        private readonly string $cnpjEmpregador
    ) {
        parent::__construct($numero, $titular);

        if (!preg_match(
            '/^\d{14}$/',
            $this->cnpjEmpregador
        )) {
            throw new ValorInvalidoException(
                'O CNPJ deve conter 14 dígitos.'
            );
        }

        $this->mesReferencia = date('Y-m');
    }

    public function getCnpjEmpregador(): string
    {
        return $this->cnpjEmpregador;
    }

    public function depositarSalario(
        float $valor,
        string $cnpjAutenticado
    ): void {
        if ($cnpjAutenticado !== $this->cnpjEmpregador) {
            throw new OperacaoNaoPermitidaException(
                'Depósito não autorizado pelo empregador.'
            );
        }

        $this->depositar($valor);
    }

    public function depositar(float $valor): void
    {
        throw new OperacaoNaoPermitidaException(
            'Utilize depositarSalario() para creditar o salário.'
        );
    }

    public function sacar(float $valor): void
    {
        $this->validarValor($valor);
        $this->atualizarMesReferencia();

        $taxa = $this->saquesNoMes >= 2 ? 4.00 : 0.00;
        $total = $valor + $taxa;

        if ($total > $this->saldo) {
            throw new SaldoInsuficienteException(
                'Saldo insuficiente para o saque e a taxa.'
            );
        }

        $this->saldo -= $total;
        $this->saquesNoMes++;

        $this->registrarTransacao('Saque', $valor);

        if ($taxa > 0) {
            $this->registrarTransacao('Taxa de saque', $taxa);
        }

        $this->notificar(
            'Saque de R$ ' . number_format(
                $valor,
                2,
                ',',
                '.'
            )
        );
    }

    private function atualizarMesReferencia(): void
    {
        $mesAtual = date('Y-m');

        if ($mesAtual !== $this->mesReferencia) {
            $this->saquesNoMes = 0;
            $this->mesReferencia = $mesAtual;
        }
    }

    public function getTipo(): string
    {
        return 'Conta Salário';
    }
}
