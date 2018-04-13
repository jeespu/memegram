<?php require "connect.php";
session_start();

$loggedID = $_SESSION['userID'];
$newLastName = $_POST['uusisukunimi'];

$sql = "UPDATE user SET lastName='$newLastName' WHERE userID='$loggedID'";

if ($conn->query($sql) === TRUE) {
  header("location: profile.php");
}

?>
