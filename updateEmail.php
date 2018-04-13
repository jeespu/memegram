<?php require "connect.php";
session_start();

$loggedID = $_SESSION['userID'];
$newEmail = $_POST['uusiemail'];

$sql = "UPDATE user SET email='$newEmail' WHERE userID='$loggedID'";

if ($conn->query($sql) === TRUE) {
  header("location: profile.php");
}

?>
