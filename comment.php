<?php
   session_start();
   // Connect to database
   require "connect.php";
   $conn->set_charset("utf8mb4");

   $comment = $_POST['comment'];
   $postID = $_POST['postID'];
   $user = $_SESSION['userID'];

   $sql = "INSERT INTO comment (content, whoCommented, whichPost) VALUES ('$comment', '$user', '$postID')";
  
   if ($conn->query($sql) === TRUE) {
      $last_id = $conn->insert_id; // Get inserted commentID
      $arr = array(
        'lastCommentID'=> $last_id,
      );
      echo json_encode($arr); // Echo to ajax success
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