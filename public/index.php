<?php
require '../vendor/flight/Flight.php';
require '../src/Controllers/HomeController.php';
require '../src/Controllers/ClienteController.php';

Flight::route('GET /', function () {
    $controller = new HomeController();
    $controller->index();
});

Flight::route('GET /estados', function () {
    $url = 'https://brasilapi.com.br/api/ibge/uf/v1';

    $estados = file_get_contents($url);

    Flight::json($estados);
});

Flight::route('GET /cidades/@estado', function ($estado) {
    $url = 'https://brasilapi.com.br/api/ibge/municipios/v1/'. $estado;

    $cidades = file_get_contents($url);

    Flight::json($cidades);
});

Flight::route('GET /clientes', function () {
    $controller = new ClienteController();
    $clientes = $controller->getClientes();
    Flight::json($clientes);
});

Flight::route('POST /cadastrar', function () {
    $controller = new ClienteController();
    $controller->cadastrar($_POST); 
    
    Flight::redirect('/');
});

Flight::route('/edit/@id', function ($id) {
    $controller = new ClienteController();
    $cliente = $controller->getClienteById($id);

    Flight::render('../../views/edit.php', ['cliente' => $cliente]);
});

Flight::route('POST /update/@id', function ($id) {
    $controller = new ClienteController();
    $controller->update($id, $_POST);

    Flight::redirect('/');
});



Flight::start();