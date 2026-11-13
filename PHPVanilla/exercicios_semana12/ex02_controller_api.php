<?php
declare(strict_types=1);
/* SEMANA 12 - Exercicio 02: Resposta em formato JSON (API RESTful)
   Como executar: php -S localhost:8000 ex02_controller_api.php
   Testar: http://localhost:8000/api/produtos */

namespace App\Core {

    // Controller base com o metodo de resposta JSON
    abstract class Controller {

        // serializa os dados em JSON e devolve com o status HTTP informado
        protected function renderizarJson(array $dados, int $status = 200): void {
            header('Content-Type: application/json; charset=utf-8');
            http_response_code($status);
            echo json_encode($dados, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }
    }
}

namespace App\Models {

    // Model de produto com dados em memoria (para o exercicio rodar sem banco)
    final class Produto {
        private static array $dados = [
            ['id' => 1, 'nome' => 'Fresa de metal', 'categoria' => 'Usinagem', 'preco' => 89.90, 'estoque' => 12],
            ['id' => 2, 'nome' => 'Parafuso M8', 'categoria' => 'Fixacao', 'preco' => 1.50, 'estoque' => 500],
            ['id' => 3, 'nome' => 'Rolamento 6202', 'categoria' => 'Usinagem', 'preco' => 25.00, 'estoque' => 40],
        ];

        // lista todos os produtos
        public static function listarTodos(): array {
            return self::$dados;
        }
    }
}

namespace App\Controllers {

    final class ProdutoController extends \App\Core\Controller {

        // rota GET /api/produtos: catalogo serializado em JSON
        public function apiListar(): void {
            $produtos = \App\Models\Produto::listarTodos();
            $this->renderizarJson([
                'total'    => count($produtos),
                'produtos' => $produtos
            ]);
        }
    }
}

// Ponto de entrada (Front Controller simplificado)
namespace {
    $roteador = new App\Core\RoteadorSimples();
    $roteador->registrar('GET', '/api/produtos', [App\Controllers\ProdutoController::class, 'apiListar']);
    $roteador->despachar($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
}

// Roteador minimo so com rotas fixas (sem parametro dinamico)
namespace App\Core {
    final class RoteadorSimples {
        private array $rotas = [];

        // registra a rota fixa no vetor
        public function registrar(string $metodo, string $uri, array $acao): void {
            $this->rotas[strtoupper($metodo)]['/' . trim($uri, '/')] = $acao;
        }

        // despacha a rota ou responde 404
        public function despachar(string $metodo, string $uri): void {
            $caminho = '/' . trim((string)parse_url($uri, PHP_URL_PATH), '/');
            if (isset($this->rotas[strtoupper($metodo)][$caminho])) {
                [$classe, $metodoAcao] = $this->rotas[strtoupper($metodo)][$caminho];
                (new $classe())->$metodoAcao();
                return;
            }
            http_response_code(404);
            echo json_encode(['erro' => 'Rota nao encontrada'], JSON_UNESCAPED_UNICODE);
        }
    }
}
