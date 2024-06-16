<?php
// Function to fetch RSS feed using cURL
function fetch_rss_feed($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Set a timeout for the request
    $data = curl_exec($ch);

    if(curl_errno($ch)) {
        $error_msg = curl_error($ch);
        curl_close($ch);
        return ['error' => $error_msg];
    }

    curl_close($ch);
    return ['data' => $data];
}

// RSS feed URL
$rss_url = "https://news.google.com/rss/search?q=%22native+american%22+food+sovereignty&hl=en-US&gl=US&ceid=US%3Aen";

// Fetch the RSS feed
$response = fetch_rss_feed($rss_url);

if (isset($response['error'])) {
    // Log the error or handle it as needed
    error_log("Failed to fetch RSS feed: " . $response['error']);
    echo json_encode(['error' => 'Failed to fetch RSS feed']);
    exit;
}

// Load the RSS feed data
$rss_feed = simplexml_load_string($response['data']);
if ($rss_feed === false) {
    // Handle XML parsing errors
    error_log("Failed to parse RSS feed");
    echo json_encode(['error' => 'Failed to parse RSS feed']);
    exit;
}

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

// Save the parsed data to a JSON file
file_put_contents('rss_data.json', json_encode($items));

// Output the data for debugging (optional)
header('Content-Type: application/json');
echo json_encode($items);
