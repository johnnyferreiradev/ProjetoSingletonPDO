<?php

require __DIR__.'/App/autoload.php';

use DB\Conexao as DB;
use App\Classes\Ator;

$ator1 = new Ator();
$ator1->setPrimeiroNome('Será deletado');
$ator1->setUltimoNome('1');
$ator1->setUltimaAtualizacao(date('Y-m-d H:i:s'));

// Teste de inserção
//echo $ator1->save();

// Teste de atualização
$ator1->setAtorId(201);
$data = $ator1->listAll();

print_r($data);
