<?php
    namespace App\Formularios;

    require '../autoload.php';

    use App\Classes\Aluguel;
    use App\Classes\Inventario;
    use App\Classes\Cliente;
    use App\Classes\Funcionario;

    $aluguelSelecionado = null;

    $novoInventario = new Inventario();
    $inventarios = $novoInventario->listAll();

    $novoCliente = new Cliente();
    $clientes = $novoCliente->listAll();

    $novoFuncionario = new Funcionario();
    $funcionarios = $novoFuncionario->listAll();

    if (!empty($_POST) && $_POST['acao'] == 'salvar') {
        $dataAluguel = $_POST['data_de_aluguel'];
        $inventarioId = $_POST['inventario_id'];
        $clienteId = $_POST['cliente_id'];
        $dataDevolucao = $_POST['data_de_devolucao'];
        $funcionarioId = $_POST['funcionario_id'];

        $aluguel = new Aluguel($dataAluguel, $inventarioId, $clienteId, $dataDevolucao, $funcionarioId);

        $resposta = $aluguel->save();
        if ($resposta) {
            header('location: ../Listas/ListaAluguel.php');
        } else {
            echo 'Erro ao cadastrar!';
        }
    }

    if (!empty($_POST) && $_POST['acao'] == 'carregar_info') {
        $aluguelId = $_POST['aluguel_id'];
        $aluguel = new Aluguel();
        $aluguel->setAluguelId($aluguelId);
        $aluguelSelecionado = $aluguel->findById();
    }
        
    if (!empty($_POST) && $_POST['acao'] == 'atualizar') {
        $aluguelId = $_POST['aluguel_id'];
        $dataAluguel = $_POST['data_de_aluguel'];
        $inventarioId = $_POST['inventario_id'];
        $clienteId = $_POST['cliente_id'];
        $dataDevolucao = $_POST['data_de_devolucao'];
        $funcionarioId = $_POST['funcionario_id'];

        $aluguel = new Aluguel($dataAluguel, $inventarioId, $clienteId, $dataDevolucao, $funcionarioId, $aluguelId);

        $resposta = $aluguel->update();    
        if ($resposta) {
            header('location: ../Listas/ListaAluguel.php');
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
    <title>Formulário aluguel</title>
</head>
<body>
    <form action="FormAluguel.php" method="POST">
        <label for="data_de_aluguel">Data de aluguel</label>
        <input
            id="data_de_aluguel"
            type="text"
            name="data_de_aluguel"
            value="<?php echo $aluguelSelecionado['data_de_aluguel'] ? $aluguelSelecionado['data_de_aluguel'] : ''; ?>">

        <!-- Inventario ID -->
        Inventario
        <select name="inventario_id">
            <option>Selecione</option>
            <?php foreach($inventarios as $inventario) { ?>
                <option value="<?php echo $inventario['inventario_id']?>"><?php echo $inventario['inventario_id']; ?></option>
            <?php } ?>
        </select>

        <!-- Cliente ID -->
        Cliente
        <select name="cliente_id">
            <option>Selecione</option>
            <?php foreach($clientes as $cliente) { ?>
                <option value="<?php echo $cliente['cliente_id']?>"><?php echo $cliente['cliente_id']." - ".$cliente['primeiro_nome']." ".$cliente['ultimo_nome']; ?></option>
            <?php } ?>
        </select>

        <label for="data_de_devolucao">Data de devolução</label>
        <input
            id="data_de_devolucao"
            type="text"
            name="data_de_devolucao"
            value="<?php echo $aluguelSelecionado['data_de_devolucao'] ? $aluguelSelecionado['data_de_devolucao'] : ''; ?>">

        <!-- Funcionario ID -->
        Funcionario
        <select name="funcionario_id">
            <option>Selecione</option>
            <?php foreach($funcionarios as $funcionario) { ?>
                <option value="<?php echo $funcionario['funcionario_id']?>"><?php echo $funcionario['funcionario_id']." - ".$funcionario['primeiro_nome']." ".$funcionario['ultimo_nome']; ?></option>
            <?php } ?>
        </select>

        <?php if(!empty($_POST['acao']) && $_POST['acao'] == 'carregar_info') { ?>
            <input type="hidden" name="aluguel_id" value="<?php echo $aluguelSelecionado['aluguel_id']?>">
            <input type="hidden" name="acao" value="atualizar">
            <input type="submit" value="Atualizar">

        <?php } else { ?>
            <input type="hidden" name="acao" value="salvar">
            <input type="submit" value="Salvar">
        <?php } ?>
    </form>
</body>
</html>