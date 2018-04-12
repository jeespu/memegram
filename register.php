<?php
$servername = "den1.mysql6.gear.host";
$username = "memesite";
$password = "Vp4F7y!3!0b9";
$dbname = "memesite";

$user = $_REQUEST['username'];
$email = $_REQUEST['email'];
$pass = password_hash($_REQUEST['password'], PASSWORD_DEFAULT);

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO user (username, email, password)
VALUES ('$user', '$email', '$pass')";

if ($conn->query($sql) === TRUE) {
    // Redirect to Feed -page
    header("Location: http://memeproject.gearhostpreview.com/feed.html", true, 301);
exit();
} else {
    // If error occurs
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>