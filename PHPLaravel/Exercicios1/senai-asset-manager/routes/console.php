<?php

declare(strict_types=1);

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Exercício 2: comando corporativo de diagnóstico da plataforma.
Artisan::command('senai:status', function () {
    // Nome da plataforma em azul no terminal.
    $this->info(config('app.name'));

    // Ambiente ativo da aplicação (APP_ENV).
    $this->line('Ambiente: ' . config('app.env'));

    // Total de ativos operacionais na fábrica (lista simulada).
    $this->line('Ativos operacionais: 37');
})->purpose('Exibe o diagnóstico da plataforma SENAI Asset Manager');
