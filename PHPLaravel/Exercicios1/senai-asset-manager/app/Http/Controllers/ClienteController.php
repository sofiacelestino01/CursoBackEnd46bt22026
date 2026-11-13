<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Lista todos os clientes cadastrados.
     */
    public function index(): View
    {
        return view("clientes.index", [
            "clientes" => Cliente::all(),
            "titulo" => "Parceiros e Clientes Industriais"
        ]);
    }

    /**
     * Exibe o formulário de cadastro de novos clientes.
     */
    public function create(): View
    {
        return view("clientes.create", [
            "titulo" => "Novo Cadastro de Parceiro Industrial"
        ]);
    }

    /**
     * Salva o novo cliente no banco de dados.
     */
    public function store(Request $request): RedirectResponse
    {
        $dados = $request->validate([
            "razao_social" => "required|min:3",
            "cnpj" => "required|unique:clientes,cnpj",
            "setor" => "required"
        ]);

        Cliente::create($dados + ["status" => "ATIVO"]);

        return redirect()->route("clientes.index")
            ->with("sucesso", "Cliente cadastrado com sucesso");
    }

    /**
     * Exibe os detalhes de um cliente específico.
     */
    public function show(int $id): View
    {
        $cliente = Cliente::findOrFail($id);

        return view("clientes.show", [
            "cliente" => $cliente,
            "titulo" => "Ficha Técnica: {$cliente["razao_social"]}"
        ]);
    }

    /**
     * Exibe o formulário de edição de um cliente.
     */
    public function edit(string $id): View
    {
        $cliente = Cliente::findOrFail($id);

        return view("clientes.edit", [
            "cliente" => $cliente,
            "titulo" => "Editar Parceiro: {$cliente["razao_social"]}"
        ]);
    }

    /**
     * Atualiza os dados do cliente via Method Spoofing (@method PUT).
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $dados = $request->validate([
            "razao_social" => "required|min:3",
            "setor" => "required"
        ]);

        Cliente::findOrFail($id)->update($dados);

        return redirect()->route("clientes.show", $id)
            ->with("sucesso", "Dados atualizados com sucesso!");
    }

    /**
     * Remove o cliente via Method Spoofing (@method DELETE).
     */
    public function destroy(int $id): RedirectResponse
    {
        Cliente::findOrFail($id)->delete();

        return redirect()->route("clientes.index")
            ->with("sucesso", "Parceiro removido do sistema");
    }

    /**
     * Filtro server-side por setor.
     */
    public function filtrarPorSetor(?string $setor = null): View
    {
        $consulta = Cliente::query();

        if ($setor !== null) {
            $consulta->where("setor", "like", $setor);
        }

        return view("clientes.index", [
            "clientes" => $consulta->get(),
            "titulo" => $setor ? "Setor: " . ucfirst($setor) : "Todos os Setores"
        ]);
    }

    /**
     * Exercício 1: exibe os contratos do cliente para o ano informado.
     */
    public function contratosPorAno(int $cliente, int $ano): View
    {
        $parceiro = Cliente::findOrFail($cliente);
        $contratos = collect($this->contratosMockados())
            ->where("cliente_id", $cliente)
            ->where("ano", $ano)
            ->values();

        return view("clientes.contratos", [
            "cliente" => $parceiro,
            "contratos" => $contratos,
            "ano" => $ano,
            "titulo" => "Contratos {$ano}: {$parceiro["razao_social"]}"
        ]);
    }

    /**
     * Exercício 3: devolve os metadados de rede da requisição atual.
     */
    public function origemRequisicao(Request $request): JsonResponse
    {
        return response()->json([
            "ip" => $request->ip(),
            "user_agent" => $request->userAgent(),
            "metodo" => $request->method(),
            "rota" => $request->path(),
            "timestamp" => now()->toIso8601String()
        ]);
    }

    /**
     * Exercício 4: lista a quantidade total de parceiros ativos.
     */
    public function auditoriaClientes(): View
    {
        $totalAtivos = Cliente::query()->where("status", "ATIVO")->count();

        return view("admin.auditoria.clientes", [
            "totalAtivos" => $totalAtivos,
            "titulo" => "Auditoria de Parceiros Ativos"
        ]);
    }

    /**
     * Exercício 5: altera exclusivamente o status do cliente.
     */
    public function alterarStatus(Request $request, int $id): RedirectResponse
    {
        $dados = $request->validate([
            "status" => "required|in:ATIVO,SUSPENSO"
        ]);

        Cliente::findOrFail($id)->update(["status" => $dados["status"]]);

        return redirect()->route("clientes.index")
            ->with("sucesso", "Status do parceiro atualizado com sucesso!");
    }

    /**
     * Massa de dados simulada para o laboratório de rotas.
     *
     * @return array<int, array<string, int|float|string>>
     */
    private function contratosMockados(): array
    {
        return [
            ["numero" => "CT-2024-001", "cliente_id" => 2, "ano" => 2024, "valor" => 85000.00, "status" => "ENCERRADO"],
            ["numero" => "CT-2025-002", "cliente_id" => 2, "ano" => 2025, "valor" => 120000.00, "status" => "ENCERRADO"],
            ["numero" => "CT-2026-003", "cliente_id" => 2, "ano" => 2026, "valor" => 145000.00, "status" => "VIGENTE"],
            ["numero" => "CT-2026-004", "cliente_id" => 3, "ano" => 2026, "valor" => 98000.00, "status" => "VIGENTE"]
        ];
    }
}
