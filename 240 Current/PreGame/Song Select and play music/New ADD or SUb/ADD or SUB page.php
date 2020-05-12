<?php
$username=null;
session_start(); 
$username = $_SESSION['username'];
if($username==null){
	header("Location: ../Login/Login.php");
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
				
				<!-- change runner.php to actaulyl redierct page -->
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
				</script>
	</body>
</html>