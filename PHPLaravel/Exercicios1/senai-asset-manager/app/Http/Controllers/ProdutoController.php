<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ProdutoController extends Controller
{
    /**
     * Listar todos os produtos cadastrados
     */
    public function index(): View
    {
        return view("produtos.index", [
            "produtos" => Produto::all(),
            "titulo" => "Produtos Industriais"
        ]);
    }

    /**
     * Exibir formulário de cadastro
     */
    public function create(): View
    {
        return view("produtos.create", [
            "titulo" => "Cadastrar Novo Produto"
        ]);
    }

    /**
     * Salvar novo produto no banco de dados
     */
    public function store(Request $request): RedirectResponse
    {
        $dados = $request->validate([
            "nome" => "required|min:3",
            "fabricante" => "required",
            "quantidade" => "required|integer|min:0",
            "preco" => "required|numeric|min:0"
        ]);

        Produto::create($dados);

        return redirect()->route("produtos.index")
            ->with("sucesso", "Produto cadastrado com sucesso!");
    }

    /**
     * Exibir detalhes de um produto
     */
    public function show(Produto $produto): View
    {
        return view("produtos.show", [
            "produto" => $produto,
            "titulo" => "Ficha Técnica: {$produto->nome}"
        ]);
    }

    /**
     * Exibir formulário de edição
     */
    public function edit(Produto $produto): View
    {
        return view("produtos.edit", [
            "produto" => $produto,
            "titulo" => "Editar Produto: {$produto->nome}"
        ]);
    }

    /**
     * Atualizar dados do produto
     */
    public function update(Request $request, Produto $produto): RedirectResponse
    {
        $dados = $request->validate([
            "nome" => "required|min:3",
            "fabricante" => "required",
            "quantidade" => "required|integer|min:0",
            "preco" => "required|numeric|min:0"
        ]);

        $produto->update($dados);

        return redirect()->route("produtos.show", $produto)
            ->with("sucesso", "Produto atualizado com sucesso!");
    }

    /**
     * Excluir produto
     */
    public function destroy(Produto $produto): RedirectResponse
    {
        $produto->delete();

        return redirect()->route("produtos.index")
            ->with("sucesso", "Produto removido com sucesso!");
    }
}
