<?php

declare(strict_types=1);

class ValorInvalidoException extends InvalidArgumentException
{
}

class SaldoInsuficienteException extends RuntimeException
{
}

class OperacaoNaoPermitidaException extends RuntimeException
{
}

class TitularInvalidoException extends InvalidArgumentException
{
}