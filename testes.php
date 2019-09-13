<?php

require __DIR__.'/App/autoload.php';

use DB\Conexao as DB;
use App\Classes\Ator;

$ator1 = new Ator();
$ator1->setPrimeiroNome('Será atualizado');
$ator1->setUltimoNome('Atualizado com suc...');
$ator1->setUltimaAtualizacao(date('Y-m-d H:i:s'));
$ator1->setAtorId(209);

// Teste de inserção
echo $ator1->update();

// // Teste de atualização
// $data = $ator1->listAll();

// print_r($data);
