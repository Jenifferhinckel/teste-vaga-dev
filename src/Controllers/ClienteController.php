<?php

require '../src/Models/Cliente.php';

class ClienteController {
    public function getClientes() {
        $clientes = new Cliente();
        $dados = $clientes->getClientes();
        return $dados;
    }

    public function getClienteById($id) {
        $clientes = new Cliente();
        $dados = $clientes->getCliente($id);
        return $dados;
    }

    public function cadastrar($dados) { 
        $clientes = new Cliente();
        $clientes->createCliente($dados);

        return $clientes;
    }

    public function update($id, $dados) {
        $clientes = new Cliente();
        $clientes->updateCliente($id, $dados);

        return $clientes;
    }
}