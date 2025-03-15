<?php
require __DIR__.DIRECTORY_SEPARATOR.'data.php';
require __DIR__.DIRECTORY_SEPARATOR.'vendor/autoload.php';
date_default_timezone_set('America/Bahia');
define("TELEGRAM_TOKEN","5835226052:AAGR84NKbPt79yxuZbXLb_cTwFeRrLKkUzg");
define("TELEGRAM_ID_USER","1131494038");
define("TELEGRAM_USER","neyltonbenjamim");

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
