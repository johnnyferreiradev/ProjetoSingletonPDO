<?php
    namespace App\Listas;

    require '../autoload.php';

    use App\Classes\Pagamento;

    // Lógica da paginação
    $dados = Pagamento::listAll();
    $limite = 10;
    $qtdDados = count($dados);
    $qtdPaginas = ceil($qtdDados / $limite);
    $pagina = !empty($_GET['pagina']) ? $_GET['pagina'] : 1;
    $inicio = ($pagina - 1) * $limite;

    if($pagina == 1) {
        $anterior = 1;    
    } else {
        $anterior = $pagina - 1;
    }

    if($pagina == $qtdPaginas) {
        $proxima = $qtdPaginas;    
    } else {
        $proxima = $pagina + 1;
    }

    $pagamento = new Pagamento();
    $dadosPaginados = $pagamento->paginate($inicio, $limite);

    if(!empty($_GET)) {
        
        if($_GET['acao'] == 'excluir') {
            $pagamentoId = $_GET['pagamento_id'];
            $pagamento = new Pagamento();
            $pagamento->setPagamentoId($pagamentoId);
            $encontrado = $pagamento->findById();

            $resultado = null;
            if ($encontrado) {
                $resultado = $pagamento->remove();
                header("location: ListaPagamento.php?acao=&pagina=$pagina");
            } else {
                echo "Usuário não encontrado!";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lista de pagamentos</title>
    <style>
        table {
            width: 100%;
        }

        table th {
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <h1 class="list-title">Lista de pagamentos cadastrados</h1>
    <a class="btn-new" href="../Formularios/FormPagamento.php">Novo registro</a>
    <table class="list-table">
        <tr class="row-titles">
            <th>ID</th>
            <th>Cliente ID</th>
            <th>Funcionario ID</th>
            <th>Aluguel ID</th>
            <th>Valor</th>
            <th>Data de pagamento</th>
            <th>Ultima atualização</th>
            <th>Ações</th>
        </tr>
        <?php foreach($dadosPaginados as $pagamento) { ?>
            <tr class="row-results">
                <td><?php echo $pagamento['pagamento_id']?></td>
                <td><?php echo $pagamento['cliente_id']?></td>
                <td><?php echo $pagamento['funcionario_id']?></td>
                <td><?php echo $pagamento['aluguel_id']?></td>
                <td><?php echo $pagamento['valor']?></td>
                <td><?php echo $pagamento['data_de_pagamento']?></td>
                <td><?php echo $pagamento['ultima_atualizacao']?></td>
                <td>
                    <form action="../Formularios/FormPagamento.php" method="POST">
                        <input type="hidden" name="pagamento_id" value="<?php echo $pagamento['pagamento_id']?>">
                        <input type="hidden" name="acao" value="carregar_info">
                        <button type="submit" class="btn-edit">Editar</button>
                    </form>

                    <button onclick="confirmarExclusao(<?php echo $pagamento['pagamento_id']; ?>, <?php echo $pagina; ?>)" class="btn-remove">Excluir</button>
                </td>
            </tr>
        <?php } ?>
    </table>

    <a href="ListaPagamento.php?acao=&pagina=<?php echo $anterior; ?>" class="btn-previus">Anterior</a>
    <a href="ListaPagamento.php?acao=&pagina=<?php echo $proxima; ?>" class="btn-next">Proxima</a>

    <script language="Javascript">
        function confirmarExclusao(id, pagina) {
            let resposta = confirm('ATENÇÃO! Todos os dados do elemento selecionado serão removidos!\nDeseja realmente excluir?');
            if (resposta) {
                window.location.href = `ListaPagamento.php?pagamento_id=${id}&acao=excluir&pagina=${pagina}`;
            }
        }
    </script>
</body>
</html>