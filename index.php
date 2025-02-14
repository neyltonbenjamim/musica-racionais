<?php
include __DIR__ . '/listMusica.php';
include __DIR__ . '/config.php';
include __DIR__ . '/Letra.php';
$base = 'https://racionaisoficial.com'
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
                            <option <?= (isset($_GET['artista']) && $_GET['artista'] == $artista['artista'])?'selected':'';?> value="<?= $artista['artista']; ?>">Artista: <?= $artista['artista'].' '.$artista['categoria']; ?></option>
                        <?php endforeach; ?>

                    </select>
                    <div class="list">
                        <ul>
                            <!-- <li><a title="1 por Amor, 2 por Dinheiro" href="javascript:void(0);" class="next-musica active" data-id="7l-tp7yyJaE">1 por Amor, 2 por Dinheiro</a></li> -->
                            <?php foreach ($listMusic as $musica) : ?>

                                <?php if (isset($_GET['artista']) && $_GET['artista'] != 'all') : ?>
                                    <?php if ($_GET['artista'] === $musica['artista']) : ?>
                                        <li>
                                            <a title="<?= $musica['artista'] . ' - ' . $musica['title']; ?>" href="<?= $base . '?watch=' . $musica['id']."&artista=". urlencode($musica['artista']); ?>" class="next-musica" id="<?= $musica['id']; ?>" data-artista="<?= $musica['artista']; ?>" data-title="<?= $musica['title']; ?>" data-id="<?= $musica['id']; ?>"><b><?= $musica['artista']; ?></b> - <?= $musica['title']; ?></a>
                                        </li>
                                    <?php endif; ?>
                                <?php else : ?>
                                    <li>
                                        <a title="<?= $musica['artista'] . ' - ' . $musica['title']; ?>" href="<?= $base . '?watch=' . $musica['id']; ?>" class="next-musica" id="<?= $musica['id']; ?>" data-artista="<?= $musica['artista']; ?>" data-title="<?= $musica['title']; ?>" data-id="<?= $musica['id']; ?>"><b><?= $musica['artista']; ?></b> - <?= $musica['title']; ?></a>
                                        <?php if (isset($_GET['leg'])) : ?>
                                            <a target="_blank" href="<?= "addLetra.php?id=" . $musica['id'] . "&artista=" . $musica['artista'] . "&title=" . $musica['title']; ?>">Legenda</a>
                                        <?php endif; ?>
                                    </li>
                                <?php endif; ?>

                            <?php endforeach; ?>
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
            <p>Desenvolvido por&nbsp;
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