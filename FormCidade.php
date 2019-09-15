<?php
    require __DIR__.'/App/autoload.php';

    use App\Classes\Cidade;
    use App\Classes\Pais;

    $cidadeSelecionada = null;
    $novoPais = new Pais();
    $paises = $novoPais->listAll();

    if (!empty($_POST) && $_POST['acao'] == 'salvar') {
        $cidadeNome = $_POST['cidade'];
        $paisId = $_POST['pais_id'];
        $ultimaAtualizacao = $_POST['ultima_atualizacao'];

        $cidade = new Cidade($paisId, $cidadeNome, $ultimaAtualizacao);

        $resposta = $cidade->save();
        if ($resposta) {
            header('location: ListaCidade.php');
        } else {
            echo 'Erro ao cadastrar!';
        }
    }

    if (!empty($_POST) && $_POST['acao'] == 'carregar_info') {
        $cidadeId = $_POST['cidade_id'];
        $cidade = new Cidade();
        $cidade->setCidadeId($cidadeId);
        $cidadeSelecionada = $cidade->findById();
    }
        
    if (!empty($_POST) && $_POST['acao'] == 'atualizar') {
        $cidadeId = $_POST['cidade_id'];
        $cidadeNome = $_POST['cidade'];
        $paisId = $_POST['pais_id'];
        $ultimaAtualizacao = $_POST['ultima_atualizacao'];

        $cidade = new Cidade($paisId, $cidadeNome, $ultimaAtualizacao, $cidadeId);

        $resposta = $cidade->update();    
        if ($resposta) {
            header('location: ListaCidade.php');
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
    <title>Formulário cidade</title>
</head>
<body>
    <form action="FormCidade.php" method="POST">
        <label for="cidade">Nome da Cidade</label>
        <input
            id="cidade"
            type="text"
            name="cidade"
            value="<?php echo $cidadeSelecionada['cidade'] ? $cidadeSelecionada['cidade'] : ''; ?>">

        Pais
        <select name="pais_id">
            <option>Selecione</option>
            <?php foreach($paises as $pais) { ?>
                <option value="<?php echo $pais['pais_id']?>"><?php echo $pais['pais']; ?></option>
            <?php } ?>
        </select>

        <label for="last_update">Ultima Atualização</label>
        <input
            id="last_update"
            type="text"
            name="ultima_atualizacao"
            value="<?php echo $cidadeSelecionada['ultima_atualizacao'] ? $cidadeSelecionada['ultima_atualizacao'] : ''; ?>">

        <?php if(!empty($_POST['acao']) && $_POST['acao'] == 'carregar_info') { ?>
            <input type="hidden" name="cidade_id" value="<?php echo $cidadeSelecionada['cidade_id']?>">
            <input type="hidden" name="acao" value="atualizar">
            <input type="submit" value="Atualizar">

        <?php } else { ?>
            <input type="hidden" name="acao" value="salvar">
            <input type="submit" value="Salvar">
        <?php } ?>
    </form>
</body>
</html>