<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $titulo }}</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #0f172a; margin: 0; color: #f8fafc; }
        header { background: #1e293b; padding: 16px 30px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #334155; }
        header h1 { font-size: 1.25rem; color: #38bdf8; margin: 0; }
        .container { max-width: 800px; margin: 40px auto; padding: 0 20px; }
        .card { background: #1e293b; padding: 30px; border-radius: 10px; border: 1px solid #334155; text-align: center; }
        .total { font-size: 3.5rem; font-weight: bold; color: #38bdf8; margin: 15px 0; }
        .legenda { color: #94a3b8; font-size: 0.9rem; }
        .btn-voltar { display: inline-block; margin-top: 25px; color: #94a3b8; text-decoration: none; font-size: 0.9rem; }
        .btn-voltar:hover { color: #38bdf8; }
    </style>
</head>
<body>
<header>
    <h1>🔐 Área Administrativa</h1>
    <a href="{{ route('clientes.index') }}" class="btn-voltar">← Módulo de clientes</a>
</header>
<div class="container">
    <div class="card">
        <h2>{{ $titulo }}</h2>
        <div class="total">{{ $totalAtivos }}</div>
        <p class="legenda">Parceiros com status <strong>ATIVO</strong> no cadastro.</p>
        <a href="{{ route('admin.auditoria.clientes') }}" class="btn-voltar">
            Recarregar auditoria
        </a>
    </div>
</div>
</body>
</html>
