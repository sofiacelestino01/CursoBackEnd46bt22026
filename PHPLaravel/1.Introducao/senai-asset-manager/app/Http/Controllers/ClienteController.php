<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     *Listar todos os clientes cadastrados
     */
    public function index(): View
    {
        return view("clientes.index", [
            "clientes"  => Cliente::all(),
            "titulo"    => "Parceiros e Clientes Industriais"
        ]);
    }

    /**
     * Exibir o formulário pRA CADASTRO DE NOVOS CLIENTES
     */
    public function create(): View
    {
        return view("clientes.create",[
            "titulo" => "Novo Cadastro de Parceito Industrial"
        ]);
    }

    /**
     * Salva o novo cliente no bd injetado pela request POST
     */
    //Injeção por Dependência Request para pegar informações do Formulário
    public function store(Request $request): RedirectResponse 
    {
        $dados = $request->validate([
            "razao_social"  => "required|min:3",
            "cnpj"          => "required|unique:clientes,cnpj", //permite a validação de cnpj unico no banco
            "setor"         => "required"
        ]);

        Cliente::create($dados + ["status" => "ATIVO"]);
        return redirect()->route("clientes.index")->with("sucesso", "Cliente cadastrado com sucesso");
    }

    /**
     * Exibir os detalhes de um cliente específico
     */
    public function show(int $id) : View 
    {
        //busca as informações do cliente no BD
        $cliente = Cliente::findOrFail($id);
        //findOrFail => retrona a mensagem de erro caso não encontre o cliente

        //se econtrado => abre uma tela com as info do cliente
        return view("clientes.show", [
            "cliente"  => $cliente,
            "titulo"    => "Ficha Técnica: {$cliente["razao_social"]}"
        ]);
    }

    /**
     * Exibir(view) o formulário de edicao de um cliente
     */
    public function edit(string $id) : View
    {
        $cliente = Cliente::findOrFail($id);

        return view("clientes.edit", [
            "cliente"   => $cliente,
            "titulo"    => "Editar Parcero: {$cliente["razao_social"]}"
        ]);
    }

    /**
     * Atuyalizar os dados do cliente Method Spooting (@method PUT)
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $dados = $request->validate([
            "razao_social"  => "required|min:3",
            "setor"         => "required"
        ]);

        Cliente::findOrFail($id)->update($dados);
        return redirect()->route("clientes.show", $id)->with("sucesso", "Dados atualizados com sucesso!");
    }

    /**
     * Remove o cliente  via @method DELETE
     */
    public function destroy(int $id): RedirectResponse
    {
        Cliente::findOrFail($id)->delete();
        return redirect()->route("clientes.index")->with("sucesso", "Parceiro Removido do Sistema");
    }

    //Filtro -: Server Side por setor
    public function filtrarPorSetor(?string $setor = null): View {
        $consulta = Cliente::query();
        if($setor !== null) {
            $consulta->where("setor", "like", $setor);
        }
        return view("clientes.index", [
            "cliente"   => $consulta->get(),
            "titulo"    => $setor ? "Setor: ". ucfirst($setor) : "Todos os Setores"
        ]);
    }

}
