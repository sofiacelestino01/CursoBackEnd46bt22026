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
        .form-group { margin-bottom: 16px; }
        label { display: block; font-size: 0.85rem; margin-bottom: 6px; color: #cbd5e1; font-weight: 600; }
        input { width: 100%; padding: 10px; background: #0f172a; border: 1px solid #475569; border-radius: 6px; color: #f8fafc; box-sizing: border-box; }
        .btn-salvar { background: #0284c7; color: white; border: none; padding: 10px 20px; border-radius: 6px; font-weight: bold; cursor: pointer; }
        .btn-salvar:hover { background: #0369a1; }
        .link-voltar { color: #94a3b8; text-decoration: none; font-size: 0.9rem; margin-right: 15px; }
    </style>
</head>

<body>
<div class="container">
    <div class="card">
        <h1>⚙️ {{ $titulo }}</h1>

        <!-- Formulário POST com Method Spoofing para PUT -->
        <form action="{{ route('produtos.update', $produto->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nome">Nome do Produto</label>
                <input type="text" id="nome" name="nome" value="{{ $produto->nome }}" required>
            </div>

            <div class="form-group">
                <label for="fabricante">Fabricante</label>
                <input type="text" id="fabricante" name="fabricante" value="{{ $produto->fabricante }}" required>
            </div>

            <div class="form-group">
                <label for="quantidade">Quantidade</label>
                <input type="number" id="quantidade" name="quantidade" value="{{ $produto->quantidade }}" min="0" required>
            </div>

            <div class="form-group">
                <label for="preco">Preço</label>
                <input type="number" id="preco" name="preco" value="{{ $produto->preco }}" step="0.01" min="0" required>
            </div>

            <div style="display:flex; justify-content:flex-end; align-items:center; margin-top:20px;">
                <a href="{{ route('produtos.show', $produto->id) }}" class="link-voltar">← Cancelar</a>
                <button type="submit" class="btn-salvar">Salvar Alterações (PUT)</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
