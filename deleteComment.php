<?php
   session_start();
   // Connect to database
   require "connect.php";

   $deletedcommentID = $_POST['deleteID'];
   $deletedcomment = $_POST['deletedComment'];
   $user = $_SESSION['userID'];

   $sql = "DELETE FROM `memesite`.`comment` WHERE `commentID`='$deletedcommentID' and whoCommented='$user'";

   if ($conn->query($sql) === TRUE) {
      // Redirect to Feed -page
      // header("Location: feed.php");
      exit();
   } else {
      // If error occurs
      echo "Error: " . $sql . "<br>" . $conn->error;
      die();
   }

   if ($deletedcommentID == "") {
      $sql = "DELETE FROM `memesite`.`comment` WHERE `commentID`='$deletedcommentID' and whoCommented='$user'";

   if ($conn->query($sql) === TRUE) {
      // Redirect to Feed -page
      // header("Location: feed.php");
      exit();
   } else {
      // If error occurs
      echo "Error: " . $sql . "<br>" . $conn->error;
      die();
   }
   }

   // Close connection
   $conn->close();
?>