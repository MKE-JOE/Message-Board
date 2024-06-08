<?php
include 'db.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = $_POST['message'];
    $username = $_SESSION['username'];

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO messages (username, message) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $message);
    $stmt->execute();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="HandheldFriendly" content="true">
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex, nofollow">
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="stylesheet" href="css/styles.css">
    <title>Eagle Sundance Message Board</title>
    <!-- Include jQuery from CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            function fetchMessages() {
                $.ajax({
                    url: 'fetch_messages.php',
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('.message-container').empty();
                        $.each(data, function(index, message) {
                            $('.message-container').append(
                                `<div class='message'><span class='timestamp'>${message.timestamp}</span> <strong>${message.username}:</strong> ${message.message}</div>`
                            );
                        });
                    }
                });
            }

            // Fetch messages every 3 seconds
            setInterval(fetchMessages, 3000);

            // Fetch messages initially
            fetchMessages();

            // AJAX form submission
            $('form').submit(function(event) {
                event.preventDefault(); // Prevent default form submission
                $.ajax({
                    url: 'send_message.php',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function() {
                        fetchMessages(); // Refresh messages after submission
                        $('textarea[name="message"]').val(''); // Clear the textarea
                    }
                });
            });

            // Submit form on Enter key press in textarea
            $('textarea[name="message"]').keypress(function(event) {
                if (event.which == 13 && !event.shiftKey) {
                    event.preventDefault(); // Prevent newline insertion
                    $('form').submit(); // Trigger form submission
                }
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <div class="logo-container">
            <img src="apple-touch-icon.png" alt="Logo" class="logo">
        </div>
        <h2>Eagle Sundance Message Board</h2>
        <form method="post" action="send_message.php">
            <textarea name="message" required></textarea>
            <input type="submit" value="Send">
        </form>
        <div class="refresh-container">
            <p>New messages failing to load? Try refreshing. <a href="#" onclick="location.reload();">Refresh</a></p>
        </div>
        <div class="message-container">
            <!-- Messages will be loaded here via AJAX -->
        </div>
        <div class="logout-container">
            <a href="logout.php" class="logout-button">Logout</a>
        </div>
    </div>
</body>
</html>






