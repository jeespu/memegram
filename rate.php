<?php
   session_start();
   // Connect to database
   require "connect.php";

   $rating = $_POST['rating'];
   $postID = $_POST['postID'];
   $user = $_SESSION['userID'];

   $sql = "INSERT INTO rating (rating, whoRated, whichPost) 
   SELECT '$rating', userID, postID 
   FROM user, post 
   WHERE userID='$user' and postID='$postID'";

   if ($conn->query($sql) === TRUE) {
   } else {
      // If error occurs
      echo "Error: " . $sql . "<br>" . $conn->error;
      die();
   }

   // Update avgRating
   $updateSql = "UPDATE post SET avgRating = (SELECT avg(rating) FROM rating where whichPost = '$postID') where postID='$postID'";
   if ($conn->query($updateSql) === TRUE) {
         exit();
   } else {
         // If error occurs
         echo "Error: " . $sql . "<br>" . $conn->error;
         die();
   }

   // Close connection
   $conn->close();
?>