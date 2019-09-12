<?php
    require __DIR__.'/App/autoload.php';

    use App\Classes\Ator;

    $dados = Ator::listAll();

    if(!empty($_GET)) {
        if($_GET['modo'] == 'excluir') {
            $atorId = $_GET['ator_id'];
            $ator = new Ator();
            $ator->setAtorId($atorId);
            $resultado = $ator->remove();
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
</head>
<body>
    <h1>Lista de Atores cadastrados</h1>
    <table style="width:100%">
        <tr>
            <th>ID</th>
            <th>Primeiro Nome</th>
            <th>Ultimo Nome</th>
            <th>Ultima atualização</th>
            <th>Ações</th>
        </tr>
        <?php foreach($dados as $ator) { ?>
            <tr>
                <td><?php echo $ator['ator_id']?></td>
                <td><?php echo $ator['primeiro_nome']?></td>
                <td><?php echo $ator['ultimo_nome']?></td>
                <td><?php echo $ator['ultima_atualizacao']?></td>
                <td>
                    <form action="ListaAtor.php" method="POST">
                        <input type="hidden" name="ator_id" value="<?php echo $ator['ator_id']?>">
                        <input type="hidden" name="acao" value="editar">
                        <button type="submit">Editar</button>
                    </form>

                    <button onclick="confirmarExclusao(<?php echo $ator['ator_id']; ?>)">Excluir</button>
                </td>
            </tr>
        <?php } ?>
    </table>
    <script language="Javascript">
        function confirmarExclusao(id) {
            let resposta = confirm('Tem certeza que deseja excluir?');
            if (resposta) {
                window.location.href = `ListaAtor.php?ator_id=${id}&modo=excluir`;
            }
        }
    </script>
</body>
</html>