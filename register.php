<?php
$servername = "den1.mysql6.gear.host";
$serverusername = "memesite";
$serverpassword = "Vp4F7y!3!0b9";
$dbname = "memesite";

$username = $_REQUEST["username"];
$email = $_REQUEST["email"];
$password = $_REQUEST["password"];

// Create connection
$conn = new mysqli($servername, $serverusername, $serverpassword, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO user (username, email, password)
VALUES ($username, $email , $password)";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
