<?php

$configRaw = file_get_contents('config.json');
$config = json_decode($configRaw, true);

$contentRaw = file_get_contents('episodes.json');
$episodes = json_decode($contentRaw, true);

$now = date('Y-m-d H:i:s');

$episodes = array_filter($episodes, function($a) use ($now) {
    return ($a['pubDate'] <= $now);
});

$episodes = array_filter($episodes, function($a) {
    return isset($a['filename']);
});


usort($episodes, function($a, $b) {
    if ($a['pubDate'] == $b['pubDate']) {
        return 0;
    }
    return ($a['pubDate'] > $b['pubDate']) ? -1 : 1;
});






$img = $config['baseUrl'] . '/cover.jpg';
$feed = $config['baseUrl'] . '/feed';
$latestUpdate = date('r', strtotime($episodes[0]['pubDate']));

header('Content-Type: text/xml');

echo '<?xml version="1.0" encoding="utf-8" ?>' . "\n";
?>
<rss xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd" version="2.0">
    <channel>
        <title><?php echo $config['title']; ?></title>
        <link><?php echo $config['baseUrl']; ?></link>
        <image>
            <url><?php echo $img; ?></url>
        </image>
        <description><?php echo $config['description']; ?></description>
        <language>de</language>
        <lastBuildDate><?php echo $latestUpdate; ?></lastBuildDate>
        <itunes:owner>
            <itunes:email><?php echo $config['email']; ?></itunes:email>
            <itunes:name><?php echo $config['author']; ?></itunes:name>
        </itunes:owner>
        <itunes:summary><?php echo $config['description']; ?></itunes:summary>
        <itunes:subtitle><?php echo $config['subtitle']; ?></itunes:subtitle>
        <itunes:explicit>No</itunes:explicit>
        <itunes:keywords>
            <?php echo $config['keywords']; ?>
        </itunes:keywords>
        <itunes:image href="<?php echo $img; ?>"/>
        <itunes:category text="<?php echo $config['iTunesCategory']; ?>" />
        <itunes:author><?php echo $config['author']; ?></itunes:author>
        <pubDate><?php echo $latestUpdate; ?></pubDate>


<?php foreach($episodes as $e) { ?>
    <?php
        $linkUrl = $config['baseUrl'] . '/episodes/' . $e['filename'];
        if (isset($e['cacheVersion'])) {
            $linkUrl .= '?v=' . $e['cacheVersion'];
        }

        $episodeUrl = $config['baseUrl'] . '/folge/' . $e['slug'];
    ?>

    <?php
        if (isset($e['img'])) {
            $episodeImg = $config['baseUrl'] . '/covers/' . $e['img'];
        } else {
            $episodeImg = $img;
        }
    ?>

<item>
    <title><?php echo $e['title']; ?></title>
    <link><?php echo $linkUrl; ?></link>
    <pubDate><?php echo date('r', strtotime($e['pubDate'])); ?></pubDate>
    <description><?php echo $e['description']; ?></description>
    <enclosure url="<?php echo $linkUrl; ?>" type="audio/mpeg"/>
    <guid><?php echo $linkUrl; ?></guid>

    <image>
        <url><?php echo $episodeImg; ?></url>
        <title><?php echo $e['title']; ?></title>
        <link><?php echo $episodeUrl; ?></link>
    </image>

    <itunes:duration><?php echo $e['duration']; ?></itunes:duration>
    <itunes:summary><?php echo $e['description']; ?></itunes:summary>
    <itunes:image href="<?php echo $episodeImg; ?>"/>
    <itunes:explicit>no</itunes:explicit>
</item>

<?php } ?>

</channel>
</rss>
