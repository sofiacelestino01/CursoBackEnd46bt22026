<?php
declare(strict_types=1);

class Titular
{
    public function __construct(
        public readonly string $nome,
        public readonly string $contato
    ) {}
}

interface NotificadorInterface
{
    public function notificar(Titular $titular, string $mensagem): bool;
}

class NotificadorEmail implements NotificadorInterface
{
    public function notificar(Titular $titular, string $mensagem): bool
    {
        echo "E-mail para {$titular->contato}: $mensagem" . PHP_EOL;
        return true;
    }
}

class NotificadorSMS implements NotificadorInterface
{
    public function notificar(Titular $titular, string $mensagem): bool
    {
        echo "SMS para {$titular->contato}: $mensagem" . PHP_EOL;
        return true;
    }
}

class NotificadorWhatsApp implements NotificadorInterface
{
    public function notificar(Titular $titular, string $mensagem): bool
    {
        echo "WhatsApp para {$titular->contato}: $mensagem" . PHP_EOL;
        return true;
    }
}

abstract class ContaBancaria
{
    protected float $saldo = 0;
    protected array $notificadores = [];

    public function __construct(
        protected readonly Titular $titular
    ) {}

    public function adicionarNotificador(
        NotificadorInterface $notificador
    ): void {
        $this->notificadores[] = $notificador;
    }

    protected function notificarTodos(string $mensagem): void
    {
        foreach ($this->notificadores as $notificador) {
            $notificador->notificar($this->titular, $mensagem);
        }
    }

    public function depositar(float $valor): void
    {
        if ($valor <= 0) {
            throw new InvalidArgumentException('Valor inválido.');
        }
        $this->saldo += $valor;
        $this->notificarTodos("Depósito de R$ " . number_format($valor, 2, ',', '.'));
    }

    abstract public function sacar(float $valor): void;
}

class ContaCorrente extends ContaBancaria
{
    public function sacar(float $valor): void
    {
        if ($valor <= 0) {
            throw new InvalidArgumentException('Valor inválido.');
        }
        if ($valor > $this->saldo) {
            throw new RuntimeException('Saldo insuficiente.');
        }
        $this->saldo -= $valor;
        $this->notificarTodos("Saque de R$ " . number_format($valor, 2, ',', '.'));
    }
}

$titular = new Titular('João', 'joao@example.com');
$conta = new ContaCorrente($titular);

$conta->adicionarNotificador(new NotificadorEmail());
$conta->adicionarNotificador(new NotificadorSMS());
$conta->adicionarNotificador(new NotificadorWhatsApp());

$conta->depositar(500);
$conta->sacar(100);
