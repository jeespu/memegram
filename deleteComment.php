<?php
   session_start();
   // Connect to database
   require "connect.php";

   $deletedcommentID = $_POST['deleteID'];
   $deletedcomment = input($_POST['deletedComment']);
   $user = $_SESSION['userID'];

   $sql = "DELETE FROM `memesite`.`comment` WHERE `commentID`='$deletedcommentID' and whoCommented='$user'";

   if ($conn->query($sql) === TRUE) {
      exit();
   } else {
      // If error occurs
      echo "Error: " . $sql . "<br>" . $conn->error;
      die();
   }

   if ($deletedcommentID == '') {
      $sql = "DELETE FROM comment WHERE content='$deletedcomment' and whoCommented='$user'";

   if ($conn->query($sql) === TRUE) {
      exit();
   } else {
      // If error occurs
      echo "Error: " . $sql . "<br>" . $conn->error;
      die();
   }
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