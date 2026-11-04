<?php
declare(strict_types=1);

class ValorInvalidoException extends InvalidArgumentException {}

abstract class ContaBancaria
{
    private float $saldo = 0;

    public function depositar(float $valor): void
    {
        if ($valor <= 0) {
            throw new ValorInvalidoException('O depósito deve ser positivo.');
        }
        $this->saldo += $valor;
    }
}

class ContaCorrente extends ContaBancaria {}

$violacoesBloqueadas = 0;

echo "TESTES DE ENCAPSULAMENTO" . PHP_EOL;
echo str_repeat('-', 40) . PHP_EOL;

$conta = new ContaCorrente();

try {
    $conta->saldo = 1000000;
    echo "[FALHA] Acesso direto permitido." . PHP_EOL;
} catch (Error $erro) {
    $violacoesBloqueadas++;
    echo "[OK] Atributo privado protegido." . PHP_EOL;
}

try {
    new ContaBancaria();
    echo "[FALHA] Classe abstrata instanciada." . PHP_EOL;
} catch (Error $erro) {
    $violacoesBloqueadas++;
    echo "[OK] Classe abstrata não pode ser instanciada." . PHP_EOL;
}

try {
    $conta->depositar(-100);
    echo "[FALHA] Depósito negativo aceito." . PHP_EOL;
} catch (ValorInvalidoException $erro) {
    $violacoesBloqueadas++;
    echo "[OK] Depósito negativo bloqueado." . PHP_EOL;
}

echo str_repeat('-', 40) . PHP_EOL;
echo "Violações bloqueadas: $violacoesBloqueadas de 3 testes." . PHP_EOL;
