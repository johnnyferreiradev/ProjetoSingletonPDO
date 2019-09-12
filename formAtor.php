<?php
    require __DIR__.'/App/autoload.php';

    use App\Classes\Ator;

    if (!empty($_GET)) {
        $primeiroNome = $_GET['primeiro_nome'];
        $ultimoNome = $_GET['ultimo_nome'];
        $ultimaAtualizacao = $_GET['ultima_atualizacao'];

        $ator = new Ator();
        $ator->setPrimeiroNome($primeiroNome);
        $ator->setUltimoNome($ultimoNome);
        $ator->setUltimaAtualizacao($ultimaAtualizacao);

        $resposta = $ator->save();

        if ($resposta) {
            header('location: ListaAtor.php');
        } else {
            echo 'Erro ao cadastrar!';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Formulário ator</title>
</head>
<body>
    <form action="formAtor.php" method="GET">
        <label for="first_name">Primeiro Nome</label>
        <input id="first_name" type="text" name="primeiro_nome">

        <label for="last_name">Ultimo Nome</label>
        <input id="last_name" type="text" name="ultimo_nome">

        <label for="last_update">Ultima Atualização</label>
        <input id="last_update" type="text" name="ultima_atualizacao">

        <input type="submit" value="Salvar">
    </form>
</body>
</html>