<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
	</head>
	<body>
	<style type="text/css">
				body{
					font-family: Monaco; //change everything after sans to change font
				}    
		</style>

		<img src="victory.png" alt="victory" height="200" width="210">
		
		<?php 
		session_start();
		?>
		
		<p>Your Score: <?php echo $_POST['score'];?></p>
		<! ^implement saved php variabel from above after : -->
		
		<a href="../../Homepage/Updated HomePage/homepage.html">
		<input type="image" id="return" alt="return" src="return home.png"  style="float: left; width: 15%; margin-right: 1%; margin-bottom: 5m;"
		height="100" width="400">

		<! implement php code for missed questions -->
		
	</body>
</html>