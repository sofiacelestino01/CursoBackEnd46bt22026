<?php

declare(strict_types=1);

require_once __DIR__ . '/Excecoes.php';
require_once __DIR__ . '/Titular.php';
require_once __DIR__ . '/Transacao.php';
require_once __DIR__ . '/NotificadorInterface.php';

abstract class ContaBancaria
{
    protected float $saldo = 0.0;

    protected array $historico = [];

    protected array $notificadores = [];

    public function __construct(
        protected readonly string $numero,
        protected readonly Titular $titular
    ) {
        if (trim($this->numero) === '') {
            throw new ValorInvalidoException(
                'O número da conta não pode ser vazio.'
            );
        }
    }

    public function getNumero(): string
    {
        return $this->numero;
    }

    public function getTitular(): Titular
    {
        return $this->titular;
    }

    public function getSaldo(): float
    {
        return $this->saldo;
    }

    public function depositar(float $valor): void
    {
        $this->validarValor($valor);

        $this->saldo += $valor;

        $this->registrarTransacao('Depósito', $valor);

        $this->notificar(
            'Depósito de R$ ' . number_format(
                $valor,
                2,
                ',',
                '.'
            )
        );
    }

    public function sacar(float $valor): void
    {
        $this->validarValor($valor);

        if ($valor > $this->saldo) {
            throw new SaldoInsuficienteException(
                'Saldo insuficiente para realizar o saque.'
            );
        }

        $this->saldo -= $valor;

        $this->registrarTransacao('Saque', $valor);

        $this->notificar(
            'Saque de R$ ' . number_format(
                $valor,
                2,
                ',',
                '.'
            )
        );
    }

    protected function validarValor(float $valor): void
    {
        if (!is_finite($valor) || $valor <= 0) {
            throw new ValorInvalidoException(
                'O valor deve ser positivo e finito.'
            );
        }
    }

    protected function registrarTransacao(
        string $tipo,
        float $valor
    ): void {
        $this->historico[] = new Transacao(
            $tipo,
            $valor,
            date('d/m/Y H:i:s'),
            $this->saldo
        );
    }

    public function getExtrato(): array
    {
        return $this->historico;
    }

    public function adicionarNotificador(
        NotificadorInterface $notificador
    ): void {
        $this->notificadores[] = $notificador;
    }

    protected function notificar(string $mensagem): void
    {
        foreach ($this->notificadores as $notificador) {
            $notificador->enviar(
                $this->titular->getCpf(),
                $mensagem
            );
        }
    }

    public function transferir(
        ContaBancaria $destino,
        float $valor
    ): void {
        $this->validarValor($valor);

        if ($destino === $this) {
            throw new OperacaoNaoPermitidaException(
                'Não é possível transferir para a própria conta.'
            );
        }

        if ($destino->getTitular()->getCpf()
            !== $this->titular->getCpf()) {
            throw new OperacaoNaoPermitidaException(
                'A transferência só é permitida entre contas '
                . 'do mesmo titular.'
            );
        }

        $this->sacar($valor);
        $destino->depositar($valor);
    }

    abstract public function getTipo(): string;
}
