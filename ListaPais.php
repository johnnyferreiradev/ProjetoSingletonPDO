<?php
    require __DIR__.'/App/autoload.php';

    use App\Classes\Pais;

    $dados = Pais::listAll();

    if(!empty($_GET)) {
        if($_GET['acao'] == 'excluir') {
            $paisId = $_GET['pais_id'];
            $pais = new Pais();
            $pais->setPaisId($paisId);
            $encontrado = $pais->findById();

            $resultado = null;
            if ($encontrado) {
                $resultado = $pais->remove();
                header('location: ListaPais.php');
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
    <title>Lista de Países</title>
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
    <h1>Lista de Países cadastrados</h1>
    <a href="FormPais.php">Novo registro</a>
    <table>
        <tr>
            <th>ID</th>
            <th>Pais</th>
            <th>Ultima atualização</th>
            <th>Ações</th>
        </tr>
        <?php foreach($dados as $pais) { ?>
            <tr>
                <td><?php echo $pais['pais_id']?></td>
                <td><?php echo $pais['pais']?></td>
                <td><?php echo $pais['ultima_atualizacao']?></td>
                <td>
                    <form action="FormPais.php" method="POST">
                        <input type="hidden" name="pais_id" value="<?php echo $pais['pais_id']?>">
                        <input type="hidden" name="acao" value="carregar_info">
                        <button type="submit">Editar</button>
                    </form>

                    <button onclick="confirmarExclusao(<?php echo $pais['pais_id']; ?>)">Excluir</button>
                </td>
            </tr>
        <?php } ?>
    </table>
    <script language="Javascript">
        function confirmarExclusao(id) {
            let resposta = confirm('Tem certeza que deseja excluir?');
            if (resposta) {
                window.location.href = `ListaPais.php?pais_id=${id}&acao=excluir`;
            }
        }
    </script>
</body>
</html>