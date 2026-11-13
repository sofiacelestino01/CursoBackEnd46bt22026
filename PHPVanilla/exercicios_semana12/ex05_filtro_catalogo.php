<?php
declare(strict_types=1);
/* SEMANA 12 - Exercicio 05: Filtro de busca por categoria
   Como executar: php -S localhost:8000 ex05_filtro_catalogo.php
   Testar: http://localhost:8000/produtos?categoria=Usinagem */

namespace App\Models {

    // Model de produto com filtro por categoria
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

        // filtra o catalogo pela categoria informada
        public static function buscarPorCategoria(string $categoria): array {
            return array_values(array_filter(self::$dados, function (array $p) use ($categoria): bool {
                return strcasecmp($p['categoria'], $categoria) === 0;
            }));
        }

        // devolve as categorias unicas para o campo de selecao
        public static function listarCategorias(): array {
            $cats = [];
            foreach (self::$dados as $p) {
                $cats[$p['categoria']] = true;
            }
            return array_keys($cats);
        }
    }
}

namespace App\Controllers {

    final class ProdutoController {

        // captura ?categoria= da query string e repassa ao Model
        public function listar(): void {
            $categoria = trim((string)($_GET['categoria'] ?? ''));
            $produtos = $categoria !== ''
                ? \App\Models\Produto::buscarPorCategoria($categoria)
                : \App\Models\Produto::listarTodos();
            $this->renderizarTabela($produtos, $categoria);
        }

        // monta a tela: select de categoria + tabela filtrada
        private function renderizarTabela(array $produtos, string $categoria): void {
            echo '<h1>Catalogo de Insumos</h1>';
            echo "<form method='GET' action='/produtos'>";
            echo "<select name='categoria'><option value=''>Todas as categorias</option>";
            foreach (\App\Models\Produto::listarCategorias() as $cat) {
                $sel = strcasecmp($cat, $categoria) === 0 ? 'selected' : '';
                $catHtml = htmlspecialchars($cat, ENT_QUOTES, 'UTF-8');
                echo "<option value='{$catHtml}' {$sel}>{$catHtml}</option>";
            }
            echo '</select> <button type="submit">Filtrar</button></form>';
            echo '<table border="1" cellpadding="6"><tr><th>ID</th><th>Nome</th><th>Categoria</th><th>Preco</th></tr>';
            foreach ($produtos as $p) {
                $nome = htmlspecialchars((string)$p['nome'], ENT_QUOTES, 'UTF-8');
                $cat  = htmlspecialchars((string)$p['categoria'], ENT_QUOTES, 'UTF-8');
                echo "<tr><td>{$p['id']}</td><td>{$nome}</td><td>{$cat}</td><td>R$ "
                    . number_format($p['preco'], 2, ',', '.') . '</td></tr>';
            }
            echo '</table>';
        }
    }
}

// Ponto de entrada (Front Controller simplificado)
namespace {
    $roteador = new App\Core\RoteadorQuery();
    $roteador->registrar('GET', '/produtos', [App\Controllers\ProdutoController::class, 'listar']);
    $roteador->despachar($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
}

// Roteador minimo: a query string (?categoria=) nao faz parte do casamento
namespace App\Core {
    final class RoteadorQuery {
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
            echo '404 - Rota nao encontrada';
        }
    }
}
