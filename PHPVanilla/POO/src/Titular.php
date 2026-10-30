<?php

declare(strict_types=1);

class Titular
{
    public function __construct(
        private string $nome,
        private string $cpf
    ) {
        if (trim($this->nome) === '') {
            throw new TitularInvalidoException(
                'O nome do titular não pode ser vazio.'
            );
        }

        if (trim($this->cpf) === '') {
            throw new TitularInvalidoException(
                'O CPF do titular não pode ser vazio.'
            );
        }
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getCpf(): string
    {
        return $this->cpf;
    }
}