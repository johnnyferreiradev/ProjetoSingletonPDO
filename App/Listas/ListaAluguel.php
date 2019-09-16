<?php
    namespace App\Listas;

    require '../autoload.php';

    use App\Classes\Aluguel;

    // Lógica da paginação
    $dados = Aluguel::listAll();
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

    $aluguel = new Aluguel();
    $dadosPaginados = $aluguel->paginate($inicio, $limite);

    if(!empty($_GET)) {
        
        if($_GET['acao'] == 'excluir') {
            $aluguelId = $_GET['aluguel_id'];
            $aluguel = new Aluguel();
            $aluguel->setAluguelId($aluguelId);
            $encontrado = $aluguel->findById();

            $resultado = null;
            if ($encontrado) {
                $resultado = $aluguel->remove();
                header("location: ListaAluguel.php?acao=&pagina=$pagina");
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
    <link rel="stylesheet" type="text/css" href="../Assets/css/general.css">
    <link rel="stylesheet" type="text/css" href="../Assets/css/table.css">
    <script src="https://kit.fontawesome.com/2a2ac02fa4.js"></script>
    <title>Lista de alugueis</title>
</head>
<body>
    <h1 class="list-title">Lista de alugueis cadastrados</h1>
    <div class="container-table">
        <a class="btn-new" href="../Formularios/FormAluguel.php"><i class="fas fa-plus-circle"></i> Novo registro</a>
        <table class="list-table">
            <tr class="row-titles">
                <th>ID</th>
                <th>Data de Aluguel</th>
                <th>Inventario ID</th>
                <th>Cliente ID</th>
                <th>Data de devolução</th>
                <th>Funcionario ID</th>
                <th>Ultima atualização</th>
                <th>Ações</th>
            </tr>
            <?php foreach($dadosPaginados as $aluguel) { ?>
                <tr class="row-results">
                    <td><?php echo $aluguel['aluguel_id']?></td>
                    <td><?php echo $aluguel['data_de_aluguel']?></td>
                    <td><?php echo $aluguel['inventario_id']?></td>
                    <td><?php echo $aluguel['cliente_id']?></td>
                    <td><?php echo $aluguel['data_de_devolucao']?></td>
                    <td><?php echo $aluguel['funcionario_id']?></td>
                    <td><?php echo $aluguel['ultima_atualizacao']?></td>
                    <td>
                        <form action="../Formularios/FormAluguel.php" method="POST">
                            <input type="hidden" name="aluguel_id" value="<?php echo $aluguel['aluguel_id']?>">
                            <input type="hidden" name="acao" value="carregar_info">
                            <button type="submit" class="btn-edit">Editar</button>
                        </form>

                        <button onclick="confirmarExclusao(<?php echo $aluguel['aluguel_id']; ?>, <?php echo $pagina; ?>)" class="btn-remove">Excluir</button>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <a href="ListaAluguel.php?acao=&pagina=<?php echo $anterior; ?>" class="btn-previus">Anterior</a>
        <a href="ListaAluguel.php?acao=&pagina=<?php echo $proxima; ?>" class="btn-next">Proxima</a>
    </div>

    <script language="Javascript">
        function confirmarExclusao(id, pagina) {
            let resposta = confirm('ATENÇÃO! Todos os dados do elemento selecionado serão removidos!\nDeseja realmente excluir?');
            if (resposta) {
                window.location.href = `ListaAluguel.php?aluguel_id=${id}&acao=excluir&pagina=${pagina}`;
            }
        }
    </script>
</body>
</html>