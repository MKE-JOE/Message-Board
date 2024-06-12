<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "j78.h.filess.io";
$username = "eagleSD_stepbestme";
$password = "ccfc30eef9497e073abb73ff14fd95661c54d98d";
$dbname = "eagleSD_stepbestme";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


