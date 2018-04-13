<?php require "connect.php";
session_start();

$loggedID = $_SESSION['userID'];
$newProfilePic = $_POST['uusikuva'];

$sql = "UPDATE user SET profilePic='$newProfilePic' WHERE userID='$loggedID'";

if ($conn->query($sql) === TRUE) {
  header("location: profile.php");
}

?>
