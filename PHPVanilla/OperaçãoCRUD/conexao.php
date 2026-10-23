<?php
declare(strict_types=1);

// Cria a conexão com o banco de dados.
$pdo = new PDO(
    'pgsql:host=localhost;dbname=empresa_sofia',
    'postgres',
    'indiana'
);

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);