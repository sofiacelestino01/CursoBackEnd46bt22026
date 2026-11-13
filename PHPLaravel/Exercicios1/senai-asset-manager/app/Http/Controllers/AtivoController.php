<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class AtivoController extends Controller
{
    /**
     * Método index() - Retorna a view com as métricas mokadas
     */
    public function index(): View
    {
        $metricas = [
            "totalAtivos"    => 42,
            "emOperacao"     => 37,
            "emManutencao"   => 4,
            "parados"        => 1,
            "taxaEficiencia" => 88.5,
        ];

        return view("ativos.index", [
            "metricas" => $metricas,
            "titulo"   => "Painel Geral de Ativos Industriais",
        ]);
    }

    /**
     * Método status() - Retorna o status do servidor em JSON.
     */
    public function status(): JsonResponse
    {
        return response()->json([
            "plataforma"  => config("app.name"),
            "ambiente"    => config("app.env"),
            "version_php" => PHP_VERSION,
            "status"      => "ONLINE",
            "timestamp"   => now()->toIso8601String(),
        ]);
    }

    /**
     * Exercício 1: Lista os setores fabris com quantidade de máquinas e eficiência média.
     */
    public function setores(): JsonResponse
    {
        // Lista simulada dos três principais setores da fábrica.
        $setores = [
            ["setor" => "Usinagem", "quantidade_maquinas" => 12, "eficiencia_media" => 91.5],
            ["setor" => "Estamparia", "quantidade_maquinas" => 8, "eficiencia_media" => 87.2],
            ["setor" => "Montagem Robótica", "quantidade_maquinas" => 15, "eficiencia_media" => 94.8],
        ];

        return response()->json([
            "plataforma" => config("app.name"),
            "setores"    => $setores,
        ]);
    }

    /**
     * Exercício 3: Detalha um ativo pelo código de patrimônio (ex.: PAT-001).
     */
    public function detalhar(string $codigo): JsonResponse
    {
        // Valida o formato padrão corporativo: PAT- seguido de 3 dígitos.
        if (preg_match('/^PAT-\d{3}$/', $codigo) !== 1) {
            return response()->json([
                "erro" => "Código inválido. Use o formato PAT-001.",
            ], 404);
        }

        // Busca o ativo na lista simulada (senai:status usa a mesma base).
        $ativo = $this->ativosSimulados()[$codigo] ?? null;

        if ($ativo === null) {
            return response()->json([
                "erro" => "Ativo {$codigo} não encontrado no catálogo.",
            ], 404);
        }

        return response()->json(["ativo" => $ativo]);
    }

    /**
     * Exercício 5: Health Check leve para monitoramento de infraestrutura.
     */
    public function healthz(): JsonResponse
    {
        return response()->json([
            "status"         => "UP",
            "uptime_segundos" => round(microtime(true) - LARAVEL_START, 2),
            "memoria_mb"     => round(memory_get_usage(true) / 1024 / 1024, 2),
        ]);
    }

    /**
     * Catálogo simulado de ativos usado pelo detalhar().
     */
    private function ativosSimulados(): array
    {
        return [
            "PAT-001" => ["nome" => "Torno CNC", "setor" => "Usinagem", "tensao" => "220V", "horas_uso" => 1250],
            "PAT-002" => ["nome" => "Prensa Hidráulica", "setor" => "Estamparia", "tensao" => "380V", "horas_uso" => 3400],
            "PAT-003" => ["nome" => "Braço Robótico", "setor" => "Montagem Robótica", "tensao" => "380V", "horas_uso" => 890],
        ];
    }
}
