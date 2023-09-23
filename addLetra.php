<?php
include __DIR__.'/data.php';
include __DIR__.'/Letra.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar letra</title>
</head>
<body>
    <form method="GET" >
    <input placeholder="ID" name="id" type="text" value="<?= $_GET['id']??''?>">
    <input placeholder="Artista" name="artista" type="text" value="<?= $_GET['artista']??''?>">
    <input placeholder="Titulo" name="title" type="text" value="<?= $_GET['title']??''?>">
    <input type="submit">
    </form>
    <?php
    if(isset($_GET['id']) && !empty($_GET['id']) && isset($_GET['artista']) && !empty($_GET['artista']) && isset($_GET['title']) && !empty($_GET['title'])){
        $letra = new Letra($_GET['id'],$_GET['artista'],$_GET['title']);
        echo $letra->pegarLetra(true);
    }
?>
</body>
</html>