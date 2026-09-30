<?php
declare(strict_types=1);

//Camada de Acesso a Dados (DAO) para Almoxarifado
//essa Camada é uma Classe - usa Paradigma de Programação Orientada ao Objeto

final class AlmoxarifadoDAO{
    //atributos -> as caracteristicas do objeto
    private PDO $pdo;

    // métodos -> ações
    //método que toda classe tem -> Construtor -> permite instanciar objetos
    public function __constructor(PDO $pdo){
        $this->pdo = $pdo;
    }

    // métodos do CRUD

}