<?php

require __DIR__.'/App/autoload.php';

use DB\Conexao as DB;
use App\Classes\Ator;

$ator1 = new Ator();
$ator1->setPrimeiroNome('John');
$ator1->setUltimoNome('Doe 1');
$ator1->setUltimaAtualizacao(date('Y-m-d H:i:s'));

echo $ator1->save();

// $ator = Ator::atorTeste();
// $banco = DB::getInstance();

// $consulta = $banco->query("SELECT * FROM cliente");

// foreach($consulta as $linha) {
//     echo "<pre>";
//     print_r($linha);
//     echo "</pre>";
// }
