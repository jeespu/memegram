<?php
// Connect to database
require "connect.php";

$user = $_POST['loginusername'];

$result = mysqli_query($conn, "SELECT password, userID, modRights FROM user WHERE username = '$user'");
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$dbpass = $row['password'];
$userID = $row['userID'];
$hasModRights = $row['modRights'];

if(password_verify($_POST['loginpassword'], $dbpass)) {
    // Redirect to Feed-page
    header("Location: feed.php");
    session_start();
    // session variables
    $_SESSION['logged_user'] = $user;
    $_SESSION['userID'] = $userID;
    $_SESSION['modRights'] = $hasModRights;
    exit();
} else {
    header("Location: index.php");
    $notification = '<script>
    var notification = "<div class=\'notification\'>Invalid username or password.</div>"; 
    notification.appendTo("body");
    $(".notification").slideDown("fast").css("display", "flex");
	window.setTimeout(function () {
		$(".notification").slideUp("fast");
	}, 2000);
    </script>';
    echo $notification;
    die();
}
$conn->close();
?>