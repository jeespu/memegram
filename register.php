<?php
// Report all PHP errors
//error_reporting(-1);

// Connect to database
require "connect.php";

$user = $_POST['username'];
$email = $_POST['email'];
$pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

$sql = "INSERT INTO user (username, email, password)
VALUES ('$user', '$email', '$pass')";

if ($conn->query($sql) === TRUE) {
    // Get userID
    $result = mysqli_query($conn, "SELECT userID FROM user WHERE username = '$user'");
    $row = mysqli_fetch_array($result, MYSQL_ASSOC);
    $userID = $row['userID'];
    // Redirect to Feed -page
    header("Location: feed.php", true,  301);
    session_start();
    // session variables
    $_SESSION['logged_user'] = $user;
    $_SESSION['userID'] = $userID;
    exit();
} else {
    // If error occurs
    echo "Error: " . $sql . "<br>" . $conn->error;
    die();
}

// Close connection
$conn->close();
?>