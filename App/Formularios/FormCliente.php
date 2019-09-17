<?php
    namespace App\Formularios;

    require '../autoload.php';

    use App\Classes\Cliente;
    use App\Classes\Endereco;
    use App\Classes\Loja;

    $clienteSelecionado = null;

    $novoEndereco = new Endereco();
    $enderecos = $novoEndereco->listAll();

    $novoLoja = new Loja();
    $lojas = $novoLoja->listAll();

    if (!empty($_POST) && $_POST['acao'] == 'salvar') {
        $lojaId = $_POST['loja_id'];
        $primeiroNome = $_POST['primeiro_nome'];
        $ultimoNome = $_POST['ultimo_nome'];
        $email = $_POST['email'];
        $enderecoId = $_POST['endereco_id'];
        $ativo = $_POST['ativo'];
        $dataCriacao = $_POST['data_criacao'];

        $cliente = new Cliente($lojaId, $primeiroNome, $ultimoNome, $email, $enderecoId, $ativo, $dataCriacao);

        $resposta = $cliente->save();
        if ($resposta) {
            header('location: ../Listas/ListaCliente.php');
        } else {
            echo 'Erro ao cadastrar!';
        }
    }

    if (!empty($_POST) && $_POST['acao'] == 'carregar_info') {
        $clienteId = $_POST['cliente_id'];
        $cliente = new Cliente();
        $cliente->setClienteId($clienteId);
        $clienteSelecionado = $cliente->findById();
    }
        
    if (!empty($_POST) && $_POST['acao'] == 'atualizar') {
        $clienteId = $_POST['cliente_id'];
        $lojaId = $_POST['loja_id'];
        $primeiroNome = $_POST['primeiro_nome'];
        $ultimoNome = $_POST['ultimo_nome'];
        $email = $_POST['email'];
        $enderecoId = $_POST['endereco_id'];
        $ativo = $_POST['ativo'];
        $dataCriacao = $_POST['data_criacao'];

        $cliente = new Cliente($lojaId, $primeiroNome, $ultimoNome, $email, $enderecoId, $ativo, $dataCriacao, $clienteId);

        $resposta = $cliente->update();    
        if ($resposta) {
            header('location: ../Listas/ListaCliente.php');
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
    <title>Formulário cliente</title>
</head>
<body>
    <form action="FormCliente.php" method="POST">
        <h1>Cliente</h1>
        <!-- Loja Id -->
        Loja ID
        <select name="loja_id">
            <option>Selecione</option>
            <?php foreach($lojas as $loja) { ?>
                <option value="<?php echo $loja['loja_id']?>"><?php echo $loja['loja_id']; ?></option>
            <?php } ?>
        </select>

        <label for="first_name">Primeiro Nome</label>
        <input
            id="first_name"
            type="text"
            name="primeiro_nome"
            value="<?php echo $clienteSelecionado['primeiro_nome'] ? $clienteSelecionado['primeiro_nome'] : ''; ?>">

        <label for="last_name">Ultimo Nome</label>
        <input
            id="last_name"
            type="text"
            name="ultimo_nome"
            value="<?php echo $clienteSelecionado['ultimo_nome'] ? $clienteSelecionado['ultimo_nome'] : ''; ?>">
        
        <label for="email">Email</label>
        <input
            id="email"
            type="text"
            name="email"
            value="<?php echo $clienteSelecionado['email'] ? $clienteSelecionado['email'] : ''; ?>">

        <!-- Endereco ID -->
        Endereco ID
        <select name="endereco_id">
            <option>Selecione</option>
            <?php foreach($enderecos as $endereco) { ?>
                <option value="<?php echo $endereco['endereco_id']?>"><?php echo $endereco['endereco']; ?></option>
            <?php } ?>
        </select>

        <!-- Ativo -->
        Ativo?
        <select name="ativo">
            <option value="1">Sim</option>
            <option value="0">Não</option>
        </select>

        <label for="data_criacao">Data de criação</label>
        <input
            id="data_criacao"
            type="text"
            name="data_criacao"
            value="<?php echo $clienteSelecionado['data_criacao'] ? $clienteSelecionado['data_criacao'] : ''; ?>">

        <?php if(!empty($_POST['acao']) && $_POST['acao'] == 'carregar_info') { ?>
            <input type="hidden" name="cliente_id" value="<?php echo $clienteSelecionado['cliente_id']?>">
            <input type="hidden" name="acao" value="atualizar">
            <input type="submit" value="Atualizar">

        <?php } else { ?>
            <input type="hidden" name="acao" value="salvar">
            <input type="submit" value="Salvar">
        <?php } ?>
    </form>
</body>
</html>