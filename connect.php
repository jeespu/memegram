<?php
$servername = "den1.mysql6.gear.host";
$username = "memesite";
$password = "Vp4F7y!3!0b9";
$dbname = "memesite";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
