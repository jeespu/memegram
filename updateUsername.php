<?php require "connect.php";
session_start();

$loggedID = $_SESSION['userID'];
$newUsername = $_POST['uusikayttajanimi'];

$noDuplicates2 = "SELECT username FROM user WHERE username='$newUsername'";
$dupResult2 = mysqli_query($conn, $noDuplicates2);

if (mysqli_num_rows($dupResult2) > 0) {
  // Found a user with that name.
  header("location: profile.php");
  exit();
}
else {
  // No user with the same name. Updating.
  $sql = "UPDATE user SET username='$newUsername' WHERE userID='$loggedID'";
  if ($conn->query($sql) === TRUE) {
    header("location: profile.php");
    exit();
  }
}



?>
