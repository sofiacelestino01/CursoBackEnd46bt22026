<?php
declare(strict_types=1);

//Camada de Acesso a Dados (DAO) para Almoxarifado
//essa Camada é uma Classe - usa Paradigma de Programação Orientada ao Objeto

final class AlmoxarifadoDAO{
    //atributos -> as caracteristicas do objeto
    private PDO $pdo;

    // métodos -> ações
    //método que toda classe tem -> Construtor -> permite instanciar objetos
    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    // métodos do CRUD

    //Read
    //lisatr todos -> busca as informações no banco e retorna um vetor com essa informações 
    public function listarTodos(): array {
        //criar o sql
        $sql = "SELECT * FROM pecas_industriais ORDER BY id DESC";
        //executar a conexão com o banco e fazer a query
        $stmt = $this->pdo->query($sql);
        //devolver em formato de array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        //vai me retornar a busca no banco em um vetor php
        // [
        //     {$id=>1, $nome=>"nometal", $quantidade=>29}
        //     {$id=>2, $nome=>"nometal2", $quantidade=>99}            
        // ]
    }

    //listar uma peça específica pelo id
    public function buscarPorId(int $id): ?array { // eu esperando o retorno de um array, porém, aceita um retorno nulo também
        $sql= "SELECT * FROM pecas_industriais WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":id",$id, PDO::PARAM_INT); //garantindo a que o valor do parâmetro seja passado como um nº inteiro
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado ?: null;
    }

    //CREATE => Salva informações no Banco
    public function salvar(array $dados): bool {
        $sql = "INSERT INTO pecas_industriais
        (codigo_sku, descricao, categoria, quantidade, preco_unitario)
        VALUES (:sku, :descricao, :categoria, :quantidade, :preco)";
        //se tem entrada de dados por input , fazer o prepare
        $stmt = $this->pdo->prepare($sql);

        $resultado = $stmt->execute([
            ":sku"          => strtoupper((trim($dados["codigo_sku"]))),
            ":descricao"    => trim($dados["descricao"]),
            ":categoria"    => trim($dados["categoria"]),
            ":quantidade"   => (int)$dados["quantidade"], //estou fazendo um "CAST" para inteiro -> convertendo o dados para um nº inteiro
            ":preco"        => (float)$dados["preco_unitario"]//CAST para float
        ]);

        return $resultado; //retrona true or false
    }

    //Update
    public function atualizar(int $id, array $dados):bool{
        $sql = "UPDATE pecas_industriais
                SET codigo_sku = :sku, 
                    descricao = :descricao, 
                    categoria = :categoria, 
                    quantidade = :quantidade, 
                    preco_unitario = :preco
                WHERE id = :id";

        //se tem entrada de dados por input , fazer o prepare
        $stmt = $this->pdo->prepare($sql);

        $resultado = $stmt->execute([
            ":id"           => $id,
            ":sku"          => strtoupper((trim($dados["codigo_sku"]))),
            ":descricao"    => trim($dados["descricao"]),
            ":categoria"    => trim($dados["categoria"]),
            ":quantidade"   => (int)$dados["quantidade"],
            ":preco"        => (float)$dados["preco_unitario"]
        ]);
        return $resultado;
    }
    
    //Deletar => Excluir do Banco
    public function excluir (int $id): bool {
        $sql = "DELETE FROM pecas_industriais WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $resultado = $stmt->execute();
        return $resultado;
    }

    //buscar produtos por termo => busca textual 
    public function buscarPorTermo(string $termo):array {
        $sql = "SELECT * FROM pecas_industriais
                WHERE codigo_sku ILIKE :termo OR descricao ILIKE :termo OR categoria ILIKE :termo
                ORDER BY descricao ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([":termo" => "%" .trim($termo) . "%"]); //buscas em qualquer parte da palavra
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}