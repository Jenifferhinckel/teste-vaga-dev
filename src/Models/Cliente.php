<?php
require '../public/config.php';

class Cliente 
{
    protected $db;
    protected $table = "";

    public function __construct() {
        $this->db = new \PDO("mysql:dbname=".DB_DATABASE.";host=".DB_HOST,DB_USERNAME,DB_PASSWORD);
    }

    public function getClientes() {
        $consulta = $this->db->prepare("SELECT * FROM clientes");
        $consulta->execute();
        $dados = $consulta->fetchAll(\PDO::FETCH_ASSOC);
        var_dump($dados);
        return $dados;
    }

    public function createCliente($dados) {
        $consulta = $this->db->prepare("INSERT INTO clientes (cnpj, nome_empresa, cep, endereco, numero, bairro, uf, cidade) VALUES (:cnpj, :nome_empresa, :cep,
        :endereco, :numero, :bairro, :uf, :cidade)");
        $consulta->bindParam(':cnpj', $dados['cnpj']);
        $consulta->bindParam(':nome_empresa', $dados['nome_empresa']);
        $consulta->bindParam(':cep', $dados['cep']);
        $consulta->bindParam(':endereco', $dados['endereco']);
        $consulta->bindParam(':numero', $dados['numero']);
        $consulta->bindParam(':bairro', $dados['bairro']);
        $consulta->bindParam(':uf', $dados['uf']);
        $consulta->bindParam(':cidade', $dados['cidade']);
        
        $consulta->execute();
        
        if($consulta->rowCount() > 0) { 
            return true;
        }

        return false;
    }

    public function editCliente($dados) {
        $sql = "SELECT * FROM clientes";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($sqlParams);
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        if(count($result) > 0)
            return true;

        return false;
    }
}