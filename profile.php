<?php require 'connect.php';
session_start();
if ($_SESSION['logged_user'] == "") {
		header("Location: index.html");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<!-- Favicon -->
	<link rel="icon" type="image/png" href="assets/img/fav_unicorn.png" />
	<title>Profile</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="assets/lib/bootstrap4/css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css?family=Cabin:400,600,700|Luckiest+Guy" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="assets/css/master.css">
	<style>
		#wrapper {
			background-color: rgba(255, 255, 255, 0.5);
		}

		#profilePic:hover {
			cursor:pointer;
		}
	</style>
</head>

<body>
	<!-- Navbar -->
	<nav id="navbar" class="navbar fixed-top navbar-expand-md navbar-dark bg-dark">
		<a id="logo" class="navbar-brand" href="feed.php">Memegram</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
		   aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item">
					<a class="nav-link" href="#">
						<i class="fas fa-plus"></i>
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="logout.php">Logout</a>
				</li>
			</ul>
		</div>
	</nav>

	<div id="container" class="container-fluid">
		<div class="row justify-content-center">
			<div id="wrapper" class="col-md-8 col-sm-9 col-lg-7 col-xl-6">
					<div id="profileHeader" class="justify-content-center">
						<?php $result = mysqli_query($conn, sprintf("SELECT profilePic FROM user WHERE userID = '%s'",$_SESSION['userID']));
						$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
						$profilePic = $row['profilePic'];?>
						<div id="profilePic" style="background: url('<?php echo $profilePic;?>'); background-size:cover;background-position: center; margin: 50px auto;">
						</div>
						<div id="profilePicForm" class="col-10 mx-auto">
								<form>
									<input type="text" name="profilePicField" class="form-control" placeholder="Paste a new profile picture url..." >
									<button onclick="postProfilePic();" class="orange-btn btn btn-warning" type="submit">Submit</button>
								</form>
							</div>
						<h1 id="userName" class="display-4 text-center" style="margin: 20px auto 0 auto;">
							<?php $result = mysqli_query($conn, sprintf("SELECT username FROM user WHERE userID = '%s'",$_SESSION['userID']));
							$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
							$currentUserName = $row['username'];
							echo $currentUserName?>
						</h1>
						<p id="fullName" class="lead text-center" style="margin: 0 auto;">
							<?php $result = mysqli_query($conn, sprintf("SELECT * FROM user WHERE userID = '%s'",$_SESSION['userID']));
							while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
								$currentFirstName = $row['firstName'];
								$currentLastName = $row['lastName'];
							}
							echo $currentFirstName . " " . $currentLastName ?>
						</p>
						<p id="email" class="text-center" style="margin: 0 auto;">
							<?php $result = mysqli_query($conn, sprintf("SELECT email FROM user WHERE userID = '%s'",$_SESSION['userID']));
							$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
							$currentEmail = $row['email'];
							echo $currentEmail?>
						</p>
					</div>

					<div id="changeStuff">

						<div class="row justify-content-center my-4">
							<button class="btn btn-dark dropdown-toggle d-inline" type="button" id="profile-username" data-toggle="dropdown" aria-haspopup="true"
								aria-expanded="false">
								Change your username
							</button>
							<div id="profile-username">
								<form  class="dropdown-menu">
									<input type="text" name="username" class="form-control" placeholder="Enter a new username..." >
									<button onclick="updateUsername();" name="btnChangeUserName" class="orange-btn btn btn-warning" type="submit">Submit</button>
								</form>
							</div>
						</div>

						<div class="row justify-content-center my-4">
							<button class="btn btn-dark dropdown-toggle" type="button" id="profile-firstName" data-toggle="dropdown" aria-haspopup="true"
								aria-expanded="false">
								Change your first name
							</button>
							<div id="profile-firstName">
								<form class="dropdown-menu">
									<input type="text" name="firstname" class="form-control" placeholder="Enter a new first name..." >
									<button onclick="updateFirstName();" class="orange-btn btn btn-warning" type="submit">Submit</button>
								</form>
							</div>
						</div>

						<div class="row justify-content-center my-4">
							<button class="btn btn-dark dropdown-toggle" type="button" id="profile-lastName" data-toggle="dropdown" aria-haspopup="true"
								aria-expanded="false">
								Change your last name
							</button>
							<div id="profile-lastName">
								<form class="dropdown-menu">
									<input type="text" name="lastname" class="form-control" placeholder="Enter a new last name..." >
									<button onclick="updateLastname();" class="orange-btn btn btn-warning" type="submit">Submit</button>
								</form>
							</div>
						</div>

						<div class="row justify-content-center my-4">
							<button class="btn btn-dark dropdown-toggle" type="button" id="profile-email" data-toggle="dropdown" aria-haspopup="true"
								aria-expanded="false">
								Change your email
							</button>
							<div id="profile-email">
								<form id="profile-email" class="dropdown-menu">
									<input type="text" name="email" class="form-control" placeholder="Enter a new email">
									<button onclick="updateEmail();" class="orange-btn btn btn-warning" type="submit">Submit</button>
								</form>
							</div>
						</div>

					</div>

			</div>
		</div>
	</div>
	<script src="assets/lib/jquery.min.js"></script>
	<script src="assets/lib/bootstrap4/js/bootstrap.bundle.min.js"></script>
</body>

<script src="assets/js/profile.js"></script>

</html>
