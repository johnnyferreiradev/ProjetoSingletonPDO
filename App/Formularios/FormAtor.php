<?php
    namespace App\Formularios;

    require '../autoload.php';

    use App\Classes\Ator;

    $atorSelecionado = null;

    if (!empty($_POST) && $_POST['acao'] == 'salvar') {
        $primeiroNome = $_POST['primeiro_nome'];
        $ultimoNome = $_POST['ultimo_nome'];

        $ator = new Ator($primeiroNome, $ultimoNome);

        $resposta = $ator->save();
        if ($resposta) {
            header('location: ../Listas/ListaAtor.php');
        } else {
            echo 'Erro ao cadastrar!';
        }
    }

    if (!empty($_POST) && $_POST['acao'] == 'carregar_info') {
        $atorId = $_POST['ator_id'];
        $ator = new Ator();
        $ator->setAtorId($atorId);
        $atorSelecionado = $ator->findById();
    }
        
    if (!empty($_POST) && $_POST['acao'] == 'atualizar') {
        $atorId = $_POST['ator_id'];
        $primeiroNome = $_POST['primeiro_nome'];
        $ultimoNome = $_POST['ultimo_nome'];

        $ator = new Ator($primeiroNome, $ultimoNome, $atorId);

        $resposta = $ator->update();    
        if ($resposta) {
            header('location: ../Listas/ListaAtor.php');
        } else {
            echo 'Erro ao atualizar!';
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="../Assets/css/general.css">
    <link rel="stylesheet" type="text/css" href="../Assets/css/forms.css">
    <title>Formulário ator</title>
</head>
<body>
    <form action="FormAtor.php" method="POST">
        <h1>Ator</h1>
        <label for="first_name">Primeiro Nome</label>
        <input
            id="first_name"
            type="text"
            name="primeiro_nome"
            value="<?php echo $atorSelecionado['primeiro_nome'] ? $atorSelecionado['primeiro_nome'] : ''; ?>">

        <label for="last_name">Ultimo Nome</label>
        <input
            id="last_name"
            type="text"
            name="ultimo_nome"
            value="<?php echo $atorSelecionado['ultimo_nome'] ? $atorSelecionado['ultimo_nome'] : ''; ?>">

        <?php if(!empty($_POST['acao']) && $_POST['acao'] == 'carregar_info') { ?>
            <input type="hidden" name="ator_id" value="<?php echo $atorSelecionado['ator_id']?>">
            <input type="hidden" name="acao" value="atualizar">
            <input type="submit" value="Atualizar">

        <?php } else { ?>
            <input type="hidden" name="acao" value="salvar">
            <input type="submit" value="Salvar">
        <?php } ?>
    </form>
</body>
</html>