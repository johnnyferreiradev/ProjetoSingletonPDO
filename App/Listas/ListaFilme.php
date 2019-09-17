<?php
    namespace App\Listas;

    require '../autoload.php';

    use App\Classes\Filme;

    // Lógica da paginação
    $dados = Filme::listAll();
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

    $filme = new Filme();
    $dadosPaginados = $filme->paginate($inicio, $limite);

    if(!empty($_GET)) {
        
        if($_GET['acao'] == 'excluir') {
            $filmeId = $_GET['filme_id'];
            $filme = new Filme();
            $filme->setFilmeId($filmeId);
            $encontrado = $filme->findById();

            $resultado = null;
            if ($encontrado) {
                $resultado = $filme->remove();
                header("location: ListaFilme.php?acao=&pagina=$pagina");
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
    <title>Lista de Filmes</title>
</head>
<body>
    <h1 class="list-title">Lista de Filmes cadastrados</h1>
    <div class="container-table">
        <a class="btn-new" href="../Formularios/FormFilme.php"><i class="fas fa-plus-circle"></i> Novo registro</a>
        <table class="list-table">
            <tr class="row-titles">
                <th>ID</th>
                <th>Título</th>
                <th>Descricao</th>
                <th>Ano de Lançamento</th>
                <th>Idioma ID</th>
                <th>Idioma Original ID</th>
                <th>Duracao da Locação</th>
                <th>Preço da Locação</th>
                <th>Duração do filme</th>
                <th>Custo de Substituição</th>
                <th>Classificação</th>
                <th>Recursos Especiais</th>
                <th>Ultima atualização</th>
                <th>Ações</th>
            </tr>
            <?php foreach($dadosPaginados as $filme) { ?>
                <tr class="row-results">
                    <td><?php echo $filme['filme_id']?></td>
                    <td><?php echo $filme['titulo']?></td>
                    <td><?php echo $filme['descricao']?></td>
                    <td><?php echo $filme['ano_de_lancamento']?></td>
                    <td><?php echo $filme['idioma_id']?></td>
                    <td><?php echo $filme['idioma_original_id']?></td>
                    <td><?php echo $filme['duracao_da_locacao']?></td>
                    <td><?php echo $filme['preco_da_locacao']?></td>
                    <td><?php echo $filme['duracao_do_filme']?></td>
                    <td><?php echo $filme['custo_de_substituicao']?></td>
                    <td><?php echo $filme['classificacao']?></td>
                    <td><?php echo $filme['recursos_especiais']?></td>
                    <td><?php echo $filme['ultima_atualizacao']?></td>
                    <td>
                        <form action="../Formularios/FormFilme.php" method="POST">
                            <input type="hidden" name="filme_id" value="<?php echo $filme['filme_id']?>">
                            <input type="hidden" name="acao" value="carregar_info">
                            <button type="submit" class="btn-edit">Editar</button>
                        </form>

                        <button onclick="confirmarExclusao(<?php echo $filme['filme_id']; ?>, <?php echo $pagina; ?>)" class="btn-remove">Excluir</button>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <a href="ListaFilme.php?acao=&pagina=<?php echo $anterior; ?>" class="btn-previus">Anterior</a>
        <a href="ListaFilme.php?acao=&pagina=<?php echo $proxima; ?>" class="btn-next">Proxima</a>
    </div>

    <script language="Javascript">
        function confirmarExclusao(id, pagina) {
            let resposta = confirm('ATENÇÃO! Todos os dados do elemento selecionado serão removidos!\nDeseja realmente excluir?');
            if (resposta) {
                window.location.href = `ListaFilme.php?filme_id=${id}&acao=excluir&pagina=${pagina}`;
            }
        }
    </script>
</body>
</html>