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
    $rss_feed = null;
} else {
    $data = $response['data'];

    // Check if the response is valid XML
    if (strpos($data, '<?xml') === false) {
        // Handle the case where the response is not valid XML
        error_log("The response is not valid XML: " . substr($data, 0, 200)); // Log the first 200 characters of the response
        $rss_feed = null;
    } else {
        // Load the RSS feed data
        $rss_feed = simplexml_load_string($data);
        if ($rss_feed === false) {
            // Handle XML parsing errors
            error_log("Failed to parse RSS feed");
            $rss_feed = null;
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSS Feed</title>
    <style>
        /* Add your styles here */
        body {
            font-family: Arial, sans-serif;
        }
        .rss-item {
            margin-bottom: 20px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
        }
        .rss-item h2 {
            font-size: 1.5em;
            margin: 0 0 10px;
        }
        .rss-item p {
            margin: 0 0 10px;
        }
        .rss-item a {
            color: #1a0dab;
        }
    </style>
</head>
<body>
    <h1>RSS Feed</h1>
    <div id="rss-feed">
        <?php if ($rss_feed !== null): ?>
            <?php foreach ($rss_feed->channel->item as $item): ?>
                <div class="rss-item">
                    <h2><a href="<?= htmlspecialchars($item->link) ?>" target="_blank"><?= htmlspecialchars($item->title) ?></a></h2>
                    <p><?= htmlspecialchars($item->description) ?></p>
                    <p><small><?= htmlspecialchars($item->pubDate) ?></small></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Failed to fetch RSS feed.</p>
        <?php endif; ?>
    </div>
</body>
</html>

