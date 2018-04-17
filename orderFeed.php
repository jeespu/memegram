<?php
   require 'connect.php';
   session_start();

   $orderBy = $_POST['orderBy'];
   //if($orderBy == "top-rated") {
      $post = mysqli_query($conn, "SELECT * FROM post ORDER BY avgRating DESC");
   // }

		$posts = array();
		//$post = mysqli_query($conn, "SELECT * FROM post ORDER BY avgRating DESC");

      while ($row = mysqli_fetch_array($post, MYSQLI_ASSOC)) {
			$poststring = " ";
         $postID = $row['postID'];
         $pictureSource = $row['pictureSource'];
         //$addDate = $row['addDate'];
         $avgRating = $row['avgRating'];
			$posterID = $row['posterID'];

			// Get username and pic with posterID
			$user = mysqli_query($conn, "SELECT username, profilePic FROM user WHERE userID='$posterID'");
			$userrow = mysqli_fetch_array($user, MYSQLI_ASSOC);
			$profilePic = $userrow['profilePic'];
			$username = $userrow['username'];

			// Add Post
			$poststring .= sprintf('
			<div id="%s" class="meme-container rounded my-2 pop">
				<div class="row meme-poster py-2">
					<div class="col-12 pr-auto align-items-center">
						<img class="img-fluid rounded-circle ml-2" src="%s"><span class="ml-2">%s</span>
					</div>
				</div>
				<div class="row meme-img select-disable ">
					<img class="mx-auto d-block" src="%s">
				</div>
				<div class="row ratings-row text-center">
					<div data-rating="%s" class="ratings"></div>
				</div>
				<div class="row meme-panel d-flex align-items-center">
					<div class="col-3 d-flex justify-content-start">
						<div class="meme-panel-item d-flex justify-content-center align-items-center" data-toggle="tooltip" data-placement="bottom" title="Save">
							<i class="far fa-bookmark item-regular"></i>
							<i class="fas fa-bookmark item-solid"></i>
						</div>
					</div>
					<div class="col-3 d-flex justify-content-center">
						<div class="meme-panel-item d-flex justify-content-center align-items-center" data-toggle="tooltip" data-placement="bottom" title="Comment">
							<i class="far fa-comment item-regular"></i>
							<i class="fas fa-comment item-solid"></i>
						</div>
					</div>
					<div class="col-3 d-flex justify-content-center">
						<div class="meme-panel-item d-flex justify-content-center align-items-center" data-toggle="tooltip" data-placement="bottom" title="Share">
							<i class="far fa-share-square item-regular"></i>
							<i class="fas fa-share-square item-solid"></i>
						</div>
					</div>
					<div class="col-3 d-flex justify-content-end">
						<div class="meme-panel-item star d-flex justify-content-center align-items-center" data-toggle="tooltip" data-placement="bottom" title="Rate">
							<i class="far fa-star item-regular"></i>
							<i class="fas fa-star item-solid"></i>
						</div>
					</div>
				</div> <!--meme-panel -->
				<div class="comments rounded">', $postID, $profilePic, $username, $pictureSource, $avgRating);

			// Add Comments
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
					if (($userID == $_SESSION['userID']) || $_SESSION['modRights'] == 1 )  {
						$poststring .= sprintf('
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
						$poststring .= sprintf('
						<div id="%s" class="comment-container">
							<div class="comment-author"><strong>%s</strong></div>
							<div class="row mx-auto">
								<div class="comment col-10">%s</div>
							</div>
						</div>', $commentID, $username, $content);
					}
				}
			}

			// Add New Comment String
			$poststring .= sprintf('
			<div class="comment-container new-comment">
				<div class="comment-author"><strong>New comment:</strong>
				</div>
				<div class="comment">
					<div>
						<input type="hidden" >
						<textarea placeholder="comment" maxlength="255"></textarea>
						<button class="orange-btn btn btn-warning btn-sm comment-send">Send</button>
					</div>
				</div>
			</div>
		</div>
	</div>', $postID);
			// Add poststring to array
			$posts[] = $poststring;
		};
		$_SESSION["posts"] = $posts;
?>

<div id="meme-row-left" class="col-md-4 col-sm-6">
			<?php
				for ($i = 0; $i < 3; $i++) {
					echo $_SESSION["posts"][0];
					array_shift($_SESSION["posts"]);
				}
			?>
		</div><!-- meme-row-left -->

		<div id="meme-row-center" class="col-md-4 col-sm-6">
			<?php
				for ($i = 0; $i < 3; $i++) {
					echo $_SESSION["posts"][0];
					array_shift($_SESSION["posts"]);
				}
			?>
		</div> <!-- meme-row-center -->


		<div id="meme-row-right" class="col-md-4 col-sm-6">
			<?php
				for ($i = 0; $i < 3; $i++) {
					echo $_SESSION["posts"][0];
					array_shift($_SESSION["posts"]);
            }
			?>
      </div> 
      <?php echo 'Filter' . $orderBy; ?>