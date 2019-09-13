<?php

require __DIR__.'/App/autoload.php';

use DB\Conexao as DB;
use App\Classes\Ator;
use App\Classes\Pais;

// $ator1 = new Ator();
// $ator1->setPrimeiroNome('Será atualizado');
// $ator1->setUltimoNome('Atualizado com suc...');
// $ator1->setUltimaAtualizacao(date('Y-m-d H:i:s'));
// $ator1->setAtorId(209);

// // Teste de inserção
// echo $ator1->update();

// // Teste de atualização
// $data = $ator1->listAll();

// print_r($data);

// Testes da classe Pais
$pais = new Pais('Brazil1', date('Y-m-d H:i:s'), 110);
//$pais->save(); // OK


$pais->setPais('Brazil2');
//$pais->setPaisId(110);
$pais->update(); // Ok


