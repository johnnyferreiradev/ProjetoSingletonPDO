<?php
    namespace App\Formularios;

    require '../autoload.php';

    use App\Classes\Endereco;
    use App\Classes\Cidade;

    $enderecoSelecionado = null;

    $novoCidade = new Cidade();
    $cidades = $novoCidade->listAll();

    if (!empty($_POST) && $_POST['acao'] == 'salvar') {
        $enderecoNome = $_POST['endereco'];
        $endereco2 = $_POST['endereco2'];
        $bairro = $_POST['bairro'];
        $cidadeId = $_POST['cidade_id'];
        $cep = $_POST['cep'];
        $telefone = $_POST['telefone'];

        $endereco = new Endereco($enderecoNome, $endereco2, $bairro, $cidadeId, $cep, $telefone);

        $resposta = $endereco->save();
        if ($resposta) {
            header('location: ../Listas/ListaEndereco.php');
        } else {
            echo 'Erro ao cadastrar!';
        }
    }

    if (!empty($_POST) && $_POST['acao'] == 'carregar_info') {
        $enderecoId = $_POST['endereco_id'];
        $endereco = new Endereco();
        $endereco->setEnderecoId($enderecoId);
        $enderecoSelecionado = $endereco->findById();
    }
        
    if (!empty($_POST) && $_POST['acao'] == 'atualizar') {
        $enderecoId = $_POST['endereco_id'];
        $enderecoNome = $_POST['endereco'];
        $endereco2 = $_POST['endereco2'];
        $bairro = $_POST['bairro'];
        $cidadeId = $_POST['cidade_id'];
        $cep = $_POST['cep'];
        $telefone = $_POST['telefone'];

        $endereco = new Endereco($enderecoNome, $endereco2, $bairro, $cidadeId, $cep, $telefone, $enderecoId);

        $resposta = $endereco->update();    
        if ($resposta) {
            header('location: ../Listas/ListaEndereco.php');
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
    <title>Formulário endereço</title>
</head>
<body>
    <form action="FormEndereco.php" method="POST">
        <h1>Endereço</h1>
        <label for="endereco">Endereco</label>
        <input
            id="endereco"
            type="text"
            name="endereco"
            value="<?php echo $enderecoSelecionado['endereco'] ? $enderecoSelecionado['endereco'] : ''; ?>">

        <label for="endereco2">Endereço 2</label>
        <input
            id="endereco2"
            type="text"
            name="endereco2"
            value="<?php echo $enderecoSelecionado['endereco2'] ? $enderecoSelecionado['endereco2'] : ''; ?>">
        
        <label for="bairro">Bairro</label>
        <input
            id="bairro"
            type="text"
            name="bairro"
            value="<?php echo $enderecoSelecionado['bairro'] ? $enderecoSelecionado['bairro'] : ''; ?>">

        <!-- Endereco ID -->
        Cidade
        <select name="cidade_id">
            <option>Selecione</option>
            <?php foreach($cidades as $cidade) { ?>
                <option value="<?php echo $cidade['cidade_id']?>"><?php echo $cidade['cidade']; ?></option>
            <?php } ?>
        </select>

        <label for="cep">CEP</label>
        <input
            id="cep"
            type="text"
            name="cep"
            value="<?php echo $enderecoSelecionado['cep'] ? $enderecoSelecionado['cep'] : ''; ?>">

        <label for="telefone">Telefone</label>
        <input
            id="telefone"
            type="text"
            name="telefone"
            value="<?php echo $enderecoSelecionado['telefone'] ? $enderecoSelecionado['telefone'] : ''; ?>">

        <?php if(!empty($_POST['acao']) && $_POST['acao'] == 'carregar_info') { ?>
            <input type="hidden" name="endereco_id" value="<?php echo $enderecoSelecionado['endereco_id']?>">
            <input type="hidden" name="acao" value="atualizar">
            <input type="submit" value="Atualizar">

        <?php } else { ?>
            <input type="hidden" name="acao" value="salvar">
            <input type="submit" value="Salvar">
        <?php } ?>
    </form>
</body>
</html>