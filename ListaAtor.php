<?php
    require __DIR__.'/App/autoload.php';

    use App\Classes\Ator;

    // Lógica da paginação
    $dados = Ator::listAll();
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

    $ator = new Ator();
    $dadosPaginados = $ator->paginate($inicio, $limite);

    if(!empty($_GET)) {
        
        if($_GET['acao'] == 'excluir') {
            $atorId = $_GET['ator_id'];
            $ator = new Ator();
            $ator->setAtorId($atorId);
            $encontrado = $ator->findById();

            $resultado = null;
            if ($encontrado) {
                $resultado = $ator->remove();
                header("location: ListaAtor.php?pagina=$pagina");
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
    <title>Lista de Atores</title>
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
    <h1>Lista de Atores cadastrados</h1>
    <a href="FormAtor.php">Novo registro</a>
    <table>
        <tr>
            <th>ID</th>
            <th>Primeiro Nome</th>
            <th>Ultimo Nome</th>
            <th>Ultima atualização</th>
            <th>Ações</th>
        </tr>
        <?php foreach($dadosPaginados as $ator) { ?>
            <tr>
                <td><?php echo $ator['ator_id']?></td>
                <td><?php echo $ator['primeiro_nome']?></td>
                <td><?php echo $ator['ultimo_nome']?></td>
                <td><?php echo $ator['ultima_atualizacao']?></td>
                <td>
                    <form action="FormAtor.php" method="POST">
                        <input type="hidden" name="ator_id" value="<?php echo $ator['ator_id']?>">
                        <input type="hidden" name="acao" value="carregar_info">
                        <button type="submit">Editar</button>
                    </form>

                    <button onclick="confirmarExclusao(<?php echo $ator['ator_id']; ?>, <?php echo $pagina; ?>)">Excluir</button>
                </td>
            </tr>
        <?php } ?>
    </table>

    <a href="ListaAtor.php?acao=previus&pagina=<?php echo $anterior; ?>">Anterior</a>
    <a href="ListaAtor.php?acao=next&pagina=<?php echo $proxima; ?>">Proxima</a>

    <script language="Javascript">
        function confirmarExclusao(id, pagina) {
            let resposta = confirm('Tem certeza que deseja excluir?');
            if (resposta) {
                window.location.href = `ListaAtor.php?ator_id=${id}&acao=excluir&pagina=${pagina}`;
            }
        }
    </script>
</body>
</html>