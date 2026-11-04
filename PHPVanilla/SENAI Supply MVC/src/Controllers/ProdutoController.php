<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Produto;

class ProdutoController extends Controller
{
    public function index(): void
    {
        $this->renderizar('produtos', [
            'produtos' => (new Produto())->listar(),
            'token' => $this->tokenCsrf()
        ]);
    }

    public function salvar(): void
    {
        $this->validarCsrf();

        $nome = trim($_POST['nome'] ?? '');
        $descricao = trim($_POST['descricao'] ?? '');
        $quantidade = filter_input(INPUT_POST, 'quantidade', FILTER_VALIDATE_INT);
        $minimo = filter_input(INPUT_POST, 'minimo', FILTER_VALIDATE_INT);

        if (
            $nome === '' || $quantidade === false || $quantidade === null ||
            $minimo === false || $minimo === null ||
            $quantidade < 0 || $minimo < 0
        ) {
            http_response_code(422);
            exit('Preencha os dados do produto corretamente.');
        }

        (new Produto())->cadastrar($nome, $descricao, $quantidade, $minimo);
        $this->redirecionar('/produtos');
    }
}
