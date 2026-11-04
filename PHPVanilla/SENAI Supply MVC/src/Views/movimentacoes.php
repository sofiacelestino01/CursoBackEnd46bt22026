<h2>Movimentações de estoque</h2>
<form action="/movimentacoes/salvar" method="POST">
    <input type="hidden" name="_token" value="<?= htmlspecialchars($token, ENT_QUOTES, 'UTF-8') ?>">
    <p><label>Produto<br><select name="produto_id" required>
        <option value="">Selecione um produto</option>
        <?php foreach ($produtos as $produto): ?>
        <option value="<?= (int) $produto['id'] ?>">
            <?= htmlspecialchars($produto['nome'], ENT_QUOTES, 'UTF-8') ?>
            (estoque: <?= (int) $produto['quantidade'] ?>)
        </option>
        <?php endforeach; ?>
    </select></label></p>
    <p><label>Tipo<br><select name="tipo" required>
        <option value="entrada">Entrada</option>
        <option value="saida">Saída</option>
    </select></label></p>
    <p><input type="number" name="quantidade" min="1" placeholder="Quantidade" required></p>
    <p><input name="observacao" placeholder="Observação"></p>
    <button type="submit">Registrar movimentação</button>
</form>
<table>
<thead><tr><th>Data</th><th>Produto</th><th>Tipo</th><th>Quantidade</th><th>Usuário</th></tr></thead>
<tbody>
<?php foreach ($movimentacoes as $m): ?>
<tr>
<td><?= htmlspecialchars($m['criado_em'], ENT_QUOTES, 'UTF-8') ?></td>
<td><?= htmlspecialchars($m['produto'], ENT_QUOTES, 'UTF-8') ?></td>
<td><?= htmlspecialchars($m['tipo'], ENT_QUOTES, 'UTF-8') ?></td>
<td><?= (int) $m['quantidade'] ?></td>
<td><?= htmlspecialchars($m['usuario'] ?? '-', ENT_QUOTES, 'UTF-8') ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
