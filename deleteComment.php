<?php
   session_start();
   // Connect to database
   require "connect.php";

   $deletedcommentID = $_POST['deleteID'];
   $deletedcomment = $_POST['deletedComment'];
   $user = $_SESSION['userID'];
   //$_SESSION['modRights'] = $hasModRights;

   $sql = "DELETE FROM comment WHERE commentID='$deletedcommentID' OR content='$deletedcomment'";

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