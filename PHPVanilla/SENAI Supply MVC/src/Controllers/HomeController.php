<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\ConexaoBanco;

class HomeController extends Controller
{
    public function index(): void
    {
        $pdo = ConexaoBanco::conectar();

        $total = (int) $pdo->query(
            'SELECT COUNT(*) FROM produtos'
        )->fetchColumn();

        $baixo = (int) $pdo->query(
            'SELECT COUNT(*) FROM produtos
             WHERE quantidade <= estoque_minimo'
        )->fetchColumn();

        $this->renderizar('home', [
            'total' => $total,
            'baixo' => $baixo,
            'token' => $this->tokenCsrf()
        ]);
    }
}
