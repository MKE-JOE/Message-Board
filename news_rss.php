<?php
// Define the URL of the Google News RSS feed
$rss_url = "https://news.google.com/rss/search?q=%22Native+American%22+Food+Sovereignty&hl=en-US&gl=US&ceid=US:en";

// Fetch the RSS feed content
$rss_content = file_get_contents($rss_url);

if ($rss_content === FALSE) {
    echo "Failed to fetch RSS feed.";
    exit;
}

// Save the fetched content to an XML file
$output_file = 'rss_feed.xml';
file_put_contents($output_file, $rss_content);

echo "RSS feed fetched and saved to $output_file";
