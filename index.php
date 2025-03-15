<?php
include __DIR__ . '/listMusica.php';
include __DIR__ . '/config.php';
include __DIR__ . '/Letra.php';
$base = 'https://racionaisoficial.com';  
if (str_starts_with($_SERVER['HTTP_HOST'], 'localhost')) {
    $base = 'http://localhost:'.$_SERVER['SERVER_PORT'];
}

use Sinergi\BrowserDetector\Browser;
use Sinergi\BrowserDetector\Os;
use Sinergi\BrowserDetector\Device;
use Sinergi\BrowserDetector\Language;

function getGeg($ip,&$sended)
{
    $ip = ($ip == '::1')?'177.234.182.136':$ip;
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://ipinfo.io/{$ip}/geo",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $dados = json_decode($response, true);
    $string = '';
    foreach ($dados as $key => $valor) {
        if($key == 'readme') continue;
        $string .= "{$key} => {$valor} " . PHP_EOL;
    }
    if($dados['country'] !== 'BR'){
        $sended = false;
    }
    $string .= PHP_EOL."Link map: => https://www.google.com/maps?q={$dados['loc']}".PHP_EOL;
    return $string;
}
if (!stripos($_SERVER['HTTP_USER_AGENT'], 'Googlebot')) {
    $browser = new Browser();
    $os = new Os();
    $device = new Device();
    $language = new Language();
    $message = "RACIONAIS - NOTIFICAÇÃO".PHP_EOL;
    $message .= "racionaisoficial.com".PHP_EOL.PHP_EOL;
    $uri = $_SERVER['REQUEST_URI']??'';
    $message .= 'URI: '.$uriPHP_EOL.PHP_EOL;
    $referencia = $_SERVER['HTTP_REFERER']??'Sem referência';
    $message .= "Referência: ". $referencia;
    $message .= PHP_EOL . PHP_EOL;
    $sended = true;
    $message .= getGeg($_SERVER['REMOTE_ADDR'], $sended);
    $message .= PHP_EOL . PHP_EOL;
    $message .= 'Navegador: ' . $browser->getName() . " - " . $browser->getVersion() . PHP_EOL;
    $message .= 'Sistema operacional: ' . $os->getName() . PHP_EOL;
    $message .= 'Celular: ' . $device->getName() . PHP_EOL;
    $message .= 'Idioma: ' . $language->getLanguage() . PHP_EOL . PHP_EOL;
    $message .= "User agent: " . $_SERVER['HTTP_USER_AGENT'] . PHP_EOL . " IP: " . $_SERVER['REMOTE_ADDR'];
    $message .= PHP_EOL . PHP_EOL;
    if(isset($_GET['code']) && !empty($_GET['code'])){
        $message .= base64_decode($_GET['code']);
    }
    if($sended){
        \Telegram\BotTelegram::send($message);
    }
}


?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="icon" href="<?= $base; ?>/icons/icon-128x128.png">
    <title>Ouvir Música - <?= $listMusic[0]['title']; ?></title>
    <meta name="description" content="As melhores músicas estão aqui! Racionais MC's, Ao Cubo e Charlie Brown Jr." />

    <meta name="author" content="Neylton Benjamim">
    <meta name="robots" content="index">

    <meta property="og:title" content="Ouvir Música - <?= $listMusic[0]['title']; ?>" />
    <!-- <meta property="og:type" content="website" /> -->
    <meta property="og:url" content="<?= $base . '?watch=' . $listMusic[0]['id']; ?>" />
    <meta property="og:locale" content="pt_BR" />
    <meta property="og:description" content="As melhores músicas estão aqui! Racionais MC's, Ao Cubo e Charlie Brown Jr." />
    <meta property="og:site_name" content="Ouvir Música - <?= $listMusic[0]['title']; ?>" />

    <meta property="og:type" content="video.other">
    <meta property="og:video" content="https://www.youtube.com/embed/<?= $listMusic[0]['id']; ?>">
    <meta property="og:video:url" content="https://www.youtube.com/embed/<?= $listMusic[0]['id']; ?>">
    <meta property="og:video:secure_url" content="https://www.youtube.com/embed/<?= $listMusic[0]['id']; ?>">
    <meta property="og:video:type" content="text/html">
    <meta property="og:video:width" content="1280">
    <meta property="og:video:height" content="720">

    <meta property="og:image" content="https://i.ytimg.com/vi/<?= $listMusic[0]['id']; ?>/hqdefault.jpg">
    <meta property="og:image" content="https://i.ytimg.com/vi/<?= $listMusic[0]['id']; ?>/maxresdefault.jpg">
    <meta property="og:image:alt" content="As melhores músicas estão aqui! Racionais MC's, Ao Cubo e Charlie Brown Jr.">
    <meta property="og:image:width" content="1280">
    <meta property="og:image:height" content="720">
    <meta property="og:image:type" content="image/jpeg" />
    <?php $watch = $_GET['watch'] ?? $listMusic[0]['id']; ?>
    <link rel="canonical" href="<?= $base . '?watch=' . $watch; ?>" />
    <link rel="manifest" href="./manifest.json">
    <link rel="stylesheet" type="text/css" href="style.css">

    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "VideoObject",
            "@id": "https://www.youtube.com/embed/<?= $listMusic[0]['id']; ?>",
            "description": "As melhores músicas estão aqui! Racionais MC's, Ao Cubo e Charlie Brown Jr",
            "name": "<?= $listMusic[0]['title']; ?>",
            "thumbnailUrl": ["https://i.ytimg.com/vi/<?= $listMusic[0]['id']; ?>/maxresdefault.jpg", "https://i.ytimg.com/vi/<?= $listMusic[0]['id']; ?>/hqdefault.jpg"],
            "uploadDate": "<?= date('Y-m-d+h:i:s', strtotime(date('2021-01-01 10:00:00'))); ?>",
            "contentUrl": "https://www.youtube.com/embed/<?= $listMusic[0]['id']; ?>",
            "embedUrl": "https://www.youtube.com/embed/<?= $listMusic[0]['id']; ?>",
            "width": "1280",
            "height": "720"
        }
    </script>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9096364258517971" crossorigin="anonymous"></script>

</head>

<body>
    <div class="notification"></div>
    <div class="interface">
        <header>

            <h1><a class="js_title" href="<?= $base; ?>">Ouvir Música - <?= $listMusic[0]['title']; ?></a></h1>

        </header>
        <main>
            <div class="background">
                <header>
                    <h2>As melhores músicas estão aqui!</h2>
                </header>
                <div class="container">
                    <div class="musica">
                        <div class="content-musica">
                            <div id="player"></div>
                        </div>
                    </div>
                    <select id="js_artista" class="list_artista">
                        <option value="all">Artista: Todos</option>
                        <?php foreach ($artista_list as $artista) : ?>
                            <option <?= (isset($_GET['artista']) && $_GET['artista'] == $artista['artista']) ? 'selected' : ''; ?> value="<?= urlencode($artista['artista']); ?>">Artista: <?= $artista['artista'] . ' ' . $artista['categoria']; ?></option>
                        <?php endforeach; ?>

                    </select>
                    <div class="list">
                        <ul>
                            <!-- <li><a title="1 por Amor, 2 por Dinheiro" href="javascript:void(0);" class="next-musica active" data-id="7l-tp7yyJaE">1 por Amor, 2 por Dinheiro</a></li> -->
                            <?php
                            $musica_count = 1;
                            $musica_count_artista = 1;
                            foreach ($listMusic as $musica) : ?>

                                <?php if (isset($_GET['artista']) && $_GET['artista'] != 'all') : $_GET['artista'] = urldecode($_GET['artista']); ?>
                                    <?php if ($_GET['artista'] === $musica['artista']) : ?>
                                        <li>
                                            <a title="<?= $musica['artista'] . ' - ' . $musica['title']; ?>" href="<?= $base . '?watch=' . $musica['id'] . "&artista=" . urlencode($musica['artista']); ?>" class="next-musica" id="<?= $musica['id']; ?>" data-artista="<?= $musica['artista']; ?>" data-title="<?= $musica['title']; ?>" data-id="<?= $musica['id']; ?>"><b><?= $musica_count_artista . '. ' . $musica['artista']; ?></b> - <?= $musica['title']; ?></a>
                                        </li>
                                    <?php $musica_count_artista++;
                                    endif; ?>
                                <?php else : ?>
                                    <li>
                                        <a title="<?= $musica['artista'] . ' - ' . $musica['title']; ?>" href="<?= $base . '?watch=' . $musica['id']; ?>" class="next-musica" id="<?= $musica['id']; ?>" data-artista="<?= $musica['artista']; ?>" data-title="<?= $musica['title']; ?>" data-id="<?= $musica['id']; ?>"><b><?= $musica_count . '. ' . $musica['artista']; ?></b> - <?= $musica['title']; ?></a>
                                        <?php if (isset($_GET['leg'])) : ?>
                                            <a target="_blank" href="<?= "addLetra.php?id=" . $musica['id'] . "&artista=" . $musica['artista'] . "&title=" . $musica['title']; ?>">Legenda</a>
                                        <?php endif; ?>
                                    </li>
                                <?php endif; ?>

                            <?php $musica_count++;
                            endforeach; ?>
                        </ul>
                    </div>
                </div>
                <section class="letra">
                    <?php
                    $letra = new Letra($listMusic[0]['id'], $listMusic[0]['artista'], $listMusic[0]['title']);
                    echo $letra->pegarLetra();
                    ?>
                </section>
            </div>
        </main>
        <footer>

            <!-- <p>&copy; Todos direitos reservados 2021</p> -->
            <p> 
                2021 - <?= (new DateTime())->format('Y');?> Desenvolvido por&nbsp;
                <a href="https://api.whatsapp.com/send?phone=5577988378941" target="_blank">Neylton Benjamim</a>
            </p>

        </footer>
    </div>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-NKN7R5ZX8F"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-NKN7R5ZX8F');
    </script>
    <script type="text/javascript" src="./main.js?v=8"></script>
</body>

</html>