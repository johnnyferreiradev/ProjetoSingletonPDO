<?php
    namespace App\Listas;

    require '../autoload.php';

    use App\Classes\Categoria;

    // Lógica da paginação
    $dados = Categoria::listAll();
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

    $categoria = new Categoria();
    $dadosPaginados = $categoria->paginate($inicio, $limite);

    if(!empty($_GET)) {
        
        if($_GET['acao'] == 'excluir') {
            $categoriaId = $_GET['categoria_id'];
            $categoria = new Categoria();
            $categoria->setCategoriaId($categoriaId);
            $encontrado = $categoria->findById();

            $resultado = null;
            if ($encontrado) {
                $resultado = $categoria->remove();
                header("location: ListaCategoria.php?acao=&pagina=$pagina");
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
    <title>Lista de categorias</title>
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
    <h1 class="list-title">Lista de categorias cadastradas</h1>
    <a class="btn-new" href="../Formularios/FormCategoria.php">Novo registro</a>
    <table class="list-table">
        <tr class="row-titles">
            <th>ID</th>
            <th>Nome</th>
            <th>Ultima atualização</th>
            <th>Ações</th>
        </tr>
        <?php foreach($dadosPaginados as $categoria) { ?>
            <tr class="row-results">
                <td><?php echo $categoria['categoria_id']?></td>
                <td><?php echo $categoria['nome']?></td>
                <td><?php echo $categoria['ultima_atualizacao']?></td>
                <td>
                    <form action="../Formularios/FormCategoria.php" method="POST">
                        <input type="hidden" name="categoria_id" value="<?php echo $categoria['categoria_id']?>">
                        <input type="hidden" name="acao" value="carregar_info">
                        <button type="submit" class="btn-edit">Editar</button>
                    </form>

                    <button onclick="confirmarExclusao(<?php echo $categoria['categoria_id']; ?>, <?php echo $pagina; ?>)" class="btn-remove">Excluir</button>
                </td>
            </tr>
        <?php } ?>
    </table>

    <a href="ListaCategoria.php?acao=&pagina=<?php echo $anterior; ?>" class="btn-previus">Anterior</a>
    <a href="ListaCategoria.php?acao=&pagina=<?php echo $proxima; ?>" class="btn-next">Proxima</a>

    <script language="Javascript">
        function confirmarExclusao(id, pagina) {
            let resposta = confirm('ATENÇÃO! Todos os dados do elemento selecionado serão removidos!\nDeseja realmente excluir?');
            if (resposta) {
                window.location.href = `ListaCategoria.php?categoria_id=${id}&acao=excluir&pagina=${pagina}`;
            }
        }
    </script>
</body>
</html>