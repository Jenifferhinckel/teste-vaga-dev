<?php

class HomeController {
    
    public function index() {
        Flight::render('../../views/home.php');
    }

}