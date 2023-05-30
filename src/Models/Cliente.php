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
        $sql = "SELECT * FROM clientes";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        return $result;
    }

    public function getCliente($id) {
        $sql = "SELECT * FROM clientes WHERE id =". $id;
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        return $result;
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

    public function updateCliente($id, $dados) {
        $consulta = $this->db->prepare("UPDATE clientes SET cnpj = :cnpj, nome_empresa = :nome_empresa, cep = :cep, endereco = :endereco, numero = :numero, bairro = :bairro, uf = :uf,
        cidade = :cidade WHERE id =". $id);
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
}