<?php
include 'db.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/rss+xml; charset=UTF-8");

echo '<?xml version="1.0" encoding="UTF-8" ?>';
echo '<rss version="2.0">';
echo '<channel>';
echo '<title>RSS FEED</title>';
echo '<link>https://eagle-sd-message-board-2eab903cc1ec.herokuapp.com/message.php</link>';
echo '<description>Latest messages from Eagle Sundance</description>';

$result = $conn->query("SELECT * FROM messages ORDER BY id DESC");
while ($row = $result->fetch_assoc()) {
    echo '<item>';
    echo '<title>' . htmlspecialchars($row['username']) . '</title>';
    echo '<description>' . htmlspecialchars($row['message']) . '</description>';
    echo '<link>https://your-chat-app-server.com/message/' . $row['id'] . '</link>';
    echo '<pubDate>' . date(DATE_RSS, strtotime($row['created_at'])) . '</pubDate>';
    echo '</item>';
}

echo '</channel>';
echo '</rss>';

$conn->close();
?>
