<?php
    namespace App\Formularios;

    require '../autoload.php';

    use App\Classes\Funcionario;
    use App\Classes\Endereco;
    use App\Classes\Loja;

    $funcionarioSelecionado = null;

    $novoEndereco = new Endereco();
    $enderecos = $novoEndereco->listAll();

    $novoLoja = new Loja();
    $lojas = $novoLoja->listAll();

    if (!empty($_POST) && $_POST['acao'] == 'salvar') {
        $primeiroNome = $_POST['primeiro_nome'];
        $ultimoNome = $_POST['ultimo_nome'];
        $enderecoId = $_POST['endereco_id'];
        $foto = $_POST['foto'];
        $email = $_POST['email'];
        $lojaId = $_POST['loja_id'];
        $ativo = $_POST['ativo'];
        $usuario = $_POST['usuario'];
        $senha = $_POST['senha'];

        $funcionario = new Funcionario($primeiroNome, $ultimoNome, $enderecoId, $foto, $email, $lojaId, $ativo, $usuario, $senha);

        $resposta = $funcionario->save();
        if ($resposta) {
            header('location: ../Listas/ListaFuncionario.php');
        } else {
            echo 'Erro ao cadastrar!';
        }
    }

    if (!empty($_POST) && $_POST['acao'] == 'carregar_info') {
        $funcionarioId = $_POST['funcionario_id'];
        $funcionario = new Funcionario();
        $funcionario->setFuncionarioId($funcionarioId);
        $funcionarioSelecionado = $funcionario->findById();
    }
        
    if (!empty($_POST) && $_POST['acao'] == 'atualizar') {
        $funcionarioId = $_POST['funcionario_id'];
        $primeiroNome = $_POST['primeiro_nome'];
        $ultimoNome = $_POST['ultimo_nome'];
        $enderecoId = $_POST['endereco_id'];
        $foto = $_POST['foto'];
        $email = $_POST['email'];
        $lojaId = $_POST['loja_id'];
        $ativo = $_POST['ativo'];
        $usuario = $_POST['usuario'];
        $senha = $_POST['senha'];

        $funcionario = new Funcionario($primeiroNome, $ultimoNome, $enderecoId, $foto, $email, $lojaId, $ativo, $usuario, $senha, $funcionarioId);

        $resposta = $funcionario->update();    
        if ($resposta) {
            header('location: ../Listas/ListaFuncionario.php');
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
    <title>Formulário funcionario</title>
</head>
<body>
    <form action="FormFuncionario.php" method="POST">
        <label for="first_name">Primeiro Nome</label>
        <input
            id="first_name"
            type="text"
            name="primeiro_nome"
            value="<?php echo $funcionarioSelecionado['primeiro_nome'] ? $funcionarioSelecionado['primeiro_nome'] : ''; ?>">

        <label for="last_name">Ultimo Nome</label>
        <input
            id="last_name"
            type="text"
            name="ultimo_nome"
            value="<?php echo $funcionarioSelecionado['ultimo_nome'] ? $funcionarioSelecionado['ultimo_nome'] : ''; ?>">

        <!-- Endereco ID -->
        Endereco ID
        <select name="endereco_id">
            <option>Selecione</option>
            <?php foreach($enderecos as $endereco) { ?>
                <option value="<?php echo $endereco['endereco_id']?>"><?php echo $endereco['endereco']; ?></option>
            <?php } ?>
        </select>

        <label for="foto">Foto</label>
        <input
            id="foto"
            type="text"
            name="foto"
            value="<?php echo $funcionarioSelecionado['foto'] ? $funcionarioSelecionado['foto'] : ''; ?>">

        <label for="email">Email</label>
        <input
            id="email"
            type="text"
            name="email"
            value="<?php echo $funcionarioSelecionado['email'] ? $funcionarioSelecionado['email'] : ''; ?>">

        <!-- Loja Id -->
        Loja ID
        <select name="loja_id">
            <option>Selecione</option>
            <?php foreach($lojas as $loja) { ?>
                <option value="<?php echo $loja['loja_id']?>"><?php echo $loja['loja_id']; ?></option>
            <?php } ?>
        </select>

        <!-- Ativo -->
        Ativo?
        <select name="ativo">
            <option value="1">Sim</option>
            <option value="0">Não</option>
        </select>

        <label for="usuario">Usuario</label>
        <input
            id="usuario"
            type="text"
            name="usuario"
            value="<?php echo $funcionarioSelecionado['usuario'] ? $funcionarioSelecionado['usuario'] : ''; ?>">

        <label for="senha">Senha</label>
        <input
            id="senha"
            type="text"
            name="senha"
            value="<?php echo $funcionarioSelecionado['senha'] ? $funcionarioSelecionado['senha'] : ''; ?>">

        <?php if(!empty($_POST['acao']) && $_POST['acao'] == 'carregar_info') { ?>
            <input type="hidden" name="funcionario_id" value="<?php echo $funcionarioSelecionado['funcionario_id']?>">
            <input type="hidden" name="acao" value="atualizar">
            <input type="submit" value="Atualizar">

        <?php } else { ?>
            <input type="hidden" name="acao" value="salvar">
            <input type="submit" value="Salvar">
        <?php } ?>
    </form>
</body>
</html>