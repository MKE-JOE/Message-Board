<?php
include 'db.php';

$sql = "SELECT * FROM messages ORDER BY id DESC";
$result = $conn->query($sql);

$messages = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $row['message'] = preg_replace('/\\\\(?=[\'"\\\\])/', '', $row['message']);
        $row['timestamp'] = date("Y/m/d", strtotime($row['created_at']));
        $messages[] = $row;
    }
}

echo json_encode($messages);
?>
