<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $titulo }}</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #0f172a; margin: 0; color: #f8fafc; }
        .container { max-width: 650px; margin: 40px auto; padding: 0 20px; }
        .card { background: #1e293b; padding: 30px; border-radius: 10px; border: 1px solid #334155; }
        h1 { font-size: 1.4rem; color: #38bdf8; margin-top: 0; }
        .item-info { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #334155; }
        .item-info span { color: #94a3b8; font-size: 0.9rem; }
        .item-info strong { color: #f1f5f9; font-size: 0.95rem; }
        .btn-voltar { color: #94a3b8; text-decoration: none; font-size: 0.9rem; }
        .btn-voltar:hover { color: #38bdf8; }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <h1>📋 {{ $titulo }}</h1>

        <div class="item-info"><span>Identificador:</span><strong>#{{ $fornecedor['id'] }}</strong></div>
        <div class="item-info"><span>Fornecedor:</span><strong>{{ $fornecedor['nome'] }}</strong></div>
        <div class="item-info"><span>Segmento:</span><strong>{{ $fornecedor['segmento'] }}</strong></div>
        <div class="item-info"><span>Cidade:</span><strong>{{ $fornecedor['cidade'] }}</strong></div>

        <div style="margin-top: 25px;">
            <a href="{{ route('fornecedores.index') }}" class="btn-voltar">← Voltar à lista de fornecedores</a>
        </div>
    </div>
</div>
</body>
</html>
