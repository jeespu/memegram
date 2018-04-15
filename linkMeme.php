<?php require 'connect.php';
session_start();

// Fetch the form input
$memeUrl = $_POST['picurl'];
$userID = $_SESSION['userID'];

if ($memeUrl != '') {
    // Trim whitespace from the beginning and the end of the string
    // because copypasta tends to add unnoticeable spaces sometimes
    ltrim($memeUrl);
    rtrim($memeUrl);

    $sql = "INSERT INTO post (pictureSource, posterID) VALUES ('$memeUrl', '$userID')";

       if ($conn->query($sql) === TRUE) {
          // Redirect to Feed -page
          header("Location: feed.php");
          exit();
       } else {
          // If error occurs
          echo "Error: " . $sql . "<br>" . $conn->error;
          die();
       }
       // Close connection
       $conn->close();
}
else { // Means if the string is empty
    header("Location: feed.php");
    exit();
}



?>