<?php
$username=null;
session_start(); 
//starts session allows to check for username 
$username = $_SESSION['username'];
if($username==null){
	header("Location: ../Login/Login.php");
	//if no username(means not logged) does not allows user to play game
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
	</head>
	<body>
		<style type="text/css">
					body{
						font-family: Monaco; 
					}    
			</style>
			<body>
				<fieldset>
			
				<legend>Please Pick A Game Mode</legend>
				
				
					<form action="../../Song Select and play music/chooseSong.php" id="submitForm" method = "post">
						<input type="hidden" id="gameType" name ="gameType" value="">
						<img onclick="setGameType('addition')" id="add" alt="sub" src="add.png" height = 200 width = 200>
						<img onclick="setGameType('subtraction')" id="sub" alt="sub" src="sub.png" height = 200 width = 200>
					</form>
				</fieldset>			
				<script>
					function setGameType(gameType) {
						document.getElementById('gameType').value = gameType;
						console.log(document.getElementById('gameType').value);
						document.getElementById('submitForm').submit();
					}
					//img button rediects while saving value (addidton) picked )
				</script>
	</body>
</html>