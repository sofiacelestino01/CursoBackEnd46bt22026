<?php
declare(strict_types=1);

class ContaException extends DomainException {
    //Herdando as Exception da Biblioteca DomainException
    public function __construct(string $message = "Falha na operação bancária")
    {
        return parent::__construct($message);
    }

}