<?php


namespace App\Controller;

use App\Model\Cliente;

class ClienteController
{
    public function listar() {
        $cliente = new Cliente();
        $clientes = $cliente->listAll();

        $_REQUEST['clientes'] = $clientes;

        require_once '../View/Cliente/ListAll.php';
    }
}