<?php
declare(strict_types=1);
/* SEMANA 12 - Exercicio 01: Rota com parametro dinamico
   Como executar: php -S localhost:8000 ex01_rota_parametro.php
   Testar: http://localhost:8000/produtos  e  http://localhost:8000/produtos/2 */

namespace App\Core {

    // Roteador artesanal com suporte a parametros dinamicos {id}
    final class Roteador {
        private array $rotas = [];

        // registra a rota no vetor
        public function registrar(string $metodo, string $uri, array $acao): void {
            $this->rotas[strtoupper($metodo)]['/' . trim($uri, '/')] = $acao;
        }

        // procura a rota que combina com a URI e despacha
        public function despachar(string $metodo, string $uri): void {
            $caminho = '/' . trim((string)parse_url($uri, PHP_URL_PATH), '/');
            foreach ($this->rotas[strtoupper($metodo)] ?? [] as $padrao => $acao) {
                $params = $this->casarRota($padrao, $caminho);
                if ($params !== null) {
                    $this->executar($acao, $params);
                    return;
                }
            }
            http_response_code(404);
            echo '404 - Rota nao encontrada';
        }

        // troca {id} por regex de numeros e faz o casamento
        private function casarRota(string $padrao, string $caminho): ?array {
            $regex = preg_replace('#\{[a-zA-Z_]+\}#', '(\d+)', $padrao);
            if (preg_match('#^' . $regex . '$#', $caminho, $m)) {
                array_shift($m); // remove o match completo, sobra so o parametro
                // converte para int (o regex captura texto e o metodo espera int)
                return array_map(fn (string $v): int|string => ctype_digit($v) ? (int)$v : $v, $m);
            }
            return null;
        }

        // cria o controller e chama o metodo passando os parametros
        private function executar(array $acao, array $params): void {
            [$classe, $metodo] = $acao;
            (new $classe())->$metodo(...$params);
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

        // busca o produto pelo identificador
        public static function buscarPorId(int $id): ?array {
            foreach (self::$dados as $p) {
                if ($p['id'] === $id) {
                    return $p;
                }
            }
            return null;
        }
    }
}

namespace App\Controllers {

    // Controller base com o metodo de resposta 404
    abstract class Controller {
        // resposta padrao quando o recurso nao existe
        protected function responderNaoEncontrado(string $msg): void {
            http_response_code(404);
            echo "<h1>404 - {$msg}</h1><a href='/produtos'>Voltar</a>";
        }
    }

    final class ProdutoController extends Controller {

        // lista o catalogo com links para o detalhe
        public function listar(): void {
            echo '<h1>Catalogo de Insumos</h1><ul>';
            foreach (\App\Models\Produto::listarTodos() as $p) {
                $nome = htmlspecialchars((string)$p['nome'], ENT_QUOTES, 'UTF-8');
                echo "<li><a href='/produtos/{$p['id']}'>{$nome}</a></li>";
            }
            echo '</ul>';
        }

        // busca o produto pelo id vindo da URL /produtos/{id}
        public function detalhar(int $id): void {
            $produto = \App\Models\Produto::buscarPorId($id);
            if ($produto === null) {
                $this->responderNaoEncontrado('Produto nao localizado');
                return;
            }
            $nome = htmlspecialchars((string)$produto['nome'], ENT_QUOTES, 'UTF-8');
            echo "<h1>Detalhe: {$nome}</h1>";
            echo '<p>Categoria: ' . htmlspecialchars((string)$produto['categoria'], ENT_QUOTES, 'UTF-8') . '</p>';
            echo '<p>Preco: R$ ' . number_format($produto['preco'], 2, ',', '.') . '</p>';
        }
    }
}

// Ponto de entrada (Front Controller simplificado)
namespace {
    $roteador = new App\Core\Roteador();
    $roteador->registrar('GET', '/produtos', [App\Controllers\ProdutoController::class, 'listar']);
    $roteador->registrar('GET', '/produtos/{id}', [App\Controllers\ProdutoController::class, 'detalhar']);
    $roteador->despachar($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
}
