<?php
    namespace App\Formularios;

    require '../autoload.php';

    use App\Classes\Idioma;

    $idiomaSelecionado = null;

    if (!empty($_POST) && $_POST['acao'] == 'salvar') {
        $nome = $_POST['nome'];

        $idioma = new Idioma($nome);

        $resposta = $idioma->save();
        if ($resposta) {
            header('location: ../Listas/ListaIdioma.php');
        } else {
            echo 'Erro ao cadastrar!';
        }
    }

    if (!empty($_POST) && $_POST['acao'] == 'carregar_info') {
        $idiomaId = $_POST['idioma_id'];
        $idioma = new Idioma();
        $idioma->setIdiomaId($idiomaId);
        $idiomaSelecionado = $idioma->findById();
    }
        
    if (!empty($_POST) && $_POST['acao'] == 'atualizar') {
        $idiomaId = $_POST['idioma_id'];
        $nome = $_POST['nome'];

        $idioma = new Idioma($nome, $idiomaId);

        $resposta = $idioma->update();    
        if ($resposta) {
            header('location: ../Listas/ListaIdioma.php');
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
    <title>Formulário idioma</title>
</head>
<body>
    <form action="FormIdioma.php" method="POST">
        <h1>Idioma</h1>
        <label for="nome">Nome</label>
        <input
            id="nome"
            type="text"
            name="nome"
            value="<?php echo $idiomaSelecionado['nome'] ? $idiomaSelecionado['nome'] : ''; ?>">

        <?php if(!empty($_POST['acao']) && $_POST['acao'] == 'carregar_info') { ?>
            <input type="hidden" name="idioma_id" value="<?php echo $idiomaSelecionado['idioma_id']?>">
            <input type="hidden" name="acao" value="atualizar">
            <input type="submit" value="Atualizar">

        <?php } else { ?>
            <input type="hidden" name="acao" value="salvar">
            <input type="submit" value="Salvar">
        <?php } ?>
    </form>
</body>
</html>