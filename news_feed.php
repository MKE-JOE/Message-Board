<?php
// URL of the RSS feed
$rss_feed_url = "https://news.google.com/rss/search?q=%22native+american%22+food+sovereignty&hl=en-US&gl=US&ceid=US%3Aen";

// Function to fetch the RSS feed and return it as a SimpleXMLElement object
function fetch_rss_feed($url) {
    $rss_content = file_get_contents($url);
    if ($rss_content === false) {
        return null;
    }
    return simplexml_load_string($rss_content);
}

// Fetch the RSS feed
$rss_feed = fetch_rss_feed($rss_feed_url);

if ($rss_feed === null) {
    echo "Error fetching the RSS feed.";
} else {
    // Display the RSS feed items
    echo "<h1>{$rss_feed->channel->title}</h1>";
    echo "<ul>";

    foreach ($rss_feed->channel->item as $item) {
        echo "<li>";
        echo "<a href='{$item->link}' target='_blank'>{$item->title}</a>";
        echo "<p>{$item->description}</p>";
        echo "<small>Published on: {$item->pubDate}</small>";
        echo "</li>";
    }

    echo "</ul>";
}
?>
