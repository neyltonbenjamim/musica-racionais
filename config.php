<?php
require 'data.php';
define('BASE', 'http://localhost/aaaa/testes/racionais/');

$watch = filter_input(INPUT_GET, 'watch',FILTER_UNSAFE_RAW);

$artista_list = [];
foreach($musicas as $key => $value){
	$artista_list[$value['artista']] = ['artista' => $value['artista'], 'categoria' => $value['category']??''];
}



shuffle($musicas);
$listMusic = [];

foreach($musicas as $musica)
{
	if(in_array($watch,$musica)){
		array_unshift($listMusic,$musica);
		continue;
	}
	array_push($listMusic,$musica);
}
