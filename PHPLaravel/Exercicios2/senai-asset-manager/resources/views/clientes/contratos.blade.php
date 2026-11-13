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
        .resumo { display: flex; gap: 25px; flex-wrap: wrap; margin-bottom: 20px; }
        .resumo span { color: #94a3b8; font-size: 0.85rem; display: block; }
        .resumo strong { color: #f1f5f9; font-size: 1rem; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #334155; font-size: 0.9rem; }
        th { color: #94a3b8; background: #0f172a; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: bold; background: #0369a1; color: white; }
        .badge-vigente { background: #14532d; color: #bbf7d0; }
        .btn-voltar { color: #94a3b8; text-decoration: none; font-size: 0.9rem; }
        .btn-voltar:hover { color: #38bdf8; }
    </style>
</head>
<body>
<header>
    <h1>📄 Contratos por Cliente e Ano</h1>
    <a href="{{ route('clientes.index') }}" class="btn-voltar">← Voltar aos clientes</a>
</header>
<div class="container">
    <div class="card">
        <h2>{{ $titulo }}</h2>

        <div class="resumo">
            <div>
                <span>Cliente</span>
                <strong>{{ $cliente['razao_social'] }}</strong>
            </div>
            <div>
                <span>CNPJ</span>
                <strong>{{ $cliente['cnpj'] }}</strong>
            </div>
            <div>
                <span>Ano de referência</span>
                <strong>{{ $ano }}</strong>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Número</th>
                    <th>Ano</th>
                    <th>Valor</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contratos as $contrato)
                    <tr>
                        <td><strong>{{ $contrato['numero'] }}</strong></td>
                        <td>{{ $contrato['ano'] }}</td>
                        <td>R$ {{ number_format($contrato['valor'], 2, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ $contrato['status'] === 'VIGENTE' ? 'badge-vigente' : '' }}">
                                {{ $contrato['status'] }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align:center; color:#94a3b8;">
                            Nenhum contrato localizado para o ano informado.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            <a href="{{ route('clientes.show', $cliente['id']) }}" class="btn-voltar">Ver ficha do cliente</a>
        </div>
    </div>
</div>
</body>
</html>
