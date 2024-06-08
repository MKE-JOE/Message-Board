<?php
include 'db.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$registration_success = false;
if (isset($_SESSION['registration_success'])) {
    $registration_success = true;
    unset($_SESSION['registration_success']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            header("Location: message.php");
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found. <a href='register.php'>Register here</a>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="HandheldFriendly" content="true">
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex, nofollow">
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="stylesheet" href="css/styles.css">
    <title>Eagle Sundance Message Board</title>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php if ($registration_success): ?>
            <p class="success-message">Registration successful! Please log in.</p>
        <?php endif; ?>
        <form method="post" action="">
            Username: <input type="text" name="username" required>
            Password: <input type="password" name="password" required>
            <input type="submit" value="Login">
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
        <p class="note">(You may want to keep record of your login details. This site does not provide password recovery for forgotten passwords.)</p>
    </div>
</body>
</html>






