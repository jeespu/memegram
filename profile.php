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
	    <link rel="icon" type="image/png" href="assets/img/fav_unicorn.png"/>
        <title>Profile</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="assets/css/profile.css">
        <link rel="stylesheet" href="assets/lib/bootstrap4/css/bootstrap.min.css">
        <link href="https://fonts.googleapis.com/css?family=Cabin:400,600,700|Luckiest+Guy" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="assets/css/master.css">
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
                        <a class="nav-link" href="#"><i class="fas fa-plus"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
        
        <div id="container" class="container-fluid">
            <div class="row justify-content-center">
                <div id="wrapper" class="col-lg-6 col-md-8 col-sm-10">
                    <?php
                    $result = mysqli_query($conn, sprintf("SELECT * FROM user WHERE username = '%s'",$_SESSION['logged_user']));
                    while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
                        $uname = $row['username'];
                        $firstName = $row['firstName'];
                        $lastName = $row['lastName'];
                        $email = $row['email'];
                        $profilePic = $row['profilePic'];
                    }
                    ?>
                    <div id="profileHeader" class="row">
                        <div id="profilePic" class="col-md-6">
                            <div style="background: url('<?php echo $profilePic;?>'); background-size:cover;background-position: center; margin: 50px auto;">
                            </div>
                        </div>
                        <div id="profileInfo" class="col-md-6">
                            <h1 style="margin: 50px auto 0 auto;"><?php echo $uname ?></h1>
                            <p style="margin: 0 auto;"><?php echo $firstName . " " . $lastName ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="assets/lib/bootstrap4/js/bootstrap.bundle.min.js"></script>
    </body>
</html>