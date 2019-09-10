<?php

require __DIR__.'/App/autoload.php';

// use App\Controller\ClienteController;
// use App\Model\Cliente;

// $obj = new ClienteController();
// $obj->listar();

use DB\Conexao as DB;

$banco = DB::getInstance();

$consulta = $banco->query("SELECT * FROM cliente");

foreach($consulta as $linha) {
    echo "<pre>";
    print_r($linha);
    echo "</pre>";
}
