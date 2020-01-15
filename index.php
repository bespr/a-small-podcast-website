<?php

    $configRaw = file_get_contents('config.json');
    $config = json_decode($configRaw, true);

    $contentRaw = file_get_contents('episodes.json');
    $episodes = json_decode($contentRaw, true);

    $now = date('Y-m-d H:i:s');


    $nextEpisode = false;
    $futureEpisodes = array_filter($episodes, function($a) use ($now) {
        return ($a['pubDate'] > $now);
    });

    usort($futureEpisodes, 'sortByPubDate');

//    var_dump($futureEpisodes);
    if (count($futureEpisodes > 0)) {
        $nextEpisode = array_pop($futureEpisodes);
    }
/*
    if (count($futureEpisodes) == 1) {
        $nextEpisode = array_shift($futureEpisodes);
    }
*/

    $episodes = array_filter($episodes, function($a) use ($now) {
        return ($a['pubDate'] <= $now);
    });


    $episodes = array_filter($episodes, function($a) {
        return isset($a['filename']);
    });

    usort($episodes, 'sortByPubDate');

    function sortByPubDate($a, $b) {
        if ($a['pubDate'] == $b['pubDate']) {
            return 0;
        }
        return ($a['pubDate'] > $b['pubDate']) ? -1 : 1;
    }

?>
<!DOCTYPE html>
<html lang="de-ch">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />
    <title><?php echo $config['title']; ?></title>

    <meta property="og:title" content="<?php echo $config['title']; ?>" />
    <meta property="og:description" content="<?php echo $config['description']; ?>" />
    <meta property="og:image" content="<?php echo $config['baseUrl']; ?>/cover.jpg" />

    <link rel="alternate" type="application/rss+xml" title="Podcast Feed" href="<?php echo $config['baseUrl']; ?>/feed" />

    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,700" rel="stylesheet">
    <style>
        html {
            box-sizing: border-box;
        }
        *, *:after, *.before {
            box-sizing: inherit;
        }

        body {
            font-family: 'Playfair Display', sans-serif;
            font-weight: 400;
            font-size: 24px;
            margin: 0 auto;
            width: 100%;
            overflow-x: hidden;
            padding: 10px;
        }

        @media screen and (min-width: 580px) {
            body {
                padding: 40px;
            }

        }

        @media screen and (min-width: 860px) {
            body {
                width: 760px;
            }
        }


        h1 {
            text-indent: -9999px;
            font-weight: inherit;
            width: 100%;
            height: 0;
            padding-top: 100%;
            background-image: url('cover.jpg');
            background-size: 100%;
            margin: 0 auto;
        }

        @media screen and (min-width: 500px) {
            h1 {
                width: 480px;
                height: 480px;
                padding-top: 0;
            }
        }

        a {
            color: #346b82;
            text-decoration: none;
            border-radius: 8px;
            background-color: #eee;
            padding: 0 4px;
        }

        a:hover {
            background-color: #324750;
            color: white;
        }


        .url {
            border: 1px solid #999;
            padding: 1em;
            font-family: monospace;
            font-size: 12px;
            margin-bottom: 100px;
            display: block;
            width: 100%;
        }

        @media screen and (min-width: 340px) {
            .url {
                font-size: 16px;
            }
        }


        @media screen and (min-width: 460px) {
            .url {
                font-size: 18px;
            }
        }

        @media screen and (min-width: 500px) {
            .url {
                font-size: 20px;
            }
        }

        footer {
            margin-top: 100px;
            border-top: 1px solid #888;
            padding-top: 16px;
            font-size: 16px;
            font-family: sans-serif;
        }

        footer a {
            padding: 4px 6px;
        }


        .episode_teaser {
            padding-bottom: 30px;
            border-bottom: 1px solid #ddd;
            margin-bottom: 40px;
        }

        .episode_teaser img {
            width: 160px;
            height: auto;
            display: block;
        }

        .episode_teaser p {
            margin: 4px 0;
        }

        .episode_teaser__link {
            background-color: transparent;
            padding: 0;
            display: block;
            color: inherit;
        }

        .episode_teaser__link:hover {
            background-color: inherit;
            color: inherit;
        }



    </style>
</head>
<body>
    <h1>True Crime Swiss Edition</h1>

    <p>Jetzt abonnieren auf <a href="<?php echo $config['appleUrl']; ?>">Apple-Podcasts</a>, auf <a href="<?php echo $config['spotifyUrl']; ?>">Spotify</a> oder in der Podcast-App deiner Wahl.</p>

    <p>Falls wir doch nicht in deinem Lieblings-Podcast-Verzeichnis auffindbar sein sollten, hier ist die Feed-URL:</p>

    <input type="text" class="url" value="<?php echo $config['baseUrl']; ?>/feed" />

    <script>
        document.querySelector('.url').addEventListener('click', function() {
            this.setSelectionRange(0, this.value.length)
        });
    </script>

    <?php if ($nextEpisode) { ?>
    <?php
        $timestamp = strtotime($nextEpisode['pubDate']);
        $humanDateTime = strftime('%d.%m.%Y um %H:%M Uhr', $timestamp);
        $img = 'cover.jpg';
        if (isset($nextEpisode['img'])) {
            $img = 'covers/' . $nextEpisode['img'];
        }
    ?>
    <h2>Nächste Episode:</h2>
    <div class="episode_teaser">
        <img src="<?php echo $img; ?>" />
        <p>
        Thema: <?php echo $nextEpisode['title']; ?><br />
        Erscheint am <?php echo $humanDateTime; ?></p>
    </div>
    <?php } ?>


    <h2>Vergangene Episoden</h2>
    <?php foreach ($episodes as $episode) { ?>

    <?php
        $timestamp = strtotime($episode['pubDate']);
        $humanDateTime = strftime('%d.%m.%Y um %H:%M Uhr', $timestamp);
        $img = 'cover.jpg';
        if (isset($episode['img'])) {
            $img = 'covers/' . $episode['img'];
        }
    ?>
    <div class="episode_teaser">
        <a class="episode_teaser__link" href="<?php echo $config['baseUrl']; ?>/folge/<?php echo $episode['slug']; ?>">
            <img src="<?php echo $img; ?>" />
            <p>
            Thema: <?php echo $episode['title']; ?><br />
            Erschien am <?php echo $humanDateTime; ?></p>
        </a>
    </div>
    <?php } ?>


    <footer>
        <p>Kontakt:
        <a href="mailto:<?php echo $config['email']; ?>"><?php echo $config['email']; ?></a>,
        <a href="<?php echo $config['twitter']; ?>">Twitter</a>,
        <a href="<?php echo $config['instagram']; ?>">Instagram</a>,
        <a href="<?php echo $config['facebook']; ?>">Facebook</a>
        </p>
    </footer>

</body>
</html>
