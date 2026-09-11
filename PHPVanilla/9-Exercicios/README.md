# Parte A: Exercícios Teóricos de Fixação

1. *Diferença Estrutural*:

No GET, os dados aparecem na URL.
No POST, os dados são enviados no corpo da requisição e não aparecem na URL.

2. *Segurança e Privacidade*:

As senhas não devem ser enviadas usando GET, porque os dados ficam visíveis na URL e podem ser armazenados em lugares que outras pessoas ou sistemas podem acessar.

Por exemplo, uma senha enviada por GET poderia ficar registrada no histórico do navegador e nos logs do servidor.

3. *Coalescência Nula*:

A instrução $nome = $_POST['nome']; pode gerar um Warning quando a página é aberta pela primeira vez porque o formulário ainda não foi enviado e, por isso, $_POST['nome'] ainda não existe. O operador ?? resolve esse problema verificando se o valor existe. Por exemplo, $nome = $_POST['nome'] ?? ''; significa que, se o nome não existir, será usado um valor vazio.

4. *Idempotência*:

Uma requisição GET deve ser usada principalmente para consultar ou buscar informações, sem modificar os dados. Por exemplo, podemos usar GET para abrir um produto, como produto.php?id=10. Usar GET para atualizar ou deletar dados é uma má prática porque apenas acessar um link poderia realizar uma alteração no sistema. Por exemplo, um link como excluir.php?id=10 poderia apagar um produto simplesmente ao ser acessado.

5. *Validação Client vs Server*:

A afirmação é falsa porque required e type="email" fazem a validação no navegador, e essa validação pode ser desativada ou ignorada. Por isso, o PHP também precisa validar os dados recebidos. Por exemplo, mesmo que o HTML peça um e-mail válido, o PHP deve verificar novamente se o e-mail realmente possui um formato correto.

6. *XSS e Sanitização*:

Exibir diretamente um dado recebido pelo $_POST pode causar um problema de segurança chamado XSS. Isso acontece quando uma pessoa envia um conteúdo malicioso em um formulário e esse conteúdo é exibido na página como código. Para evitar esse problema, usamos htmlspecialchars(), que transforma caracteres especiais e faz com que o conteúdo seja tratado como texto.

7. *Sticky Forms*:

Sticky Forms é uma técnica que mantém os dados que o usuário digitou preenchidos depois que o formulário é enviado. Isso melhora a experiência do usuário porque ele não precisa digitar tudo novamente caso tenha cometido algum erro. Por exemplo, se uma pessoa preencher o nome como Sofia e ocorrer um erro em outro campo, o nome Sofia continuará preenchido no formulário.

8. *DevTools*:

No DevTools do navegador, podemos verificar se o formulário usa GET ou POST. Basta apertar F12, abrir a aba Network, enviar o formulário e clicar na requisição. Em Request Method, aparecerá GET ou POST.