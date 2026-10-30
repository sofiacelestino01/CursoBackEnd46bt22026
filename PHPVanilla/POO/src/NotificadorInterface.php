<?php

declare(strict_types=1);

interface NotificadorInterface
{
    public function enviar(
        string $destinatario,
        string $mensagem
    ): bool;
}
