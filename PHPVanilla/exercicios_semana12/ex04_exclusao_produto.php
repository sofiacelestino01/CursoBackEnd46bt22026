<?php
declare(strict_types=1);
/* SEMANA 12 - Exercicio 04: Exclusao segura de produto (POST /produtos/excluir)
   Como executar: php -S localhost:8000 ex04_exclusao_produto.php
   Testar: http://localhost:8000/produtos  (botao Excluir com confirm()) */

namespace App\Models {

    // Model de produto com dados em memoria e operacao de exclusao
    final class Produto {
        private static array $dados = [
            1 => ['id' => 1, 'nome' => 'Fresa de metal', 'categoria' => 'Usinagem', 'preco' => 89.90, 'estoque' => 12],
            2 => ['id' => 2, 'nome' => 'Parafuso M8', 'categoria' => 'Fixacao', 'preco' => 1.50, 'estoque' => 500],
            3 => ['id' => 3, 'nome' => 'Rolamento 6202', 'categoria' => 'Usinagem', 'preco' => 25.00, 'estoque' => 40],
        ];

        // lista todos os produtos
        public static function listarTodos(): array {
            return array_values(self::$dados);
        }

        // remove o produto pelo id e informa se conseguiu
        public static function excluir(int $id): bool {
            if (!isset(self::$dados[$id])) {
                return false;
            }
            unset(self::$dados[$id]);
            return true;
        }
    }
}

namespace App\Controllers {

    final class ProdutoController {

        // lista o catalogo com o botao Excluir em cada linha
        public function listar(): void {
            echo '<h1>Catalogo de Insumos</h1><table border="1" cellpadding="6">';
            echo '<tr><th>ID</th><th>Nome</th><th>Categoria</th><th>Acao</th></tr>';
            foreach (\App\Models\Produto::listarTodos() as $p) {
                $nome = htmlspecialchars((string)$p['nome'], ENT_QUOTES, 'UTF-8');
                $cat  = htmlspecialchars((string)$p['categoria'], ENT_QUOTES, 'UTF-8');
                echo "<tr><td>{$p['id']}</td><td>{$nome}</td><td>{$cat}</td><td>";
                echo "<form method='POST' action='/produtos/excluir' style='display:inline'>";
                echo "<input type='hidden' name='id' value='{$p['id']}'>";
                echo "<button onclick=\"return confirm('Excluir este produto?')\">Excluir</button>";
                echo '</form></td></tr>';
            }
            echo '</table>';
        }

        // recebe o ID via POST e pede a exclusao ao Model
        public function excluir(): void {
            $id = (int)($_POST['id'] ?? 0);
            if ($id <= 0) {
                http_response_code(422);
                echo '<p>ID invalido</p><a href="/produtos">Voltar</a>';
                return;
            }
            \App\Models\Produto::excluir($id);
            header('Location: /produtos');
            exit;
        }
    }
}

// Ponto de entrada (Front Controller simplificado)
namespace {
    $roteador = new App\Core\RoteadorPost();
    $roteador->registrar('GET', '/produtos', [App\Controllers\ProdutoController::class, 'listar']);
    $roteador->registrar('POST', '/produtos/excluir', [App\Controllers\ProdutoController::class, 'excluir']);
    $roteador->despachar($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
}

// Roteador minimo para rotas GET e POST fixas
namespace App\Core {
    final class RoteadorPost {
        private array $rotas = [];

        // registra a rota no vetor separada por metodo HTTP
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
            echo '404 - Rota nao encontrada';
        }
    }
}
