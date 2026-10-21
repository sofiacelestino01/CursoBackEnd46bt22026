<?php
declare(strict_types=1);

//ContaCorrente é uma subClasse de ContaBancaria
//Regras de negócio : ChequeEspecial e Cobrança da tx de saque

final class ContaCorrente extends ContaBancaria{
    //atributos que não existe na contaBancaria
    public const TARIFA_SAQUE = 2.50;

    //substituir o construtor da contaBancaria
    //ChequeEspecial -> quando criar a conta precisa declarar o cheque especial
    public function __construct(
        string $agencia, 
        string $numeroConta, 
        Titular $titular, 
        float $saldoInicial = 0.0,
        private float $limiteChequeEspecial = 500.00)
    {
        return parent::__construct($agencia, $numeroConta, $titular, $saldoInicial);
    }

    #[Override]
    public function sacar(float $valor): void {
        if($valor <=0.0) {
            throw new ValorInvalidoException($valor);
        }

        $custoTotal = $valor +self::TARIFA_SAQUE;
        $saldoTotalDisponivel = $this->saldo + $this->limiteChequeEspecial;

        //se valor do saque for maior que saldo disponivel lança uma exception
        if($custoTotal > $saldoTotalDisponivel){ 
            throw new SaldoInsuficienteException($saldoTotalDisponivel, $custoTotal);
        }

        //se tudo tiver certo
        $this->saldo -= $custoTotal;
    }
}