<?php

function returnDigit($baseDigit,$cnpj)
{
	$cnpj = str_split($cnpj);
	$base = str_split($baseDigit);
	for($i = 0; $i < count($cnpj); $i++){
		$cnpj[$i] = $cnpj[$i]*$base[$i];
	}

	$digito = array_sum($cnpj)%11;
	if($digito < 2){
		$digito = 0;
	}else{
		$digito = 11 - $digito;	
	}

	return $digito;
}

//https://www.receitaws.com.br/v1/cnpj/25398139000166
$validate = $_GET['cnpj']??false;
if(!$validate){
	?>
	<!DOCTYPE html>
		<html>
		<head>
			<title>CNPJ</title>
		</head>
		<body>
			<a href="./cnpj.php">CNPJ</a>
			<p>Deu ruim... Cadê o CNPJ?</p>
			<form action="./" method="GET">
				<label>
					<input type="checkbox" name="json">
					Você quer no formato JSON?
				</label><br><br>
				<input type="text" name="cnpj" placeholder="CNPJ">
			</form>
		</body>
		</html>	
		<?php exit;
}
$validate = str_replace(array('.',',','-','/'), '', $validate);
if(strlen($validate) != 14){
	?>
	<!DOCTYPE html>
		<html>
		<head>
			<title>CNPJ</title>
		</head>
		<body>
			<a href="./cnpj.php">CNPJ</a>
			<p>Deu ruim... O número do CNPJ tem que ter 14 números</p>
			<form action="./" method="GET">
				<label>
					<input type="checkbox" name="json">
					Você quer no formato JSON?
				</label><br><br>
				<input type="text" name="cnpj" placeholder="CNPJ">
			</form>
		</body>
		</html>	
		<?php exit;
}
$basecnpj = substr((string)$validate, 0,12);
$basecnpj .= returnDigit("543298765432"  , $basecnpj);
$basecnpj .= returnDigit("6543298765432"  , $basecnpj);
$basecnpj = $basecnpj;
$json = $_GET['json']??0;
if(!$json){
	?>

		<!DOCTYPE html>
		<html>
		<head>
			<title>CNPJ</title>
		</head>
		<body>
			<a href="./cnpj.php">CNPJ</a>
			<form action="./" method="GET">
				<label>
					<input type="checkbox" name="json">
					Você quer no formato JSON?
				</label><br><br>
				<input type="text" name="cnpj" placeholder="CNPJ">
			</form>
			CNPJ BASE: <?=$basecnpj;?>
			<br><br>
			CNPJ INFORMADO: <?=$validate;?>
			<br><br>
			<?php
				if($basecnpj === $validate){
				echo 'CNPJ: Valido';
				}else{
				echo 'CNPJ: Inválido';
				}
			?>
		</body>
		</html>	

	<?php
	
	echo '<hr>';
}else{
	header('Content-Type: application/json; charset=utf-8');
}

if($basecnpj === $validate){
	$baseUrl = 'https://www.receitaws.com.br/v1/cnpj/'.$validate;
	$ch = curl_init($baseUrl);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$result = curl_exec($ch);
	echo ($result);

	curl_close($ch);
}

