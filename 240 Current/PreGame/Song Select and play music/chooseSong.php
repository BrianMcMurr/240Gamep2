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
		<legend>Choose a Song</legend>
		<!--
		<input type="button" onClick="window.location='http://example.com?var=<?php echo $var ?>'">
			
		<a href="page.php?value_key=some_value">Link</a>-->
			<script>
				//console.log(document.getElementById('gameType').value);
			</script>
<p><?php echo $_POST['gameType'] ?></p>
			<form action="../../GameFiles/smoothemove.php" id="songSelect" method="post">
				
				<p><?php 
					//echo $songs[0];
					foreach (glob("../../MusicPic/*.mp3") as $song) {
						$splitSong = explode("MusicPic/",$song);
						$songName = explode(".mp3",$splitSong[1]);
						//echo $splitImg[0]. "<br></br>";
						//$img = $splitSong[0];
						echo "<img onclick= setSong('$songName[0]') id = '$songName[0]' alt = 'start' src = '../../MusicPic/$songName[0].jpg' height = '200' width = '200'>";	
					}
					?></p>
				<input type = "hidden" id = "gameType" name ="gameType"value = "<?php echo $_POST['gameType'];?>">
				<input type="hidden" id = "song" name="song" value="">
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

