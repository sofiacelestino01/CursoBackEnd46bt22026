<?php
declare(strict_types=1);

// Classe para representar o titular da conta bancária

final class Titular {

    // Property Promotion
    // readonly: impede alterar o valor depois de definido
    public function __construct(
        public readonly string $nome,
        public readonly string $cpf
    )
    {
        $this->validarDados();
    }

    // Validar dados de forma privada
    private function validarDados(): void {
        if (strlen(trim($this->nome)) < 3) {
            throw new InvalidArgumentException(
                "O nome do titular deve possuir no mínimo 3 caracteres."
            );
        }

        // CPF: remove todos os caracteres que não forem números
        $cpfNumeros = preg_replace("/\D/", "", $this->cpf);

        if (strlen($cpfNumeros) !== 11) {
            throw new InvalidArgumentException(
                "O CPF deve ter exatamente 11 dígitos numéricos."
            );
        }
    }
}
