<h2>Produtos</h2>
<?php if (in_array($_SESSION['usuario']['perfil'], ['gestor', 'admin'], true)): ?>
<form action="/produtos/salvar" method="POST">
    <input type="hidden" name="_token" value="<?= htmlspecialchars($token, ENT_QUOTES, 'UTF-8') ?>">
    <p><input name="nome" placeholder="Nome do produto" required></p>
    <p><input name="descricao" placeholder="Descrição"></p>
    <p><input type="number" name="quantidade" min="0" placeholder="Quantidade inicial" required></p>
    <p><input type="number" name="minimo" min="0" placeholder="Estoque mínimo" required></p>
    <button type="submit">Cadastrar produto</button>
</form>
<?php endif; ?>
<table>
<thead><tr><th>ID</th><th>Produto</th><th>Quantidade</th><th>Estoque mínimo</th></tr></thead>
<tbody>
<?php foreach ($produtos as $produto): ?>
<tr>
<td><?= (int) $produto['id'] ?></td>
<td><?= htmlspecialchars($produto['nome'], ENT_QUOTES, 'UTF-8') ?></td>
<td><?= (int) $produto['quantidade'] ?></td>
<td><?= (int) $produto['estoque_minimo'] ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
