<?php
require 'connect.php';
session_start();
//Check if session is on
if ($_SESSION['logged_user'] == "") {
	header("Location: index.php");
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
		/* margin: 0 5px 0 5px; */
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
	</style>
</head>

<body>

<!-- Background Gradient -->
<div id="bg-gradient" style="background: linear-gradient(to bottom, #f58928, #351b5d);"></div>

<!-- Notification banner -->
<div class="notification">
	Welcome Back <?php echo $_SESSION['logged_user'] ?>!
</div>

<!-- Navbar -->
<nav id="navbar" class="navbar fixed-top navbar-expand-md navbar-dark bg-dark feed-nav">
	<a id="logo" class="navbar-brand" href="#">Memegram</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-content" aria-controls="navbar-content"
	aria-expanded="false" aria-label="Toggle navigation">
	<span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbar-content">
	<ul class="navbar-nav ml-auto">
		<li class="nav-item">
			<a class="nav-link add-meme no-focus" href="#add-meme-form" id="add-meme-dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Add Meme<i class="fas fa-plus ml-2"></i></a>
			<!-- Add meme Dropdown -->
			<div id="add-meme-form" class="nav-item dropdown-menu dropdown-menu-right" aria-labelledby="add-meme-dropdown">
				<form action="linkMeme.php" method="POST">
					<!-- For uploading files, not yet implemented -->
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
			<a id="top-rated" href="#">Top Rated</a>
		</li>
		<li class="d-flex align-items-center my-2">
			<div class="filter-item d-inline-flex pr-2 justify-content-center">
				<i class="fas fa-chart-line item-regular"></i>
				<i style="background:#fff; color:#222; border:1px solid #fff;border-radius:3px;"class="fas fa-chart-line item-solid"></i>
			</div>
			<a id="trending" href="#">Trending</a>
		</li>
		<li class="d-flex align-items-center my-2">
			<div class="filter-item d-inline-flex pr-2 justify-content-center">
				<i class="far fa-image item-regular"></i>
				<i class="fas fa-image item-solid"></i>
			</div>
			<a id="my-memes" href="#">My Memes</a>
		</li>
		<li class="d-flex align-items-center">
			<div class="filter-item d-inline-flex pr-2 justify-content-center">
				<i class="far fa-bookmark item-regular"></i>
				<i class="fas fa-bookmark item-solid"></i>
			</div>
			<a id="saved-memes" href="#">Saved Memes</a>
		</li>
	</ul>
</div>

<!-- For enlarging Memes -->
	<div id="pop-up">
		<img class="rounded select-disable" draggable="false"/>
	</div>

<!-- Meme Feed-->
<div id="feed-content" class="container-fluid">

	<div class="row meme-row justify-content-around">
		<?php

		// Get id of the latest post for setInterval()
		$latestPost = mysqli_query($conn, "SELECT postID FROM post ORDER BY postID DESC;");
		$latestPostRow = mysqli_fetch_array($latestPost, MYSQLI_ASSOC);
		$_SESSION["latestPostID"] = $latestPostRow['postID'];
		
		$posts = array();
		$post = mysqli_query($conn, "SELECT * FROM post ORDER BY postID DESC");

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
						<img class="rounded-circle ml-2" src="%s"><span class="ml-2">%s</span>
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
					$hasModRights = $userrow['modRights'];
					// Add Comment String
					if ( ($userID == $_SESSION['userID']) && ($_SESSION['modRights'] == 1)) {
						$poststring .= sprintf('
						<div id="%s" class="comment-container">
							<div class="comment-author"><strong>%s <span style="color: #f58928" class="ml-1">ADMIN</span></strong></div>
							<div class="row mx-auto">
								<div class="comment col-10">%s</div>
								<div class="delete-comment d-flex align-items-center justify-content-center col-2">
									<i class="far fa-trash-alt item-regular"></i>
									<i class="fas fa-trash-alt item-solid"></i>
								</div>
							</div>
						</div>', $commentID, $username, $content);
					} else if (($userID == $_SESSION['userID']) || $_SESSION['modRights'] == 1 )  {
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
					echo array_shift($_SESSION["posts"]);
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

		<div id="meme-row-center" class="col-md-4 col-sm-6">
			<?php
				for ($i = 0; $i < 3; $i++) {
					echo array_shift($_SESSION["posts"]);
				}
			?>
		</div> <!-- meme-row-center -->


		<div id="meme-row-right" class="col-md-4 col-sm-6">
			<?php
				for ($i = 0; $i < 3; $i++) {
					echo array_shift($_SESSION["posts"]);
				}
			?>
		</div> <!-- meme-row-right-->
	</div><!-- meme-row -->
	<div id="loader-container">
		<div id="loader" class="d-flex col-md-10 justify-content-center"><div><h1>Loading <span>.</span> <span>.</span> <span>.</span></h1></div></div>
	<div>
</div><!-- feed-content -->

<!-- rating/tooltip -->
<!-- <div class="rating"></div> -->

<script src="assets/lib/jquery.min.js"></script>
<script src="assets/lib/autosize/autosize.min.js"></script>
<script src="assets/lib/star-rating-svg/src/jquery.star-rating-svg.js"></script>
<script src="https://unpkg.com/popper.js/dist/umd/popper.min.js"></script>
<script src="assets/lib/bootstrap4/js/bootstrap.bundle.min.js "></script>
<script src="assets/lib/font-awesome/js/fontawesome-all.min.js "></script>
<script src="assets/js/master.js"></script>
<script>
	// $(window).on("load", function () { 
	// 	$("#loader").fadeOut();
	// });
	// REFRESH
	window.setInterval(function () {
		$.ajax({
			type: "GET",
			url: "refreshMemes.php",
			success: function (text) {
				$('#meme-row-left').prepend(text);
			}
		});
		// Delete duplicate ids
		// $('[id]').each(function () {
		// 	var ids = $('[id="' + this.id + '"]');
		// 	// remove duplicate IDs
		// 	if (ids.length > 1 && ids[0] == this) {
		// 		$('#' + this.id).remove();
		// 	}
		// });
		//console.log("deleted duplicate ids");
		//console.log("refreshMemes");
		reattachHandlers();
	}, 20000)


	$(".ratings").starRating({
		//initialRating: $(this).attr("id"),
		useFullStars: true,
		strokeColor: '#351b5d',
		strokeWidth: 0,
		starSize: 25,
		starShape: 'rounded',
		hoverColor: '#f58928',
		activeColor: '#f58928',
		ratedColor: '#f07408',
		// useGradient: true,
		starGradient: {
			start: '#f58928',
			end: '#f07408'
		},
		callback: function (currentRating, $el) {
			var id = $el.parents(".meme-container").attr("id");
			//console.log($el);
			$.ajax({
				type: "POST",
				url: "rate.php",
				data: {
					rating: currentRating,
					postID: id,
				},
				//dataType: 'json',
				success: function () {
					console.log("Rated: " + currentRating + " stars to post ID " + id);
					//$el.attr("data-rating", data.avgRating)
				}
			});
		},
	});

	// Infinity scroll
	$(window).one("scroll", function getMemes() {
		var height = $(this).height() + 100; 
		if ($(this).scrollTop() + height >= $(document).height()) {
			$(window).off("scroll");
			var response;
			// If on mobile, add only one pick
			if (window.innerWidth > 768) {
				$.ajax({ type: "GET",   
					url: "feedMemes.php",   
					async: false,
					success : function(text) {
						response = text;
					}
				});
				$('#meme-row-left').append(response);
			}
			if (window.innerWidth > 576) {
				$.ajax({ 
					type: "GET",   
					url: "feedMemes.php",   
					async: false,
					success : function(text){
						response = text;
					}
				});
				$('#meme-row-center').append(response);
			}
			$.ajax({ type: "GET",   
				url: "feedMemes.php",   
				async: false,
				success : function(text){
					response = text;
				}
			});
			$('#meme-row-right').append(response);
			// Reattach event handlers after ajax-calls
			reattachHandlers();
			//$(window).off("scroll", getMemes);

		}
		$(window).one("scroll", getMemes);
	});
</script>
</body>

</html>
