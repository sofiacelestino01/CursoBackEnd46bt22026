<?php
declare(strict_types=1);
/* SEMANA 12 - Exercicio 03: Middleware de log de acessos no Roteador
   Como executar: php -S localhost:8000 ex03_middleware_log.php
   Testar: http://localhost:8000/produtos  (depois abra logs/acessos.log) */

namespace App\Core {

    // Roteador com interceptador de log antes de despachar
    final class RoteadorComLog {
        private array $rotas = [];

        // registra a rota fixa no vetor
        public function registrar(string $metodo, string $uri, array $acao): void {
            $this->rotas[strtoupper($metodo)]['/' . trim($uri, '/')] = $acao;
        }

        // antes de despachar, grava o log do acesso
        public function despachar(string $metodo, string $uri): void {
            $caminho = '/' . trim((string)parse_url($uri, PHP_URL_PATH), '/');
            $this->registrarAcesso($metodo, $caminho);
            if (isset($this->rotas[strtoupper($metodo)][$caminho])) {
                [$classe, $metodoAcao] = $this->rotas[strtoupper($metodo)][$caminho];
                (new $classe())->$metodoAcao();
                return;
            }
            http_response_code(404);
            echo '404 - Rota nao encontrada';
        }

        // grava data, hora, IP, metodo HTTP e URI no logs/acessos.log
        private function registrarAcesso(string $metodo, string $caminho): void {
            $pasta = __DIR__ . '/logs';
            if (!is_dir($pasta)) {
                mkdir($pasta, 0777, true); // cria a pasta se nao existir
            }
            $ip = $_SERVER['REMOTE_ADDR'] ?? 'desconhecido';
            $linha = sprintf(
                "[%s] IP: %s | %s %s%s",
                date('Y-m-d H:i:s'),
                $ip,
                strtoupper($metodo),
                $caminho,
                PHP_EOL
            );
            file_put_contents($pasta . '/acessos.log', $linha, FILE_APPEND);
        }
    }
}

namespace App\Controllers {

    final class ProdutoController {
        // lista simples para testar o log
        public function listar(): void {
            echo '<h1>Catalogo de Insumos</h1><p>Consulta registrada em logs/acessos.log</p>';
        }
    }
}

// Ponto de entrada (Front Controller simplificado)
namespace {
    $roteador = new App\Core\RoteadorComLog();
    $roteador->registrar('GET', '/produtos', [App\Controllers\ProdutoController::class, 'listar']);
    $roteador->despachar($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
}
