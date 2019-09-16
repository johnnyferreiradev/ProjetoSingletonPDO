<?php
    namespace App\Listas;

    require '../autoload.php';

    use App\Classes\Funcionario;

    // Lógica da paginação
    $dados = Funcionario::listAll();
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

    $funcionario = new Funcionario();
    $dadosPaginados = $funcionario->paginate($inicio, $limite);

    if(!empty($_GET)) {
        
        if($_GET['acao'] == 'excluir') {
            $funcionarioId = $_GET['funcionario_id'];
            $funcionario = new Funcionario();
            $funcionario->setFuncionarioId($funcionarioId);
            $encontrado = $funcionario->findById();

            $resultado = null;
            if ($encontrado) {
                $resultado = $funcionario->remove();
                header("location: ListaFuncionario.php?acao=&pagina=$pagina");
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
    <title>Lista de funcionarios</title>
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
    <h1 class="list-title">Lista de funcionarios cadastrados</h1>
    <a class="btn-new" href="../Formularios/FormFuncionario.php">Novo registro</a>
    <table class="list-table">
        <tr class="row-titles">
            <th>ID</th>
            <th>Primeiro Nome</th>
            <th>Ultimo Nome</th>
            <th>Endereço ID</th>
            <th>Foto</th>
            <th>Email</th>
            <th>Loja ID</th>
            <th>Ativo</th>
            <th>Usuario</th>
            <th>Senha</th>
            <th>Ultima atualização</th>
            <th>Ações</th>
        </tr>
        <?php foreach($dadosPaginados as $funcionario) { ?>
            <tr class="row-results">
                <td><?php echo $funcionario['funcionario_id']?></td>
                <td><?php echo $funcionario['primeiro_nome']?></td>
                <td><?php echo $funcionario['ultimo_nome']?></td>
                <td><?php echo $funcionario['endereco_id']?></td>
                <td><?php echo $funcionario['foto']?></td>
                <td><?php echo $funcionario['email']?></td>
                <td><?php echo $funcionario['loja_id']?></td>
                <td><?php echo $funcionario['ativo']?></td>
                <td><?php echo $funcionario['usuario']?></td>
                <td><?php echo $funcionario['senha']?></td>
                <td><?php echo $funcionario['ultima_atualizacao']?></td>
                <td>
                    <form action="../Formularios/FormFuncionario.php" method="POST">
                        <input type="hidden" name="funcionario_id" value="<?php echo $funcionario['funcionario_id']?>">
                        <input type="hidden" name="acao" value="carregar_info">
                        <button type="submit" class="btn-edit">Editar</button>
                    </form>

                    <button onclick="confirmarExclusao(<?php echo $funcionario['funcionario_id']; ?>, <?php echo $pagina; ?>)" class="btn-remove">Excluir</button>
                </td>
            </tr>
        <?php } ?>
    </table>

    <a href="ListaFuncionario.php?acao=&pagina=<?php echo $anterior; ?>" class="btn-previus">Anterior</a>
    <a href="ListaFuncionario.php?acao=&pagina=<?php echo $proxima; ?>" class="btn-next">Proxima</a>

    <script language="Javascript">
        function confirmarExclusao(id, pagina) {
            let resposta = confirm('ATENÇÃO! Todos os dados do elemento selecionado serão removidos!\nDeseja realmente excluir?');
            if (resposta) {
                window.location.href = `ListaFuncionario.php?funcionario_id=${id}&acao=excluir&pagina=${pagina}`;
            }
        }
    </script>
</body>
</html>