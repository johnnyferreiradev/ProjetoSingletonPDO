<?php
    require __DIR__.'/App/autoload.php';

    use App\Classes\Ator;

    print_r(Ator::listAll());
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
</body>
</html>