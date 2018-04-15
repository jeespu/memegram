<?php
// Connect to database
require "connect.php";

$user = $_POST['loginusername'];

$result = mysqli_query($conn, "SELECT password, userID, modRights FROM user WHERE username = '$user'");
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$dbpass = $row['password'];
$userID = $row['userID'];

if(password_verify($_POST['loginpassword'], $dbpass)) {
    // Redirect to Feed-page
    header("Location: feed.php");
    session_start();
    // session variables
    $_SESSION['logged_user'] = $user;
    $_SESSION['userID'] = $userID;
    exit();
} else {
    header("Location: index.php");
    echo '
    <script>
        $("body").append("<div class=\'notification\'>Invalid username or password.</div>)
    </script>';
    die();
}
$conn->close();
?>