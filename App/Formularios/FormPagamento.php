<?php
    namespace App\Formularios;

    require '../autoload.php';

    use App\Classes\Pagamento;
    use App\Classes\Cliente;
    use App\Classes\Funcionario;
    use App\Classes\Aluguel;

    $pagamentoSelecionado = null;

    $novoCliente = new Cliente();
    $clientes = $novoCliente->listAll();

    $novoFuncionario = new Funcionario();
    $funcionarios = $novoFuncionario->listAll();

    $novoAluguel = new Aluguel();
    $alugueis = $novoAluguel->listAll();

    if (!empty($_POST) && $_POST['acao'] == 'salvar') {
        $clienteId = $_POST['cliente_id'];
        $funcionarioId = $_POST['funcionario_id'];
        $aluguelId = $_POST['aluguel_id'];
        $valor = $_POST['valor'];
        $dataPagamento = $_POST['data_de_pagamento'];

        $pagamento = new Pagamento($clienteId, $funcionarioId, $aluguelId, $valor, $dataPagamento);

        $resposta = $pagamento->save();
        if ($resposta) {
            header('location: ../Listas/ListaPagamento.php');
        } else {
            echo 'Erro ao cadastrar!';
        }
    }

    if (!empty($_POST) && $_POST['acao'] == 'carregar_info') {
        $pagamentoId = $_POST['pagamento_id'];
        $pagamento = new Pagamento();
        $pagamento->setPagamentoId($pagamentoId);
        $pagamentoSelecionado = $pagamento->findById();
    }
        
    if (!empty($_POST) && $_POST['acao'] == 'atualizar') {
        $pagamentoId = $_POST['pagamento_id'];
        $clienteId = $_POST['cliente_id'];
        $funcionarioId = $_POST['funcionario_id'];
        $aluguelId = $_POST['aluguel_id'];
        $valor = $_POST['valor'];
        $dataPagamento = $_POST['data_de_pagamento'];

        $pagamento = new Pagamento($clienteId, $funcionarioId, $aluguelId, $valor, $dataPagamento, $pagamentoId);

        $resposta = $pagamento->update();    
        if ($resposta) {
            header('location: ../Listas/ListaPagamento.php');
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
    <title>Formulário pagamento</title>
</head>
<body>
    <form action="FormPagamento.php" method="POST">
        <!-- Cliente ID -->
        Cliente
        <select name="cliente_id">
            <option>Selecione</option>
            <?php foreach($clientes as $cliente) { ?>
                <option value="<?php echo $cliente['cliente_id']?>"><?php echo $cliente['cliente_id']." - ".$cliente['primeiro_nome']." ".$cliente['ultimo_nome']; ?></option>
            <?php } ?>
        </select>

        <!-- Cliente ID -->
        Funcionario
        <select name="funcionario_id">
            <option>Selecione</option>
            <?php foreach($funcionarios as $funcionario) { ?>
                <option value="<?php echo $funcionario['funcionario_id']?>"><?php echo $funcionario['funcionario_id']." - ".$funcionario['primeiro_nome']." ".$funcionario['ultimo_nome']; ?></option>
            <?php } ?>
        </select>

        <!-- Cliente ID -->
        Aluguel ID
        <select name="aluguel_id">
            <option>Selecione</option>
            <?php foreach($alugueis as $aluguel) { ?>
                <option value="<?php echo $aluguel['aluguel_id']?>"><?php echo $aluguel['aluguel_id']; ?></option>
            <?php } ?>
        </select>

        <label for="valor">Valor</label>
        <input
            id="valor"
            type="text"
            name="valor"
            value="<?php echo $pagamentoSelecionado['valor'] ? $pagamentoSelecionado['valor'] : ''; ?>">
        
        <label for="data_de_pagamento">Data de pagamento</label>
        <input
            id="data_de_pagamento"
            type="text"
            name="data_de_pagamento"
            value="<?php echo $pagamentoSelecionado['data_de_pagamento'] ? $pagamentoSelecionado['data_de_pagamento'] : ''; ?>">

        <?php if(!empty($_POST['acao']) && $_POST['acao'] == 'carregar_info') { ?>
            <input type="hidden" name="pagamento_id" value="<?php echo $pagamentoSelecionado['pagamento_id']?>">
            <input type="hidden" name="acao" value="atualizar">
            <input type="submit" value="Atualizar">

        <?php } else { ?>
            <input type="hidden" name="acao" value="salvar">
            <input type="submit" value="Salvar">
        <?php } ?>
    </form>
</body>
</html>