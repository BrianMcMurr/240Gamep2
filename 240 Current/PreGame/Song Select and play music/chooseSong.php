<!DOCTYPE html>
<html>
<head>
		<meta charset="UTF-8">
		<title> Choose a Song:</title>
	</head> 
	<style type="text/css">
			body{
				font-family: Monaco; 
			}    
	</style>
	<body>
		<fieldset>
		<p> gameType <?php echo $_POST['gameType'];?></p>
		<legend>Choose a Song</legend>
		<!--
		<input type="button" onClick="window.location='http://example.com?var=<?php echo $var ?>'">
			
		<a href="page.php?value_key=some_value">Link</a>-->
			<script>
				console.log(document.getElementById('addsub').value);
			</script>

			<form action="../../GameFiles/smoothemove.php" id="songSelect" method="post">
				<input type = "hidden" id = "gameType" name ="gameType"value = "<?php echo $_POST['gameType'];?>">
				<input type="hidden" id = "song" name="song" value="">
			<img onclick="setSong('EverytimeWeTouch')" id="sart" alt="start" src="../../MusicPic/EverytimeWeTouch.jpg" height="200" width="200">
            <img onclick="setSong('HannahMontana')" id="sart" alt="start" src="../../MusicPic/HannahMontana.jpg" height="200" width="200">
            <img onclick="setSong('In_The_Jungle')" id="sart" alt="start" src="../../MusicPic/In_the_Jungle.jpg" height="200" width="200">
			<img onclick="setSong('Revenge')" id="sart" alt="start" src="../../MusicPic/Revenge.jpg" height="200" width="200">
			<img onclick="setSong('TNT')" id="sart" alt="start" src="../../MusicPic/TNT.jpg" height="200" width="200">
			<img onclick="setSong('WhatMakesYouBeautiful')" id="sart" alt="start" src="../../MusicPic/WhatMakesYouBeautiful.jpg" height="200" width="200">
			</form>
			<a href="../../Login/Login.php">
			<input type="image" id="logout" alt="logout" src="../../MusicPic/quit.png" height="100" width="150">	
			</a>
		</fieldset>
		<script type="text/javascript">
			function setSong(song){
				document.getElementById('song').value = song;
				document.getElementById('songSelect').submit();
			}
		</script>
	</body>
</html>

