<?php

declare(strict_types=1);

// Configura a conexão com o banco de dados.
$host = 'localhost';
$port = '5432';
$banco = 'empresa_sofia';
$usuario = 'postgres';
$senha = 'indiana';

$dsn = "pgsql:host=$host;port=$port;dbname=$banco";

$pdo = new PDO($dsn, $usuario, $senha, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);