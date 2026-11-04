<?php
declare(strict_types=1);

namespace App\Core;

class Roteador
{
    private array $rotas = [];

    public function adicionar(
        string $metodo,
        string $caminho,
        callable|array $acao,
        array $perfis = []
    ): void {
        $this->rotas[] = [
            'metodo' => strtoupper($metodo),
            'caminho' => $caminho,
            'acao' => $acao,
            'perfis' => $perfis
        ];
    }

    public function executar(string $metodo, string $caminho): void
    {
        foreach ($this->rotas as $rota) {
            if (
                $rota['metodo'] === strtoupper($metodo) &&
                $rota['caminho'] === $caminho
            ) {
                if ($rota['perfis'] !== []) {
                    AuthGuard::exigirPerfil($rota['perfis']);
                }

                call_user_func($rota['acao']);
                return;
            }
        }

        http_response_code(404);
        echo '404 - Página não encontrada.';
    }
}
