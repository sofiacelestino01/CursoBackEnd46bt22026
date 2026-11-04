<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SENAI Supply</title>
    <style>
        body{font-family:Arial,sans-serif;background:#f4f6f9;margin:0;color:#222}
        header{background:#12345a;color:white;padding:18px 5%}
        nav a{color:white;margin-right:18px;text-decoration:none}
        main{max-width:1100px;margin:30px auto;padding:20px;background:white;border-radius:10px}
        input,select,button{padding:10px;margin:5px 0;max-width:100%}
        input,select{border:1px solid #ccc;border-radius:5px}
        button{background:#12345a;color:white;border:0;border-radius:5px;cursor:pointer}
        table{border-collapse:collapse;width:100%;margin-top:20px}
        th,td{border:1px solid #ddd;padding:10px;text-align:left}
        th{background:#e9eef5}
        .card{display:inline-block;background:#e9eef5;padding:20px;margin:8px;border-radius:8px}
    </style>
</head>
<body>
<header>
    <h1>SENAI Supply</h1>
    <?php if (!empty($_SESSION['usuario'])): ?>
        <nav>
            <a href="/">Início</a>
            <a href="/produtos">Produtos</a>
            <a href="/movimentacoes">Movimentações</a>
            <form action="/logout" method="POST" style="display:inline">
                <input type="hidden" name="_token"
                    value="<?= htmlspecialchars($_SESSION['_token'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                <button type="submit">Sair</button>
            </form>
        </nav>
    <?php endif; ?>
</header>
<main><?= $conteudo ?? '' ?></main>
</body>
</html>
