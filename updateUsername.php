<?php require "connect.php";
session_start();

$loggedID = $_SESSION['userID'];
$newUsername = $_POST['uusikayttajanimi'];

$sql = "UPDATE user SET username='$newUsername' WHERE userID='$loggedID'";

if ($conn->query($sql) === TRUE) {
  header("location: profile.php");
}

?>
