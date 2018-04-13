<?php require "connect.php";
session_start();

$loggedID = $_SESSION['userID'];
$newFirstName = $_POST['uusietunimi'];

$sql = "UPDATE user SET firstName='$newFirstName' WHERE userID='$loggedID'";

if ($conn->query($sql) === TRUE) {
  header("location: profile.php");
}

?>
