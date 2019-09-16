<?php
    namespace App\Formularios;

    require '../autoload.php';

    use App\Classes\Pais;

    $paisSelecionado = null;

    if (!empty($_POST) && $_POST['acao'] == 'salvar') {
        $pais = $_POST['pais'];
        $ultimaAtualizacao = $_POST['ultima_atualizacao'];

        $pais = new Pais($pais, $ultimaAtualizacao);

        $resposta = $pais->save();
        if ($resposta) {
            header('location: ../Listas/ListaPais.php');
        } else {
            echo 'Erro ao cadastrar!';
        }
    }

    if (!empty($_POST) && $_POST['acao'] == 'carregar_info') {
        $paisId = $_POST['pais_id'];
        $pais = new Pais();
        $pais->setPaisId($paisId);
        $paisSelecionado = $pais->findById();
    }
        
    if (!empty($_POST) && $_POST['acao'] == 'atualizar') {
        $paisId = $_POST['pais_id'];
        $pais = $_POST['pais'];
        $ultimaAtualizacao = $_POST['ultima_atualizacao'];

        $pais = new Pais($pais, $ultimaAtualizacao, $paisId);

        $resposta = $pais->update();    
        if ($resposta) {
            header('location: ../Listas/ListaPais.php');
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
    <title>Formulário pais</title>
</head>
<body>
    <form action="FormPais.php" method="POST">
        <label for="pais">Nome do país</label>
        <input
            id="pais"
            type="text"
            name="pais"
            value="<?php echo $paisSelecionado['pais'] ? $paisSelecionado['pais'] : ''; ?>">

        <label for="last_update">Ultima Atualização</label>
        <input
            id="last_update"
            type="text"
            name="ultima_atualizacao"
            value="<?php echo $paisSelecionado['ultima_atualizacao'] ? $paisSelecionado['ultima_atualizacao'] : ''; ?>">

        <?php if(!empty($_POST['acao']) && $_POST['acao'] == 'carregar_info') { ?>
            <input type="hidden" name="pais_id" value="<?php echo $paisSelecionado['pais_id']?>">
            <input type="hidden" name="acao" value="atualizar">
            <input type="submit" value="Atualizar">

        <?php } else { ?>
            <input type="hidden" name="acao" value="salvar">
            <input type="submit" value="Salvar">
        <?php } ?>
    </form>
</body>
</html>