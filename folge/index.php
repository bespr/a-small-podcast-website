<?php

$episodePath = '';
$fullPath = $_SERVER['REQUEST_URI'];
if (preg_match('/\/folge\/([a-z0-9-]+)/', $fullPath, $matches)) {
    if (isset($matches[1])) {
        $episodePath = $matches[1];
    }
}
if (empty($episodePath)) {
    echo 'e1';
    exit;
}


$configRaw = file_get_contents('../config.json');
$config = json_decode($configRaw, true);

$contentRaw = file_get_contents('../episodes.json');
$episodes = json_decode($contentRaw, true);

$episode = false;
foreach ($episodes as $epi) {
    if ($epi['slug'] == $episodePath) {
        $episode = $epi;
        break;
    }
}

if (!$episode) {
    echo 'e2';
    exit;
}



$now = date('Y-m-d H:i:s');

$isPublished = true;
if ($episode['pubDate'] > $now) {
    $isPublished = false;
}

if (isset($_GET['publ'])) {
    $isPublished = true;
}



$pageTitle = $episode['title'] . ' | Episode ' . $episode['episodeNum'] . ' von Podcast «' . $config['title'] . '»';
$pageDesc = $episode['description'];
$url = $config['baseUrl'] . '/folge/' . $episode['slug'];

$timestamp = strtotime($episode['pubDate']);
$humanDateTime = date('d.m.Y', $timestamp) . ' um ' . date('H:i', $timestamp) . ' Uhr';


$episodeImg = '/cover.jpg';
if (isset($episode['img'])) {
    $episodeImg = '/covers/' . $episode['img'];
}

$episodeImgLandscape = $episodeImg;
$candidateFile = str_replace('.jpg', '-landscape.jpg', $episodeImg);
if (file_exists('..' . $candidateFile)) {
    $episodeImgLandscape = $candidateFile;
}

// Make Paths absolute
$episodeImg = $config['baseUrl'] . $episodeImg;
$episodeImgLandscape = $config['baseUrl'] . $episodeImgLandscape;



?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />
    <title><?php echo $pageTitle; ?></title>

    <meta property="og:title" content="<?php echo $pageTitle; ?>" />
    <meta property="og:description" content="<?php echo $pageDesc; ?>" />
    <meta property="og:image" content="<?php echo $episodeImgLandscape; ?>" />
    <meta property="og:url" content="<?php echo $url; ?>">
    <meta property="og:site_name" content="Podcast «<?php echo $config['title']; ?>»" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:image:src" content="<?php echo $episodeImgLandscape; ?>" />
    <meta name="twitter:image:alt" content="The episode cover image" />
    <meta name="twitter:site" content="<?php echo $config['twitterHandle']; ?>" />


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


        h1 {
            font-size: 3em;
            line-height: 1em;
            font-weight: normal;
            margin: 0;
            padding: 0.125em 0;
        }

        .kicker {
            margin: 0;
        }

        .episodeNum {
            margin: 0;
        }

        .pubdate {
            opacity: 0.6;
            margin: 0.25em 0;
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


        .cover {
            width: 100%;
            max-width: 500px;
            display: block;
            margin: 42px 0;

        }

        audio {
            margin: 42px 0;
            width: 100%;
        }

    </style>
</head>
<body>
    <p class="kicker"><a href="<?php echo $config['baseUrl']; ?>">Podcast «<?php echo $config['title']; ?>»</a></p>

    <h1><?php echo $episode['title']; ?></h1>
    <p class="episodeNum">Episode <?php echo $episode['episodeNum']; ?></p>

    <?php if ($isPublished) { ?>
    <p class="pubdate">Veröffentlicht am <?php echo $humanDateTime; ?></p>
    <?php } else { ?>
    <p class="pubdate">Wird veröffentlicht am <?php echo $humanDateTime; ?></p>
    <?php } ?>


    <img class="cover" src="<?php echo $episodeImg; ?>" />

    <div><?php echo nl2br($pageDesc); ?></div>


    <?php if ($isPublished) { ?>
    <audio src="<?php echo $config['baseUrl']; ?>/episodes/<?php echo $episode['filename']; ?>" controls></audio>
    <?php } else { ?>
    <p class="audio-placeholder">Hören Sie sich diese Episode genau hier an ab <?php echo $humanDateTime; ?></p>
    <?php } ?>


    <footer>
        <?php include('../parts/footer.php'); ?>
    </footer>


</body>
</html>
