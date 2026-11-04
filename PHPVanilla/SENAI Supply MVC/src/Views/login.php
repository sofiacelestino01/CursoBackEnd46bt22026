<h2>Entrar no sistema</h2>
<form action="/login" method="POST">
    <input type="hidden" name="_token"
        value="<?= htmlspecialchars($token, ENT_QUOTES, 'UTF-8') ?>">
    <p><label>E-mail<br><input type="email" name="email" required></label></p>
    <p><label>Senha<br><input type="password" name="senha" required></label></p>
    <button type="submit">Entrar</button>
</form>
