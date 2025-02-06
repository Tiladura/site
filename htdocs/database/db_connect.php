<?php
$servername = "localhost";
$usernamedb = "root";
$password = "root";
$dbname = "users";

// Create connection
$conn = new mysqli($servername, $usernamedb, $password, $dbname);


// Check connection
if ($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}
if (!$conn->set_charset("utf8mb4")) {
    die("Error loading character set utf8mb4: " . $conn->error);
}

?>
