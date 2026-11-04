<?php
declare(strict_types=1);

use App\Core\Roteador;
use App\Core\Logger;
use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\ProdutoController;
use App\Controllers\MovimentacaoController;

if (PHP_SAPI === 'cli-server') {
    $arquivo = __DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if (is_file($arquivo)) {
        return false;
    }
}

require dirname(__DIR__) . '/vendor/autoload.php';

$envArquivo = dirname(__DIR__) . '/.env';
if (is_file($envArquivo)) {
    foreach (file($envArquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $linha) {
        $linha = trim($linha);
        if ($linha !== '' && !str_starts_with($linha, '#') && str_contains($linha, '=')) {
            [$chave, $valor] = explode('=', $linha, 2);
            putenv(trim($chave) . '=' . trim($valor));
        }
    }
}

session_set_cookie_params([
    'httponly' => true,
    'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
    'samesite' => 'Lax'
]);
session_start();

set_exception_handler(function (Throwable $erro): void {
    Logger::registrar('ERROR', $erro->getMessage());
    http_response_code(500);
    echo 'Erro interno. Consulte logs/app.log.';
});

$roteador = new Roteador();

$auth = new AuthController();
$home = new HomeController();
$produtos = new ProdutoController();
$movimentacoes = new MovimentacaoController();

$roteador->adicionar('GET', '/login', [$auth, 'formulario']);
$roteador->adicionar('POST', '/login', [$auth, 'entrar']);
$roteador->adicionar('POST', '/logout', [$auth, 'sair'], ['admin', 'gestor', 'almoxarife']);
$roteador->adicionar('GET', '/', [$home, 'index'], ['admin', 'gestor', 'almoxarife']);
$roteador->adicionar('GET', '/produtos', [$produtos, 'index'], ['admin', 'gestor', 'almoxarife']);
$roteador->adicionar('POST', '/produtos/salvar', [$produtos, 'salvar'], ['admin', 'gestor']);
$roteador->adicionar('GET', '/movimentacoes', [$movimentacoes, 'index'], ['admin', 'gestor', 'almoxarife']);
$roteador->adicionar('POST', '/movimentacoes/salvar', [$movimentacoes, 'salvar'], ['admin', 'gestor', 'almoxarife']);

$caminho = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
$roteador->executar($_SERVER['REQUEST_METHOD'], $caminho);
