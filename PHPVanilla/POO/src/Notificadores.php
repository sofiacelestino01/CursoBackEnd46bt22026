<?php

declare(strict_types=1);

require_once __DIR__ . '/NotificadorInterface.php';

class NotificadorEmail implements NotificadorInterface
{
    public function enviar(
        string $destinatario,
        string $mensagem
    ): bool {
        echo "E-mail enviado para {$destinatario}: {$mensagem}"
            . PHP_EOL;

        return true;
    }
}

class NotificadorSMS implements NotificadorInterface
{
    public function enviar(
        string $destinatario,
        string $mensagem
    ): bool {
        echo "SMS enviado para {$destinatario}: {$mensagem}"
            . PHP_EOL;

        return true;
    }
}

class NotificadorWhatsApp implements NotificadorInterface
{
    public function enviar(
        string $destinatario,
        string $mensagem
    ): bool {
        echo "WhatsApp enviado para {$destinatario}: {$mensagem}"
            . PHP_EOL;

        return true;
    }
}
