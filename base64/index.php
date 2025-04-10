<?php
?>

<form>
	<h3>BASE64</h3>
	<textarea style="width: 100%;height: 300px;" name="token" placeholder="Adicione o token aqui, seu trouxa! Vou fazer o trabalho duro para você, seu incompetente."><?= isset($_GET['token']) ? $_GET['token'] : ''; ?></textarea>
	Base64_encode <input <?= (isset($_GET['tipo']) && $_GET['tipo'] == 'base64_encode') ? 'checked=true' : ''; ?> <?= !isset($_GET['tipo']) ? 'checked="true"' : ''; ?> type="radio" name="tipo" value="base64_encode"><br>
	Base64_decode: <input <?= (isset($_GET['tipo']) && $_GET['tipo'] == 'base64_decode') ? 'checked=true' : ''; ?> type="radio" name="tipo" value="base64_decode"><br>
	UrlEncode: <input <?= (isset($_GET['tipo']) && $_GET['tipo'] == 'urlencode') ? 'checked=true' : ''; ?> type="radio" name="tipo" value="urlencode"><br>
	UrlDecode: <input <?= (isset($_GET['tipo']) && $_GET['tipo'] == 'urldecode') ? 'checked=true' : ''; ?> type="radio" name="tipo" value="urldecode"><br>
	mb_chr: <input <?= (isset($_GET['tipo']) && $_GET['tipo'] == 'mb_chr') ? 'checked=true' : ''; ?> type="radio" name="tipo" value="mb_chr"><br>
	mb_ord: <input <?= (isset($_GET['tipo']) && $_GET['tipo'] == 'mb_ord') ? 'checked=true' : ''; ?> type="radio" name="tipo" value="mb_ord"><br>
	<input type="submit" value="Enviar">
</form>
<a href="http://localhost/aaaa/testes/base64/">Limpar</a>
<br><br><br>
<?php
// echo base64_encode('racionais oficial');
$_GET['token'] ?? 0;
if (empty($_GET['token'])) {
	echo 'Deu ruim.... passe o token';
	exit;
}

$url = match ($_GET['tipo']) {
	'base64_encode' => base64_encode($_GET['token']),
	'base64_decode' => base64_decode($_GET['token']),
	'urlencode' => urlencode($_GET['token']),
	'urldecode' => urldecode($_GET['token']),
	'mb_chr' => mb_chr($_GET['token']),
	'mb_ord' => mb_ord($_GET['token']),
	default => die("Deu ruim.... opção de <b>TIPO</b> não encontrada"),
};

echo $url;
echo "\n<br> <div style='border-bottom:2px solid #e74c3c;margin:20px auto;'></div>";
// echo '<a target="_blank" href="' . $url . '">' . $url . '</a>';
