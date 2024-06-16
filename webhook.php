<?php
// webhook.php

// Fetch the RSS feed
$rss_url = "https://news.google.com/rss/search?q=%22native+american%22+food+sovereignty&hl=en-US&gl=US&ceid=US%3Aen";
$rss_feed = simplexml_load_file($rss_url);

// Parse the RSS feed
$items = [];
foreach ($rss_feed->channel->item as $item) {
    $items[] = [
        'title' => (string) $item->title,
        'link' => (string) $item->link,
        'description' => (string) $item->description,
        'pubDate' => (string) $item->pubDate
    ];
}

// Convert to JSON and print (for debugging)
header('Content-Type: application/json');
echo json_encode($items);
