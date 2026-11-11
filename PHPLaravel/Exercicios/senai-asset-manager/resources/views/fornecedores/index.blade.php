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
        .container { max-width: 1000px; margin: 30px auto; padding: 0 20px; }
        .card { background: #1e293b; border-radius: 8px; padding: 25px; border: 1px solid #334155; }
        .aviso { background: #0f172a; border: 1px solid #334155; color: #94a3b8; padding: 12px; border-radius: 6px; margin-bottom: 20px; font-size: 0.85rem; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #334155; font-size: 0.9rem; }
        th { color: #94a3b8; background: #0f172a; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: bold; background: #0369a1; color: white; }
        .btn-acao { text-decoration: none; font-size: 0.8rem; font-weight: bold; padding: 4px 8px; border-radius: 4px; color: #38bdf8; }
        .btn-voltar { color: #94a3b8; text-decoration: none; font-size: 0.9rem; }
        .btn-voltar:hover { color: #38bdf8; }
    </style>
</head>
<body>
<header>
    <h1>🏭 Fornecedores Homologados</h1>
    <a href="{{ route('ativos.index') }}" class="btn-voltar">← Painel de ativos</a>
</header>
<div class="container">
    <div class="card">
        <h2>{{ $titulo }}</h2>

        <div class="aviso">
            Resource parcial: somente as ações <strong>index</strong> e <strong>show</strong> estão publicadas.
            Cadastro, edição e exclusão foram omitidos com <strong>only()</strong>.
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fornecedor</th>
                    <th>Segmento</th>
                    <th>Cidade</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                @forelse($fornecedores as $fornecedor)
                    <tr>
                        <td>#{{ $fornecedor['id'] }}</td>
                        <td><strong>{{ $fornecedor['nome'] }}</strong></td>
                        <td><span class="badge">{{ $fornecedor['segmento'] }}</span></td>
                        <td>{{ $fornecedor['cidade'] }}</td>
                        <td>
                            <a href="{{ route('fornecedores.show', $fornecedor['id']) }}" class="btn-acao">
                                Ver ficha
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center; color:#94a3b8;">
                            Nenhum fornecedor localizado.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
