<?php
function digit($baseDigit,$cnpj)
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

function returnDigito($validate)
{

	$digito = '';
	$basecnpj = substr((string)$validate, 0,12);
	$digito .= digit("543298765432"  , $basecnpj);
	$digito .= digit("6543298765432"  , $basecnpj.$digito);
	$basecnpj .= $digito;
	return ['cnpj' => $basecnpj, 'digito' => $digito];
}

	$erro = null;
	$message = null;
	$_GET['cnpj'] = str_replace(array('.',',','-','/'), '', $_GET['cnpj']??0);

	if(isset($_GET['digito']) && !empty($_GET['digito'])){
		$response = returnDigito($_GET['cnpj']);
		$message = '
		Digito: <b>'.$response['digito'].'</b><br><br>
		Base CNPJ: <b>'.substr((string)$_GET['cnpj'], 0,12).'</b><br><br>
		CNPJ: <b>'.$response['cnpj'].'</b>';

	}else if(isset($_GET['matriz']) && !empty($_GET['matriz'])){
		$basecnpj = substr((string)$_GET['cnpj'], 0,8);
		$response = [];
		for($i = 1;$i<=$_GET['numero'];$i++){
			$response[] = returnDigito($basecnpj.str_repeat(0, 4-strlen($i)).$i);
		}
		$message = '<ul>';
		foreach ($response as $key => $value) {
			$message .= 
			'<li>
				<a target="_blank" href="./?cnpj='.$value['cnpj'].'">'.$value['cnpj'].'</a> - 
				<a target="_blank" href="./?cnpj='.$value['cnpj'].'&json=true">JSON</a>
			</li>';
		}	
		$message .= '</ul>';
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>CNPJ </title>
<style type="text/css">
	*{
		border: none;
		padding: 0;
		margin: 0;
		font-family: arial;
	}
	p{
		padding: 10px 30px;
		background-color: #fbfbfb;
		border-bottom: 1px #ccc solid;
	}
	h3{
		margin: 15px 30px;
	}
	form{
		padding: 30px;
		border:solid #ccc 1px;
		margin: 0 30px;
	}
	input{
		border: 1px solid #ccc;
		padding: 5px;
		margin: 10px 0;
	}
	input[type="submit"]{
		cursor: pointer;
	}
</style>
</head>
<body>
	<p><?= $message??'';?></p>
	<hr>
	<h3>Buscar o digito</h3>
	<form action="./cnpj.php" method="GET">
		<label>
			CNPJ: 
			<input type="text" name="cnpj" placeholder="CNPJ">
		</label><br>
		<input type="hidden" name="digito" value="true">
		<input type="submit" value="Buscar o digito">
	</form>
<hr>
<h3>Gerarar lista de <b>CNPJs<b> da matriz</h3>
	<form action="./cnpj.php" method="GET">
		<label>
			CNPJ: 
			<input type="text" name="cnpj" placeholder="CNPJ">
		</label>
		<label><br>
			Número de filiais: 
			<input type="text" name="numero" placeholder="Número">
		</label><br>
		<input type="hidden" name="matriz" value="true">
		<input type="submit" value="Gerarar lista de cnpjs da matriz">
	</form>

</body>
</html>