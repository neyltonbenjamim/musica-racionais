<form>
	<h3>MD5</h3>
	<input type="text" name="token" placeholder="token"><input type="submit" value="Enviar">
</form>
<a href="http://localhost/aaaa/testes/base64/">Limpar</a>
<br><br><br>
<?php

$_GET['token']??0;
if(empty($_GET['token'])){
	echo 'Deu ruim.... passe o token';
	exit;
}
$url = md5($_GET['token']);
echo $url.'<br>';
echo '<a target="_blank" href="'.$url.'">'.$url.'</a>';