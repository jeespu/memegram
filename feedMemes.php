<?php 	
	session_start();
	//for ($i = 0; $i < 2; $i++) {
		echo $_SESSION["posts"][0];
		array_shift($_SESSION["posts"]);
	//}
?>