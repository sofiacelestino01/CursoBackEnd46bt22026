<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Logger;
use App\Models\Movimentacao;
use App\Core\ConexaoBanco;

class MovimentacaoController extends Controller
{
    public function index(): void
    {
        $produtos = ConexaoBanco::conectar()
            ->query('SELECT id, nome, quantidade FROM produtos ORDER BY nome')
            ->fetchAll();

        $this->renderizar('movimentacoes', [
            'movimentacoes' => (new Movimentacao())->listar(),
            'produtos' => $produtos,
            'token' => $this->tokenCsrf()
        ]);
    }

    public function salvar(): void
    {
        $this->validarCsrf();

        $produto = filter_input(INPUT_POST, 'produto_id', FILTER_VALIDATE_INT);
        $quantidade = filter_input(INPUT_POST, 'quantidade', FILTER_VALIDATE_INT);
        $tipo = $_POST['tipo'] ?? '';
        $observacao = trim($_POST['observacao'] ?? '');

        if (
            !$produto || !$quantidade || $quantidade < 1 ||
            !in_array($tipo, ['entrada', 'saida'], true)
        ) {
            http_response_code(422);
            exit('Dados da movimentação inválidos.');
        }

        try {
            (new Movimentacao())->registrar(
                $produto,
                (int) $_SESSION['usuario']['id'],
                $tipo,
                $quantidade,
                $observacao
            );
        } catch (\Throwable $erro) {
            Logger::registrar('ERROR', 'Falha na movimentação', [
                'erro' => $erro->getMessage()
            ]);
            http_response_code(422);
            exit('Não foi possível registrar a movimentação: ' .
                htmlspecialchars($erro->getMessage(), ENT_QUOTES, 'UTF-8'));
        }

        $this->redirecionar('/movimentacoes');
    }
}
