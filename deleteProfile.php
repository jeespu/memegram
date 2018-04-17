<?php require "connect.php";
session_start();

echo "asd";
$loggedID = $_SESSION['userID'];

$sql = "BEGIN TRY
BEGIN TRANSACTION
DELETE FROM comment WHERE whoCommented='$loggedID';
DELETE FROM rating WHERE whoRated='$loggedID';
DELETE FROM post WHERE posterID='$loggedID';
DELETE FROM user WHERE userID='$loggedID';
COMMIT
END TRY
BEGIN CATCH
ROLLBACK
END CATCH";

if ($conn->query($sql) === TRUE) {
  header("location: profile.php");
}

?>
