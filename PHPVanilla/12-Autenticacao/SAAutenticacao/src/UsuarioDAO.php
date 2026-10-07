<?php
declare(strict_types=1);

//Criação da Classe de Acesso aos Dados da TAbela Usuários

final class UsuarioDAO{
    //atributos
    private PDO $pdo; // pegar as informações da conexão com o Banco de dados

    //construtor
    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    //métodos de manipulação de dados (CRUD)
    //Create -> Cadastrar
    public function cadastrar(string $nome, string $email, string $senha, string $perfil = "OPERADOR"):bool{
        $sql="INSERT INTO usuarios(nome, email, senha_hash, perfil)
              VALUES(:nome, :email, :hash, :perfil)";
        $stmt = $this->pdo->prepare($sql);

        //hash da senha
        $hash = password_hash($senha, PASSWORD_ARGON2ID);

        return $stmt->execute([
            ":nome"     => trim($nome),
            ":email"    => strtolower(trim($email)),
            ":hash"     => $hash,
            ":perfil"   => $perfil
        ]);
    }

    // buscar dados do usuário pelo email
    public function buscarPorEmail(string $email): ?array{
        $sql="SELECT * FROM usuarios WHERE email = :email AND ativo = TRUE";
        $stmt= $this->pdo->prepare($sql);
        $stmt->bindValue(":email", strtolower(trim($email)), PDO::PARAM_STR);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado ?: null;
    }

}