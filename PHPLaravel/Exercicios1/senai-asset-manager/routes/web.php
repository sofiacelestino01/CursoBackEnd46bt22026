<?php
declare(strict_types=1);

use App\Http\Controllers\AtivoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\ProdutoController;
use Illuminate\Support\Facades\Route;

// Rota principal da aplicação: dashboard de ativos fabris.
Route::get("/", [AtivoController::class, "index"])->name("ativos.index");

// Rota de infraestrutura para exibir o status em JSON.
Route::get("/status", [AtivoController::class, "status"])->name("ativos.status");

// Exercício 1: Telemetria com o detalhamento dos setores fabris.
Route::get("/setores", [AtivoController::class, "setores"])->name("ativos.setores");

// Exercício 3: Detalhamento de ativo por código de patrimônio.
Route::get("/ativos/{codigo}", [AtivoController::class, "detalhar"])
    ->name("ativos.detalhar")
    ->where("codigo", "[A-Za-z0-9\-]+");

// Exercício 5: Health Check para monitoramento de infraestrutura.
Route::get("/healthz", [AtivoController::class, "healthz"])->name("ativos.healthz");

// Exercício 1: contratos por cliente e ano, com constraints compostas.
Route::get("/clientes/{cliente}/contratos/{ano}", [ClienteController::class, "contratosPorAno"])
    ->name("clientes.contratos")
    ->whereNumber("cliente")
    ->where("ano", "[0-9]{4}");

// Exercício 3: telemetria da requisição. Deve vir antes do resource de clientes.
Route::get("/clientes/telemetria", [ClienteController::class, "origemRequisicao"])
    ->name("clientes.telemetria");

// Exercício 5: alteração parcial do status via PATCH.
Route::patch("/clientes/{id}/status", [ClienteController::class, "alterarStatus"])
    ->name("clientes.status")
    ->whereNumber("id");

// Rota customizada para busca por setor.
Route::get("/clientes/setor/{setor?}", [ClienteController::class, "filtrarPorSetor"])
    ->name("clientes.setor")
    ->whereAlphaNumeric("setor");

// Rota RESTful completa do módulo de clientes.
Route::resource("clientes", ClienteController::class)->whereNumber("cliente");

// Exercício 2: resource parcial somente leitura para fornecedores.
Route::resource("fornecedores", FornecedorController::class)
    ->parameters(["fornecedores" => "fornecedor"])
    ->only(["index", "show"])
    ->whereNumber("fornecedor");

// Rotas do módulo de produtos.
Route::resource("produtos", ProdutoController::class);

// Exercício 4: grupo administrativo com prefixo, nome e middleware.
Route::prefix("admin")
    ->name("admin.")
    ->middleware("throttle:60,1")
    ->group(function (): void {
        Route::get("/auditoria/clientes", [ClienteController::class, "auditoriaClientes"])
            ->name("auditoria.clientes");
    });
