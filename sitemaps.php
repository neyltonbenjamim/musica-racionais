<?php
header('Content-Type: text/html; charset=utf-8');
require __DIR__.DIRECTORY_SEPARATOR.'listMusica.php';
foreach($musicas as $m){
	echo 'https://racionaisoficial.com/?watch='.$m['id'].PHP_EOL;
}