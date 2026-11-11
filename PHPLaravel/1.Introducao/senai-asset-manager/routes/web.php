<?php

use App\Http\Controllers\AtivoController;
use App\Http\Controllers\ClienteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;

//Rota Principal da Minha aplicação : Dashboard de Ativos Fabris
Route::get("/", [AtivoController::class, "index"])->name("ativos.index");

//Rota de Infraestrutura para exibir o status  em um json
Route::get("/status", [AtivoController::class, "status"])->name("ativos.status");

// Rota Customizada para a busca por setor 
Route::get("/clientes/setor/{setor?}" , [ClienteController::class, "filtrarPorSetor"])
    ->name("clientes.setor")
    ->whereAlphaNumeric("setor");

//Laravel possui uma técnica de criação de rotas usando o resources
// Rota Restful com identificador numerico (GET/clientes; Get/clientes/id; POST/clientes; PUT/clientes/id; DELETE/clientes/id)
Route::resource("clientes", ClienteController::class)->whereNumber("clientes");

// Rotas do módulo Produtos
Route::resource("produtos", ProdutoController::class);
