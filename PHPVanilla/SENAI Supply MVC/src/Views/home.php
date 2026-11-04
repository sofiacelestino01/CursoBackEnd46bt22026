<h2>Painel de controle</h2>
<p>Bem-vindo(a), <?= htmlspecialchars($_SESSION['usuario']['nome'], ENT_QUOTES, 'UTF-8') ?>!</p>
<div class="card"><h3>Produtos cadastrados</h3><strong><?= $total ?></strong></div>
<div class="card"><h3>Produtos no estoque mínimo</h3><strong><?= $baixo ?></strong></div>
<p>Perfil: <?= htmlspecialchars($_SESSION['usuario']['perfil'], ENT_QUOTES, 'UTF-8') ?></p>
