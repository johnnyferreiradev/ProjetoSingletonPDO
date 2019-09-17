<?php
    namespace App\Listas;

    require '../autoload.php';

    use App\Classes\Endereco;

    // Lógica da paginação
    $dados = Endereco::listAll();
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

    $endereco = new Endereco();
    $dadosPaginados = $endereco->paginate($inicio, $limite);

    if(!empty($_GET)) {
        
        if($_GET['acao'] == 'excluir') {
            $enderecoId = $_GET['endereco_id'];
            $endereco = new Endereco();
            $endereco->setEnderecoId($enderecoId);
            $encontrado = $endereco->findById();

            $resultado = null;
            if ($encontrado) {
                $resultado = $endereco->remove();
                header("location: ListaEndereco.php?acao=&pagina=$pagina");
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
    <title>Lista de endereços</title>
</head>
<body>
    <h1 class="list-title">Lista de endereços cadastrados</h1>
    <div class="container-table">
        <a class="btn-new" href="../Formularios/FormEndereco.php"><i class="fas fa-plus-circle"></i> Novo registro</a>
        <table class="list-table">
            <tr class="row-titles">
                <th>ID</th>
                <th>Endereço</th>
                <th>Endereço 2</th>
                <th>Bairro</th>
                <th>Cidade</th>
                <th>CEP</th>
                <th>Telefone</th>
                <th>Ultima atualização</th>
                <th>Ações</th>
            </tr>
            <?php foreach($dadosPaginados as $endereco) { ?>
                <tr class="row-results">
                    <td><?php echo $endereco['endereco_id']?></td>
                    <td><?php echo $endereco['endereco']?></td>
                    <td><?php echo $endereco['endereco2']?></td>
                    <td><?php echo $endereco['bairro']?></td>
                    <td><?php echo $endereco['cidade_id']?></td>
                    <td><?php echo $endereco['cep']?></td>
                    <td><?php echo $endereco['telefone']?></td>
                    <td><?php echo $endereco['ultima_atualizacao']?></td>
                    <td>
                        <form action="../Formularios/FormEndereco.php" method="POST">
                            <input type="hidden" name="endereco_id" value="<?php echo $endereco['endereco_id']?>">
                            <input type="hidden" name="acao" value="carregar_info">
                            <button type="submit" class="btn-edit">Editar</button>
                        </form>

                        <button onclick="confirmarExclusao(<?php echo $endereco['endereco_id']; ?>, <?php echo $pagina; ?>)" class="btn-remove">Excluir</button>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <a href="ListaEndereco.php?acao=&pagina=<?php echo $anterior; ?>" class="btn-previus">Anterior</a>
        <a href="ListaEndereco.php?acao=&pagina=<?php echo $proxima; ?>" class="btn-next">Proxima</a>
    </div>

    <script language="Javascript">
        function confirmarExclusao(id, pagina) {
            let resposta = confirm('ATENÇÃO! Todos os dados do elemento selecionado serão removidos!\nDeseja realmente excluir?');
            if (resposta) {
                window.location.href = `ListaEndereco.php?endereco_id=${id}&acao=excluir&pagina=${pagina}`;
            }
        }
    </script>
</body>
</html>