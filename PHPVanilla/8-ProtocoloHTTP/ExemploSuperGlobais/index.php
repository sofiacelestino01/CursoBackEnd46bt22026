<?php
declare(strict_types=1);
//aplicação de página unica utilizando as variáveis superglobais ($_GET, $_POST, $_SERVER) junto com formulários HTML de método GET e POST

// Dados Simulados para aplicação 

$produtos = [
    ['nome' => 'Teclado USB', 'categoria' => 'Eletrônicos', 'preco' => 80.00],
    ['nome' => 'Mouse sem fio', 'categoria' => 'Eletrônicos', 'preco' => 65.00],
    ['nome' => 'Caderno', 'categoria' => 'Papelaria', 'preco' => 25.00],
    ['nome' => 'Caneta azul', 'categoria' => 'Papelaria', 'preco' => 3.50],
    ['nome' => 'Monitor 24 polegadas', 'categoria' => 'Eletrônicos', 'preco' => 899.90],
];

$cadastros= [
    ["nome" => "Jose", "email" => "jose@email.com"]
];

//Declaração de Variáveis

$mensagemSucesso = ""; // vai servir para apresentar uma mensagem quando um usuário for cadastrado
$erros = []; // array para armazenar erros caso necessários e devolver para o usuários os erros de validação

$nome = ""; // recebera o valor do campo nome para cadastro de usuários
$email = ""; // receberá o valor do campo email para cadastro de email

// Criando o Processo GET => busca na lista de produtos e retornar uma lista filtrada
//busca pelo name e atribu o valor a superglobal ($_GET)
$buscaProduto = trim((string) ($_GET["produto"] ?? ""));
//verificação/operador de nulidade de uma variável (coalescência nula)
$precoMaximoTexto = trim((string) ($_GET["preco_maximo"])); // recebe o valor do input preco_maximo


$produtosFiltrado = $produtos; //copiando a lista de produtos para produtos filtrados

//criar o mecanismo de filtragem para produtos
if($buscaProduto !== "" || $precoMaximoTexto !== ""){ // se algum dos inputs for difernte de vazio
    $produtosFiltrado = array_filter($produtos, function (array $produto) use ($buscaProduto,$precoMaximoTexto): bool {
        $nomeStatus = true;
        $precoStatus = true;
        //verificação se no nome do produto contêm o termo de busca, se tiver retorna true
        if($buscaProduto !== ""){
            $nomeStatus = str_contains(strtolower($produto["nome"]),strtolower($buscaProduto));
        }

        //vericar o preco de um produto e filtra se o produto for menor que o preço máximo determinado
        if($precoMaximoTexto !== ""){
            $precoMaximo = filter_var($precoMaximoTexto, FILTER_VALIDATE_FLOAT);
            $precoStatus = $precoMaximo !== false && $produto["preco"] <= $precoMaximo;
        }

        return $nomeStatus && $precoStatus;

    });
}

//PRocessamento do Método POST => permitir o Cadastro FAke de um Cliente -> exibir os dados na tela 

//verificar o Status da SuperGlobal $_SERVER e prosegue se for um POST
if($_SERVER["REQUEST_METHOD"] === "POST") {
    //REcuperar os dados do Formulário
    $nome = trim((string) ($_POST["nome"] ?? "")); // Recebe o valor do nome do input HTML
    $email = trim((string) ($_POST["email"] ?? "")); // Recebe o valor do email do input HTML

    //Validação dde Dados ao Lado do Servidor
    //enviar uma mensagem de erro se a variável nome for menor que 3 caracteres
    if(strlen($nome)<3){
        $erros["nome"] = "Informe um nome com pelo menos 3 caracteres";
    }
    //Validar email do Usuário 
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $erros["email"] = "Informe um email Válido!";
    }

    //SE não exisitir ERROS, o cadastro será realizado
    if($erros === []){
        $mensagemSucesso = "Cadastro Realizado com Sucesso!";
        $usuario = ["nome" => $nome,"email" => $email];
        array_push($cadastros, $usuario);   
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exemplo de GET e POST no PHP</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <h1>Exemplo prático: GET e POST</h1>

        <section>
            <h2>Utilização de filtro pela URL (GET)</h2>

            <form action="index.php" method="GET">
                <label for="produto">Nome do Produto</label>
                <input type="text" name="produto" id="produto" placeholder="Buscar Produto">

                <label for="preco_maximo">Preço Máximo</label>
                <input type="number" name="preco_maximo" id="preco_maximo" step="0.01" placeholder="100">

                <button type="submit">Pesquisar</button>
            </form>

            <h2>Lista de Produtos Filtrados</h2>
            <p>Observem que os dados da pesquisa aparecem na URL</p>

            <?php if ($produtosFiltrado === []): ?>
                <p class="vazio">Nenhum produto encontrado.</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Categoria</th>
                            <th>Preço</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($produtosFiltrado as $produto): ?>
                            <tr>
                                <td><?= $produto['nome'] ?></td>
                                <td><?= $produto['categoria'] ?></td>
                                <td>
                                    R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

        </section>

        <section>
            <h2>Cadastro de Alunos com POST</h2>
            <p>Os dados serão enviados no corpo(body) da requisição e não aparecem na URL</p>

            <?php if($mensagemSucesso !== ""):?>
                <div class="sucesso">
                    <?=  $nome ?><br>
                    <?= $email ?>
                </div>
            <?php endif; ?>

            <form action="index.php" method="POST">
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome" placeholder="Digite seu Nome">
                <?php if(isset($erros["nome"])): ?>
                    <div class="erro">
                        <?= $erros["nome"] ?>
                    </div>
                <?php endif; ?>

                <label for="email">Email</label>
                <input type="text" name="email" id="email" placeholder="Digite seu Email">
                <?php if(isset($erros["email"])): ?>
                    <div class="erro">
                        <?= $erros["email"] ?>
                    </div>
                <?php endif; ?>

                <button type="submit">Cadastrar</button>  

            </form>

        </section>
    </main>
    
</body>
</html>