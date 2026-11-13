<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class FornecedorController extends Controller
{
    /**
     * Lista os fornecedores homologados (rota pública somente leitura).
     */
    public function index(): View
    {
        return view("fornecedores.index", [
            "fornecedores" => $this->fornecedoresMockados(),
            "titulo" => "Fornecedores Homologados"
        ]);
    }

    /**
     * Exibe a ficha pública de um fornecedor.
     */
    public function show(int $fornecedor): View
    {
        $registro = collect($this->fornecedoresMockados())
            ->firstWhere("id", $fornecedor);

        abort_if($registro === null, 404, "Fornecedor não localizado.");

        return view("fornecedores.show", [
            "fornecedor" => $registro,
            "titulo" => "Fornecedor: {$registro["nome"]}"
        ]);
    }

    /**
     * Massa simulada para a rota pública somente leitura.
     *
     * @return array<int, array<string, int|string>>
     */
    private function fornecedoresMockados(): array
    {
        return [
            ["id" => 1, "nome" => "Bosch Rexroth", "segmento" => "Hidráulica", "cidade" => "Campinas"],
            ["id" => 2, "nome" => "SKF do Brasil", "segmento" => "Rolamentos", "cidade" => "Cajamar"],
            ["id" => 3, "nome" => "Festo Automação", "segmento" => "Pneumática", "cidade" => "São Paulo"]
        ];
    }
}
