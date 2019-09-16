<?php
    namespace App\Listas;

    require '../autoload.php';

    use App\Classes\Pais;

    // Lógica da paginação
    $dados = Pais::listAll();
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

    $pais = new Pais();
    $dadosPaginados = $pais->paginate($inicio, $limite);

    if(!empty($_GET)) {
        
        if($_GET['acao'] == 'excluir') {
            $paisId = $_GET['pais_id'];
            $pais = new Pais();
            $pais->setPaisId($paisId);
            $encontrado = $pais->findById();

            $resultado = null;
            if ($encontrado) {
                $resultado = $pais->remove();
                header("location: ListaPais.php?acao=&pagina=$pagina");
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
    <title>Lista de Paises</title>
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
    <h1 class="list-title">Lista de Paises cadastrados</h1>
    <a class="btn-new" href="../Formularios/FormPais.php">Novo registro</a>
    <table class="list-table">
        <tr class="row-titles">
            <th>ID</th>
            <th>Pais</th>
            <th>Ultima atualização</th>
            <th>Ações</th>
        </tr>
        <?php foreach($dadosPaginados as $pais) { ?>
            <tr class="row-results">
                <td><?php echo $pais['pais_id']?></td>
                <td><?php echo $pais['pais']?></td>
                <td><?php echo $pais['ultima_atualizacao']?></td>
                <td>
                    <form action="../Formularios/FormPais.php" method="POST">
                        <input type="hidden" name="pais_id" value="<?php echo $pais['pais_id']?>">
                        <input type="hidden" name="acao" value="carregar_info">
                        <button type="submit" class="btn-edit">Editar</button>
                    </form>

                    <button onclick="confirmarExclusao(<?php echo $pais['pais_id']; ?>, <?php echo $pagina; ?>)" class="btn-remove">Excluir</button>
                </td>
            </tr>
        <?php } ?>
    </table>

    <a href="ListaPais.php?acao=&pagina=<?php echo $anterior; ?>" class="btn-previus">Anterior</a>
    <a href="ListaPais.php?acao=&pagina=<?php echo $proxima; ?>" class="btn-next">Proxima</a>

    <script language="Javascript">
        function confirmarExclusao(id, pagina) {
            let resposta = confirm('ATENÇÃO! Além do elemento selecionado, todos os registros associados a ele serão removidos.\nDeseja realmente excluir?');
            if (resposta) {
                window.location.href = `ListaPais.php?pais_id=${id}&acao=excluir&pagina=${pagina}`;
            }
        }
    </script>
</body>
</html>