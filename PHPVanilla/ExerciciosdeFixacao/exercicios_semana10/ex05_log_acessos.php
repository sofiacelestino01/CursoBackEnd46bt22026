<?php
declare(strict_types=1);

// Configure os dados de conexão do seu PostgreSQL
$pdo = new PDO(
    'pgsql:host=localhost;port=5432;dbname=empresa_sofia',
    'postgres',
    'SUA_SENHA',
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

// Cria a tabela de auditoria
$sql = "CREATE TABLE IF NOT EXISTS auditoria_logins (
    id SERIAL PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    ip VARCHAR(45),
    user_agent TEXT,
    sucesso BOOLEAN NOT NULL,
    data_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

$pdo->exec($sql);

// Registra uma tentativa de autenticação
function registrarAcesso(
    PDO $pdo,
    string $email,
    bool $sucesso
): void {
    $sql = "INSERT INTO auditoria_logins
        (email, ip, user_agent, sucesso)
        VALUES (:email, :ip, :user_agent, :sucesso)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':email' => $email,
        ':ip' => $_SERVER['REMOTE_ADDR'] ?? 'desconhecido',
        ':user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'desconhecido',
        ':sucesso' => $sucesso
    ]);
}

// Exemplo de registro de uma tentativa com falha
registrarAcesso($pdo, 'teste@exemplo.com', false);

echo "Tabela criada e tentativa registrada!";
