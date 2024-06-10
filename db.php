<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "sql.freedb.tech";
$username = "freedb_EagleSD";
$password = "M?H*vkC?eTGg$5h";
$dbname = "freedb_eagle-sundance-messages";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


