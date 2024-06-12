<?php
$servername = "j78.h.filess.io";
$port = "3307";
$username = "eagleSD_stepbestme";
$password = "ccfc30eef9497e073abb73ff14fd95661c54d98d";
$dbname = "eagleSD_stepbestme";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";


