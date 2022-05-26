<?php
include __DIR__.'/data.php';
include __DIR__.'/Letra.php';
$letra = new Letra($_POST['id'],$_POST['artista'],$_POST['title']);
echo $letra->pegarLetra();