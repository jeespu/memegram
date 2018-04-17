<?php require "connect.php";
session_start();
$loggedID = $_SESSION['userID'];

$deleteCommentsFromOthers = "DELETE comment FROM comment
INNER JOIN post ON comment.whichPost=post.postID
INNER JOIN user ON post.posterID=user.userID
WHERE posterID='$loggedID'";

$deleteRatings = "DELETE rating
FROM rating
INNER JOIN post ON rating.whichPost=post.postID
INNER JOIN user ON post.posterID=user.userID
WHERE posterID='$loggedID'";

$deleteCommentsFromSelf = "DELETE comment FROM comment WHERE whoCommented='$loggedID'";
$deleteRatingsFromSelf = "DELETE rating FROM rating WHERE whoRated='$loggedID'";
$deletePosts = "DELETE post FROM post WHERE posterID='$loggedID'";
$deleteUser = "DELETE user FROM user WHERE userID='$loggedID'";

$conn->query($deleteCommentsFromOthers);
$conn->query($deleteCommentsFromSelf);
$conn->query($deleteRatings);
$conn->query($deletePosts);
$conn->query($deleteUser);

session_unset();
session_destroy();
exit();
?>
