<?php
    require __DIR__.'/App/autoload.php';

    use App\Classes\Filme;
    use App\Classes\Idioma;

    $filmeSelecionado = null;
    $idiomas = null;
    $novoIdioma = new Idioma();
    $idiomas = $novoIdioma->listAll();

    if (!empty($_POST) && $_POST['acao'] == 'salvar') {
        $titulo = $_POST['titulo'];
        $descricao = $_POST['descricao'];
        $anoLancamento = $_POST['ano_de_lancamento'];
        $idiomaId = $_POST['idioma_id'];
        $idiomaOriginalId = $_POST['idioma_original_id'];
        $duracaoLocacao = $_POST['duracao_da_locacao'];
        $precoLocacao = $_POST['preco_da_locacao'];
        $duracaoFilme = $_POST['duracao_do_filme'];
        $custoSubstituicao = $_POST['custo_de_substituicao'];
        $classificacao = $_POST['classificacao'];
        $recursosEspeciais = $_POST['recursos_especiais'];
        $ultimaAtualizacao = $_POST['ultima_atualizacao'];

        $filme = new Filme($titulo, $descricao, $anoLancamento, $idiomaId, $idiomaOriginalId, $duracaoLocacao, $precoLocacao, $duracaoFilme, $custoSubstituicao, $classificacao, $recursosEspeciais, $ultimaAtualizacao);

        $resposta = $filme->save();
        if ($resposta) {
            header('location: ListaFilme.php');
        } else {
            echo 'Erro ao cadastrar!';
        }
    }

    if (!empty($_POST) && $_POST['acao'] == 'carregar_info') {
        $filmeId = $_POST['filme_id'];
        $filme = new Filme();
        $filme->setFilmeId($filmeId);
        $filmeSelecionado = $filme->findById();
    }
        
    if (!empty($_POST) && $_POST['acao'] == 'atualizar') {
        $filmeId = $_POST['filme_id'];
        $titulo = $_POST['titulo'];
        $descricao = $_POST['descricao'];
        $anoLancamento = $_POST['ano_de_lancamento'];
        $idiomaId = $_POST['idioma_id'];
        $idiomaOriginalId = $_POST['idioma_original_id'];
        $duracaoLocacao = $_POST['duracao_da_locacao'];
        $precoLocacao = $_POST['preco_da_locacao'];
        $duracaoFilme = $_POST['duracao_do_filme'];
        $custoSubstituicao = $_POST['custo_de_substituicao'];
        $classificacao = $_POST['classificacao'];
        $recursosEspeciais = $_POST['recursos_especiais'];
        $ultimaAtualizacao = $_POST['ultima_atualizacao'];

        $filme = new Filme($titulo, $descricao, $anoLancamento, $idiomaId, $idiomaOriginalId, $duracaoLocacao, $precoLocacao, $duracaoFilme, $custoSubstituicao, $classificacao, $recursosEspeciais, $ultimaAtualizacao, $filmeId);

        $resposta = $filme->update();    
        if ($resposta) {
            header('location: ListaFilme.php');
        } else {
            echo 'Erro ao atualizar!';
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Formulário filme</title>
</head>
<body>
    <form action="FormFilme.php" method="POST">
        <label for="title_filme">Título</label>
        <input
            id="title_filme"
            type="text"
            name="titulo"
            value="<?php echo $filmeSelecionado['titulo'] ? $filmeSelecionado['titulo'] : ''; ?>">

        <label for="description">Descrição</label>
        <input
            id="description"
            type="text"
            name="descricao"
            value="<?php echo $filmeSelecionado['descricao'] ? $filmeSelecionado['descricao'] : ''; ?>">

        <label for="ano_lanc">Ano de Lançamento</label>
        <input
            id="ano_lanc"
            type="text"
            name="ano_de_lancamento"
            value="<?php echo $filmeSelecionado['ano_de_lancamento'] ? $filmeSelecionado['ano_de_lancamento'] : ''; ?>">


        Idioma
        <select name="idioma_id">
            <option>Selecione</option>
            <?php foreach($idiomas as $idioma) { ?>
                <option value="<?php echo $idioma['idioma_id']?>"><?php echo $idioma['nome']; ?></option>
            <?php } ?>
        </select>

        Idioma Original
        <select name="idioma_original_id">
            <option>Selecione</option>
            <?php foreach($idiomas as $idioma) { ?>
                <option value="<?php echo $idioma['idioma_id']?>"><?php echo $idioma['nome']; ?></option>
            <?php } ?>
        </select>

        <label for="duracao_da_locacao">Duracao da Locação</label>
        <input
            id="duracao_da_locacao"
            type="text"
            name="duracao_da_locacao"
            value="<?php echo $filmeSelecionado['duracao_da_locacao'] ? $filmeSelecionado['duracao_da_locacao'] : ''; ?>">

        <label for="preco_da_locacao">Preço da Locação</label>
        <input
            id="preco_da_locacao"
            type="text"
            name="preco_da_locacao"
            value="<?php echo $filmeSelecionado['preco_da_locacao'] ? $filmeSelecionado['preco_da_locacao'] : ''; ?>">

        <label for="duracao_do_filme">Duração do filme</label>
        <input
            id="duracao_do_filme"
            type="text"
            name="duracao_do_filme"
            value="<?php echo $filmeSelecionado['duracao_do_filme'] ? $filmeSelecionado['duracao_do_filme'] : ''; ?>">

        <label for="custo_de_substituicao">Custo de substituição</label>
        <input
            id="custo_de_substituicao"
            type="text"
            name="custo_de_substituicao"
            value="<?php echo $filmeSelecionado['custo_de_substituicao'] ? $filmeSelecionado['custo_de_substituicao'] : ''; ?>">

        <label for="classificacao">Classificação</label>
        <input
            id="classificacao"
            type="text"
            name="classificacao"
            value="<?php echo $filmeSelecionado['classificacao'] ? $filmeSelecionado['classificacao'] : ''; ?>">

        <label for="recursos_especiais">Recursos Especiais</label>
        <input
            id="recursos_especiais"
            type="text"
            name="recursos_especiais"
            value="<?php echo $filmeSelecionado['recursos_especiais'] ? $filmeSelecionado['recursos_especiais'] : ''; ?>">

        <label for="last_update">Ultima Atualização</label>
        <input
            id="last_update"
            type="text"
            name="ultima_atualizacao"
            value="<?php echo $filmeSelecionado['ultima_atualizacao'] ? $filmeSelecionado['ultima_atualizacao'] : ''; ?>">

        <?php if(!empty($_POST['acao']) && $_POST['acao'] == 'carregar_info') { ?>
            <input type="hidden" name="filme_id" value="<?php echo $filmeSelecionado['filme_id']?>">
            <input type="hidden" name="acao" value="atualizar">
            <input type="submit" value="Atualizar">

        <?php } else { ?>
            <input type="hidden" name="acao" value="salvar">
            <input type="submit" value="Salvar">
        <?php } ?>
    </form>
</body>
</html>