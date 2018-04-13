<?php
require 'connect.php';
session_start();
//Check if session is on
if ($_SESSION['logged_user'] == "") {
	header("Location: index.html");
}
?>

<!DOCTYPE html>
<html>

<head>
	<!-- Favicon -->
	<link rel="icon" type="image/png" href="assets/img/fav_unicorn.png"/>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
	<title>Meme Site Project</title>
	<!-- <link rel="stylesheet" href="assets/lib/bootstrap.min.css"> -->
	<link rel="stylesheet" href="assets/lib/bootstrap4/css/bootstrap.min.css"/>
	<link rel="stylesheet" href="assets/css/master.css"/>
	<link href="https://fonts.googleapis.com/css?family=Cabin:400,600,700|Luckiest+Guy" rel="stylesheet"/>
	<link rel="stylesheet" href="assets/lib/font-awesome/css/fa-svg-with-js.css"/>
	<!-- Start-rating-svg-css -->
	<style>
		.ratings-row {
			display:none;
		}
		.jq-stars {
		display: inline-block;
		}
		.jq-rating-label {
		font-size: 22px;
		display: inline-block;
		position: relative;
		vertical-align: top;
		font-family: "Cabin", sans-serif;		
		}
		.jq-star {
		width: 100px;
		height: 100px;
		margin: 0 5px 0 5px;
		display: inline-block;
		cursor: pointer;
		}
		.jq-star-svg {
		padding-left: 3px;
		width: 100%;
		height: 100%;
		}
		.jq-star:hover .fs-star-svg path {
		}
		.jq-star-svg path {
		/* stroke: #000; */
		stroke-linejoin: round;
		}
		/* un-used */
		/* .jq-shadow {
		-webkit-filter: drop-shadow( -2px -2px 2px #888 );
		filter: drop-shadow( -2px -2px 2px #888 );
		} */
	</style>
</head>

<body>

	<!-- Background-->
	<div id="bg-gradient" style="background: linear-gradient(to bottom, #f58928, #351b5d);">
	</div>

<!-- Notification banner -->
<div class="notification">
	Welcome Back <?php echo $_SESSION['logged_user'] ?>!
</div>

<!-- Navbar -->
<nav id="navbar" class="navbar fixed-top navbar-expand-md navbar-dark bg-dark feed-nav">
	<a id="logo" class="navbar-brand" href="#">Memegram</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
	aria-expanded="false" aria-label="Toggle navigation">
	<span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarSupportedContent">
	<ul class="navbar-nav ml-auto">
		<li class="nav-item">
			<a class="nav-link dropdown-toggle add-meme" href="#add-meme-form" id="add-meme-dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Add Meme<i class="fas fa-plus ml-2"></i></a>
			<!-- Add meme Dropdown -->
			<div id="add-meme-form" class="nav-item dropdown-menu dropdown-menu-right" aria-labelledby="add-meme-dropdown">
				<form action="linkMeme.php" method="POST">
					<!-- <li>
						<label for="pic">Upload Picture:</label>
						<button class="col-12 orange-btn btn btn-warning fake-pic-button" type="button">Choose File</button>
						<input class="pic-input" type="file" name="pic" accept="image/*">
					</li> -->
					<li>
						<label for="picurl">Picture URL:</label>
						<input name="picurl" type="text" class="form-control" placeholder="Link a meme url here">
					</li>
					<li>
						<button type="submit" class="col-12 orange-btn btn btn-warning">Add Meme</button>
					</li>
				</form>
			</div>
		</li>
		<li>
			<a class="nav-link profile-link" href="profile.php">Profile<i class="far fa-user ml-2"></i></a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="logout.php">Logout<i class="fas fa-sign-out-alt ml-2"></i></a>
		</li>
	</ul>
</div>
</nav>

<!-- Filters -->
<div id="filter-container" class="col-md-2 d-flex justify-content-start">
	<ul id="filter">
		<strong>FILTER</strong>
		<li class="d-flex align-items-center my-2">
			<div class="filter-item d-inline-flex pr-2 justify-content-center">
				<i class="far fa-star item-regular"></i>
				<i class="fas fa-star item-solid"></i>
			</div>
			<a href="#">Top Rated</a>
		</li>
		<li class="d-flex align-items-center my-2">
			<div class="filter-item d-inline-flex pr-2 justify-content-center">
				<i class="fas fa-chart-line item-regular"></i>
				<i style="background:#fff; color:#222; border:1px solid #fff;border-radius:3px;"class="fas fa-chart-line item-solid"></i>
			</div>
			<a href="#">Trending</a>
		</li>
		<li class="d-flex align-items-center my-2">
			<div class="filter-item d-inline-flex pr-2 justify-content-center">
				<i class="far fa-image item-regular"></i>
				<i class="fas fa-image item-solid"></i>
			</div>
			<a href="#">My Memes</a>
		</li>
		<li class="d-flex align-items-center">
			<div class="filter-item d-inline-flex pr-2 justify-content-center">
				<i class="far fa-bookmark item-regular"></i>
				<i class="fas fa-bookmark item-solid"></i>
			</div>
			<a href="#">Saved Memes</a>
		</li>
	</ul>
</div>

<!-- For enlarging Memes -->
<div id="pop-up">
	<img class="rounded select-disable" draggable="false"/> <!-- Korjattu(?) -->
</div>

<!-- Meme Feed-->
<div id="feed-content" class="container-fluid">

	<div class="row meme-row justify-content-around">
		<?php
		$posts = array();
		$post = mysqli_query($conn, "SELECT * FROM post");

      while ($row = mysqli_fetch_array($post, MYSQLI_ASSOC)) {
			$poststring = " ";
         $postID = $row['postID'];
         $pictureSource = $row['pictureSource'];
         $addDate = $row['addDate'];
         $avgRating = $row['avgRating'];
			$posterID = $row['posterID'];

			// Get username and pic with posterID
			$user = mysqli_query($conn, "SELECT username, profilePic FROM user WHERE userID='$posterID'");
			$userrow = mysqli_fetch_array($user, MYSQLI_ASSOC);
			$profilePic = $userrow['profilePic'];
			$username = $userrow['username'];

			// Add Post
			$poststring .= sprintf('
			<div id="%s" class="meme-container rounded my-2">
				<div class="row meme-poster py-2">
					<div class="col-12 pr-auto align-items-center">
						<img class="img-fluid rounded-circle ml-2" src="%s" alt="profile-pic"><span class="ml-2">%s</span><span style="visibility:hidden;" class="ml-auto">%s</span>
					</div>
				</div>
				<div class="row meme-img select-disable ">
					<img class="mx-auto d-block" src="%s">
				</div>
				<div class="row ratings-row text-center">
					<div class="ratings"></div>
				</div>
				<div class="row meme-panel d-flex align-items-center">
					<div class="col-3 d-flex justify-content-start">
						<div class="meme-panel-item d-flex justify-content-center align-items-center">
							<i class="far fa-bookmark item-regular"></i>
							<i class="fas fa-bookmark item-solid"></i>
						</div>
					</div>
					<div class="col-3 d-flex justify-content-center">
						<div class="meme-panel-item d-flex justify-content-center align-items-center">
							<i class="far fa-comment item-regular"></i>
							<i class="fas fa-comment item-solid"></i>
						</div>
					</div>
					<div class="col-3 d-flex justify-content-center">
						<div class="meme-panel-item d-flex justify-content-center align-items-center">
							<i class="far fa-share-square item-regular"></i>
							<i class="fas fa-share-square item-solid"></i>
						</div>
					</div>
					<div class="col-3 d-flex justify-content-end">
						<div class="meme-panel-item star d-flex justify-content-center align-items-center">
							<i class="far fa-star item-regular"></i>
							<i class="fas fa-star item-solid"></i>
						</div>
					</div>
				</div> <!--meme-panel -->
				<div class="comments rounded">', $postID, $profilePic, $username, $addDate, $pictureSource);

			// Add Comments
			$comment = mysqli_query($conn, "SELECT * FROM comment");
			while ($commentRow = mysqli_fetch_array($comment, MYSQLI_ASSOC)) {
				$commentID = $commentRow['commentID'];
				$content = $commentRow['content'];
				$whoCommented = $commentRow['whoCommented'];
				$whichPost = $commentRow['whichPost'];

				if($whichPost == $postID) {
					// Get username
					$user = mysqli_query($conn, "SELECT username, userID, modRights FROM user WHERE userID='$whoCommented'");
					$userrow = mysqli_fetch_array($user, MYSQLI_ASSOC);
					$username = $userrow['username'];
					$userID = $userrow['userID'];
					$hasModRights = $userrow['modRights'];

					// Add Comment String
					if (($userID == $_SESSION['userID']) || ($hasModRights === 1) ) {
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
						<div class="comment-container">
							<div class="comment-author"><strong>%s</strong></div>
							<div class="row mx-auto">
								<div class="comment col-10">%s</div>
							</div>
						</div>', $username, $content);
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
		?>

		<div id="meme-row-left" class="col-md-4">
			<?php
				$leftRow = count($posts) / 3; /* one third  to left side */
				$centerRow = $leftRow * 2;	/* one third  to center side */
				$rightRow = count($posts); /* one third  to right side */
				for ($i = 0; $i < count($posts) / 3; $i++) {
					echo $posts[$i];
				}
			?>
			<script>
				var loggedUser = <?php echo json_encode($_SESSION['logged_user']) ?>
			</script>

	 <!-- <div class="meme-container rounded my-2">
				<div class="row meme-poster py-2">
					<div class="col-12 pr-auto align-items-center">
						<img class="img-fluid rounded-circle ml-2" src="assets/img/avatar/putin-profile.png" alt="profilePic"><span class="ml-2">Putin</span>
					</div>
				</div>
				<div class="row meme-img select-disable ">
					<img class="img-fluid mx-auto d-block" src="https://s14-eu5.startpage.com/cgi-bin/serveimage?url=https://vignette.wikia.nocookie.net/koror-blog-org/images/1/19/This_funny_meme_wins_every_argument_640_high_07.jpg/revision/latest%3Fcb%3D20140801170503&sp=c7f29bf8947a7791ec35cb044a7c78e4">
				</div>
				<div class="row meme-panel d-flex align-items-center">
					<div class="col-3 d-flex justify-content-start">
						<div class="meme-panel-item  d-flex justify-content-center align-items-center">
							<i class="far fa-bookmark item-regular"></i>
							<i class="fas fa-bookmark item-solid"></i>
						</div>
					</div>
					<div class="col-3 d-flex justify-content-center">
						<div class="meme-panel-item d-flex justify-content-center align-items-center">
							<i class="far fa-comment item-regular"></i>
							<i class="fas fa-comment item-solid"></i>
						</div>
					</div>
					<div class="col-3 d-flex justify-content-center">
						<div class="meme-panel-item d-flex justify-content-center align-items-center">
							<i class="far fa-share-square item-regular"></i>
							<i class="fas fa-share-square item-solid"></i>
						</div>
					</div>
					<div class="col-3 d-flex justify-content-end">
						<div class="meme-panel-item d-flex justify-content-center align-items-center">
							<i class="far fa-star item-regular"></i>
							<i class="fas fa-star item-solid"></i>
						</div>
					</div>
				</div>
				<div class="comments rounded">
					<div class="comment-container">
							<div class="comment-author"><strong>%s</strong></div>
							<div class="row mx-auto">
								<div class="comment col-10">%s</div>
								<div class="delete-comment d-flex align-items-center justify-content-center col-2">
									<i class="far fa-trash-alt item-regular"></i>
									<i class="fas fa-trash-alt item-solid"></i>
								</div>
							</div>
						</div>
					</div>
					<div class="comment-container">
						<div class="comment-author"><strong>New comment:</strong></div>
						<div class="comment">
							<form id="comment-form" action="comment.php" method="POST">
								<input type="hidden" name="postID" value="%s">
								<textarea name="comment" placeholder="comment" maxlength="255"></textarea>
								<button type="submit" class="orange-btn btn btn-warning btn-sm">Send</button>
							</form>
						</div>
					</div>
				</div>
			</div> -->

		</div><!-- meme-row-left -->

		<div id="meme-row-center" class="col-md-4">
			<?php
					for ($i = $leftRow; $i < $centerRow; $i++) {
						echo $posts[$i];
					}
			?>
		</div> <!-- meme-row-center -->


		<div id="meme-row-right" class="col-md-4">
			<?php
				for ($i = $centerRow; $i < $rightRow; $i++) {
					echo $posts[$i];
				}
			?>
		</div> <!-- meme-row-right-->

	</div><!-- meme-row -->

</div><!-- feed-content -->

<!-- rating/tooltip -->
<!-- <div class="rating"></div> -->

<script src="assets/lib/jquery.min.js"></script>
<script src="assets/lib/autosize/autosize.min.js"></script>
<script src="assets/lib/star-rating-svg/src/jquery.star-rating-svg.js"></script>
<!-- <script src="https://unpkg.com/popper.js/dist/umd/popper.min.js"></script> -->
<script src="assets/lib/bootstrap4/js/bootstrap.bundle.min.js "></script>
<script src="assets/lib/font-awesome/js/fontawesome-all.min.js "></script>
<script src="assets/js/master.js"></script>
</body>

</html>
