<?php
declare(strict_types=1);

final class SaldoInsuficienteException extends ContaException{
    #[Override]
    public function __construct(float $saldoDisponivel, float $valorTentado)
    {
        $message = sprintf(
            "Saldo insuficiente. Disponivel: R$ %.2f | Tentativa com encargos: R$ %.2f",
            $saldoDisponivel,
            $valorTentado
        );
        parent::__construct($message);
    }
}