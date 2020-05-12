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
				
	<img src="mario.png" alt="mario" height="200" width="300">
	
		
	<?php 
	session_start();
	//whatever php name is saved as 
	//^save as variable 
	?>
	<! implement php code round score -->
			
	<legend>Your Score: <?php echo $_POST['score'];?></legend>
	<! ^implement saved php variabel from above after : -->
	
	
	<a href="/../Homepage/Updated HomePage/homepage.html">
	<input type="image" id="tryagain" alt="tryagain" src="tryagain.png"  style="float: left; width: 15%; margin-right: 1%; margin-bottom: 5m;"
	height="50" width="700">
	
	
	<?php 
	session_start();
	//whatever php name is saved as 
	//^save as variable 
	?>
	<! implement php code for missed questions -->
	
	</body>
</html>