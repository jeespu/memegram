<?php 
   require "connect.php";
   session_start();
   $user = $_SESSION['userID'];
   $commentstring = "";
   $comment = mysqli_query($conn, "SELECT * FROM comment");
			while ($commentRow = mysqli_fetch_array($comment, MYSQLI_ASSOC)) {
				$commentID = $commentRow['commentID'];
				$content = $commentRow['content'];
				$whoCommented = $commentRow['whoCommented'];
				$whichPost = $commentRow['whichPost'];

				if($whichPost == $postID) {
					// Get username for comment
					$user = mysqli_query($conn, "SELECT username, userID FROM user WHERE userID='$whoCommented'");
					$userrow = mysqli_fetch_array($user, MYSQLI_ASSOC);
					$username = $userrow['username'];
					$userID = $userrow['userID'];
					// Add Comment String
					if (($userID == $_SESSION['userID']) || ($hasModRights == 1) ) {
						$commentstring .= sprintf('
						<div id="%s" class="comment-container">
							<div class="comment-author"><strong>%s</strong></div>
							<div class="row mx-auto">
								<div class="comment col-10">%s</div>
								<div class="delete-comment d-flex align-items-center justify-content-center col-2">
									<i class="far fa-trash-alt item-regular"></i>
									<i class="fas fa-trash-alt item-solid"></i>
								</div>
							</div>
						</div>', $commentID, $username, $content);
					} else {
						$commentstring .= sprintf('
						<div id="%s" class="comment-container">
							<div class="comment-author"><strong>%s</strong></div>
							<div class="row mx-auto">
								<div class="comment col-10">%s</div>
							</div>
						</div>', $commentID, $username, $content);
					}
            }
            echo $commentstring;
         }
      exit();
   // Close connection
   $conn->close();
         
?>