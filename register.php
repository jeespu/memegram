<?php
// Report all PHP errors
//error_reporting(-1);

// Connect to database
require "connect.php";

$user = $_POST['username'];
$email = $_POST['email'];
$pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

$noDuplicates = "SELECT username FROM user WHERE username='$user'";
$dupResult = mysqli_query($conn, $noDuplicates);

if (mysqli_num_rows($dupResult) > 0) {
  // Found a user with that name.
  header("Location: index.php");
  exit();
} else if {
  $sql = "INSERT INTO user (username, email, password)
  VALUES ('$user', '$email', '$pass')";

  if ($conn->query($sql) === TRUE) {
      // Get userID
      $result = mysqli_query($conn, "SELECT userID FROM user WHERE username = '$user'");
      $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
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
}
?>
