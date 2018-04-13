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
       exit();
   } else {
      // If error occurs
      echo "Error: " . $sql . "<br>" . $conn->error;
      die();
   }

   // Update avgRating
   // $sql2 = "UPDATE avgRating SET AVG(select rating from rating where whichPost='$postID')";
   // if ($conn->query($sql2) === TRUE) {
   //       exit();
   // } else {
   //       // If error occurs
   //       echo "Error: " . $sql . "<br>" . $conn->error;
   //       die();
   // }
   // Close connection
   $conn->close();
?>