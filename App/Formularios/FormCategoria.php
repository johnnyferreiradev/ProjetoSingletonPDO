<?php
    namespace App\Formularios;

    require '../autoload.php';

    use App\Classes\Categoria;

    $categoriaSelecionado = null;

    if (!empty($_POST) && $_POST['acao'] == 'salvar') {
        $nome = $_POST['nome'];

        $categoria = new Categoria($nome);

        $resposta = $categoria->save();
        if ($resposta) {
            header('location: ../Listas/ListaCategoria.php');
        } else {
            echo 'Erro ao cadastrar!';
        }
    }

    if (!empty($_POST) && $_POST['acao'] == 'carregar_info') {
        $categoriaId = $_POST['categoria_id'];
        $categoria = new Categoria();
        $categoria->setCategoriaId($categoriaId);
        $categoriaSelecionado = $categoria->findById();
    }
        
    if (!empty($_POST) && $_POST['acao'] == 'atualizar') {
        $categoriaId = $_POST['categoria_id'];
        $nome = $_POST['nome'];

        $categoria = new Categoria($nome, $categoriaId);

        $resposta = $categoria->update();    
        if ($resposta) {
            header('location: ../Listas/ListaCategoria.php');
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
    <title>Formulário categoria</title>
</head>
<body>
    <form action="FormCategoria.php" method="POST">
        <h1>Categoria</h1>
        <label for="nome">Nome</label>
        <input
            id="nome"
            type="text"
            name="nome"
            value="<?php echo $categoriaSelecionado['nome'] ? $categoriaSelecionado['nome'] : ''; ?>">

        <?php if(!empty($_POST['acao']) && $_POST['acao'] == 'carregar_info') { ?>
            <input type="hidden" name="categoria_id" value="<?php echo $categoriaSelecionado['categoria_id']?>">
            <input type="hidden" name="acao" value="atualizar">
            <input type="submit" value="Atualizar">

        <?php } else { ?>
            <input type="hidden" name="acao" value="salvar">
            <input type="submit" value="Salvar">
        <?php } ?>
    </form>
</body>
</html>