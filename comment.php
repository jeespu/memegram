<?php
   session_start();
   // Connect to database
   require "connect.php";
   $conn->set_charset("utf8mb4");

   $comment = input($_POST['comment']);
   $postID = $_POST['postID'];
   $user = $_SESSION['userID'];

   $sql = "INSERT INTO comment (content, whoCommented, whichPost) VALUES ('$comment', '$user', ' $postID')";

   if ($conn->query($sql) === TRUE) {
      exit();
   } else {
      // If error occurs
      echo "Error: " . $sql . "<br>" . $conn->error;
      die();
   }
   // Close connection
   $conn->close();

function input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>