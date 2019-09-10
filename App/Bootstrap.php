<?php


namespace App;

use App\Controller\ClienteController;

class Bootstrap  {

    private $obj;

    function __construct($classe, $metodo){
        $this->obj = new ClienteController();
        $this->obj->$metodo();
    }
}