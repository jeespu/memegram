<?php
$servername = "den1.mysql6.gear.host";
$username = "memesite";
$password = "Vp4F7y!3!0b9";
$dbname = "memesite";

$user = $_REQUEST['username'];
$email = $_REQUEST['email'];
$pass = $_REQUEST['password'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO user (username, email, password)
VALUES ('$user', '$email', 'md5($pass)')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
