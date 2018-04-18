<?php
session_start();

// remove all session variables
session_unset();

// destroy the session
session_destroy();
?>

<!DOCTYPE html>
<html>

<head>
	<!-- Favicon -->
	<link rel="icon" type="image/png" href="assets/img/fav_unicorn.png"/>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Meme Site Project</title>
	<!-- <link rel="stylesheet" href="assets/lib/bootstrap.min.css"> -->
	<link rel="stylesheet" href="assets/lib/bootstrap4/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/master.css">
	<link href="https://fonts.googleapis.com/css?family=Cabin:400,600,700|Luckiest+Guy" rel="stylesheet">
	<link rel="stylesheet" href="assets/lib/font-awesome/css/fa-svg-with-js.css">
</head>

<body>

	<div class="notification">
		Logged out! See you again soon!
	</div>
	
	<!-- Navbar -->
	<nav id="navbar" class="navbar fixed-top navbar-expand-md navbar-dark bg-dark">
		<a id="logo" class="navbar-brand" href="#">Memegram</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-content" aria-controls="navbar-content"
		   aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbar-content">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item">
					<a class="nav-link sign-up" href="#">Sign Up</a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle no-focus" href="#login" id="login-dropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
					   aria-expanded="false">
						Login
					</a>
					<div id="login" class="nav-item dropdown-menu dropdown-menu-right" aria-labelledby="login-dropdown">
						<form action="login.php" method="POST">
							<li>
								<label for="loginusername">Username:</label>
								<input name="loginusername" type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon1" required>
							</li>
							<li>
								<label for="loginpassword">Password:</label>
								<input name="loginpassword" type="password" class="form-control" placeholder="Password" required>
							</li>
							<li>
								<button type="submit" class="col-12 orange-btn btn btn-warning">Login</button>
							</li>
						</form>
					</div>
				</li>
			</ul>
		</div>
	</nav>

	<div id="bg-container">
		<img id="frontpage-bg" src="assets/img/memes_bg.png">
	</div>
	<div id="content" class="container-fluid">
		<div class="row vertical-center">
			<div class="jumbotron col-md-8">
				<h1>Hello Memes!</h1>
				<p>Do you have the best meme ever on mind, but don't have anyone to share it with? Then you've come to the right place!
					Join now and start sharing your memes with thousands of users.</p>
				<p>
					<a class="sign-up orange-btn btn btn-warning btn-lg" href="#" role="button">Sign Up</a>
				</p>
			</div>
			<div id="sign-form" class="col-md-8">
				<h1>Sign Up
					<a class="cancel-btn">x</a>
				</h1>
				<form action="register.php" method="POST">
					<div class="form-group">
						<label for="username">Username:</label>
						<input name="username" type="text" class="form-control" placeholder="Enter username" required>
					</div>
					<div class="form-group">
						<label for="email">Email address</label>
						<input name="email" type="email" class="form-control" placeholder="Email" required>
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input name="password" type="password" class="form-control" placeholder="Password" required>
					</div>
					<div class="checkbox">
						<label>
							<input type="checkbox" required> I agree to become an obedient servant of Memegram Ltd, and to give up all my property and other resources that the employees
							of Memegram Ltd may find useful.
						</label>
					</div>
					<button type="submit" class="orange-btn btn btn-warning">Submit</button>
				</form>
			</div>
		</div>
	</div>
	<!-- container-->

	<script src="assets/lib/jquery.min.js"></script>
	<!-- <script src="assets/lib/bootstrap.min.js "></script>-->
	<script src="assets/lib/bootstrap4/js/bootstrap.bundle.min.js"></script>
	<script src="assets/lib/font-awesome/js/fontawesome-all.min.js "></script>
	<script src="assets/js/master.js"></script>

</body>

</html>