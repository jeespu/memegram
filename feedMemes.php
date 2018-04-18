<?php 	
	session_start();
	//if(array_shift($_SESSION["posts"]) != NULL) {
		//for ($i = 0; $i < 1; $i++) { // ammount of memes to be printed
			echo array_shift($_SESSION["posts"]);
	//}else {
	// 	echo '<script>console.log("All Memes on Feed!")</script>';
	// }
?>