<?php
// Define the URL of the Google News RSS feed
$rss_url = "https://news.google.com/rss/search?q=%22Native+American%22+Food+Sovereignty&hl=en-US&gl=US&ceid=US:en";

// Initialize a cURL session
$ch = curl_init();

// Set the cURL options
curl_setopt($ch, CURLOPT_URL, $rss_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Skip SSL certificate verification (optional)

// Execute the cURL request
$rss_content = curl_exec($ch);

// Check for cURL errors
if (curl_errno($ch)) {
    echo 'cURL error: ' . curl_error($ch);
    curl_close($ch);
    exit;
}

// Get the HTTP response status code
$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// Close the cURL session
curl_close($ch);

if ($http_status != 200 || $rss_content === false) {
    echo "Failed to fetch RSS feed. HTTP Status: $http_status";
    exit;
}

// Save the fetched content to an XML file
$output_file = 'rss_feed.xml';
file_put_contents($output_file, $rss_content);

echo "RSS feed fetched and saved to $output_file";
