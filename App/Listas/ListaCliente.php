<?php
    namespace App\Listas;

    require '../autoload.php';

    use App\Classes\Cliente;

    // Lógica da paginação
    $dados = Cliente::listAll();
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

    $cliente = new Cliente();
    $dadosPaginados = $cliente->paginate($inicio, $limite);

    if(!empty($_GET)) {
        
        if($_GET['acao'] == 'excluir') {
            $clienteId = $_GET['cliente_id'];
            $cliente = new Cliente();
            $cliente->setClienteId($clienteId);
            $encontrado = $cliente->findById();

            $resultado = null;
            if ($encontrado) {
                $resultado = $cliente->remove();
                header("location: ListaCliente.php?acao=&pagina=$pagina");
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
    <title>Lista de clientes</title>
</head>
<body>
    <h1 class="list-title">Lista de clientes cadastrados</h1>
    <div class="container-table">
        <a class="btn-new" href="../Formularios/FormCliente.php"><i class="fas fa-plus-circle"></i> Novo registro</a>
        <table class="list-table">
            <tr class="row-titles">
                <th>ID</th>
                <th>Loja ID</th>
                <th>Primeiro Nome</th>
                <th>Ultimo Nome</th>
                <th>Email</th>
                <th>Endereço ID</th>
                <th>Ativo</th>
                <th>Data de criação</th>
                <th>Ultima atualização</th>
                <th>Ações</th>
            </tr>
            <?php foreach($dadosPaginados as $cliente) { ?>
                <tr class="row-results">
                    <td><?php echo $cliente['cliente_id']?></td>
                    <td><?php echo $cliente['loja_id']?></td>
                    <td><?php echo $cliente['primeiro_nome']?></td>
                    <td><?php echo $cliente['ultimo_nome']?></td>
                    <td><?php echo $cliente['email']?></td>
                    <td><?php echo $cliente['endereco_id']?></td>
                    <td><?php echo $cliente['ativo']?></td>
                    <td><?php echo $cliente['data_criacao']?></td>
                    <td><?php echo $cliente['ultima_atualizacao']?></td>
                    <td>
                        <form action="../Formularios/FormCliente.php" method="POST">
                            <input type="hidden" name="cliente_id" value="<?php echo $cliente['cliente_id']?>">
                            <input type="hidden" name="acao" value="carregar_info">
                            <button type="submit" class="btn-edit">Editar</button>
                        </form>

                        <button onclick="confirmarExclusao(<?php echo $cliente['cliente_id']; ?>, <?php echo $pagina; ?>)" class="btn-remove">Excluir</button>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <a href="ListaCliente.php?acao=&pagina=<?php echo $anterior; ?>" class="btn-previus">Anterior</a>
        <a href="ListaCliente.php?acao=&pagina=<?php echo $proxima; ?>" class="btn-next">Proxima</a>
    </div>

    <script language="Javascript">
        function confirmarExclusao(id, pagina) {
            let resposta = confirm('ATENÇÃO! Todos os dados do elemento selecionado serão removidos!\nDeseja realmente excluir?');
            if (resposta) {
                window.location.href = `ListaCliente.php?cliente_id=${id}&acao=excluir&pagina=${pagina}`;
            }
        }
    </script>
</body>
</html>