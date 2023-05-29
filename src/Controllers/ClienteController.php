<?php

require '../src/Models/Cliente.php';

class ClienteController {
    public function getClientes() {
        $clientes = new Cliente();
        $clientes->getClientes();
        return $clientes;
    }

    public function cadastrar($dados) { 
        $clientes = new Cliente();
        $clientes->createCliente($dados);
        return $clientes;
        // Flight::render('../../views/home.php'); 
    }

    public function editar($id, $dados) {
        $clientes = new Cliente();
        $clientes->editCliente($id, $dados);

        Flight::render('../../views/home.php'); 
    }
}