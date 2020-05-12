<?php
require_once '../misc/files.php';
require_once '../misc/config.php';
echo "<pre>";
extract($_POST);
$username=null;
session_start(); 
$username = $_SESSION['username'];
if($username==null){
	header("Location: ../Login/Login.php");
}
echo "<div style ='font:27px/21px Arial,tahoma,sans-serif;color:#ff00ff'> WELCOME $username </div>";
echo "<div style ='font:23px/21px Arial,tahoma,sans-serif;color:#000080'> your highscore for addition is ".gethighscore($username)."</div>";
echo "<div style ='font:23px/21px Arial,tahoma,sans-serif;color:#000080'> your highscore for subtraction is ".getsubscore($username)."</div>";

function gethighscore($username){
	$all_user = get_user_info(USERFILE);
	foreach($all_user as $key=>$item){
		if ($key==$username){
			return $item['userscore'];
		}
	}
}
function getsubscore($username){
	$all_user = get_user_info(USERFILE);
	foreach($all_user as $key=>$item){
		if ($key==$username){
			return $item['subscore'];
		}
	}
}
?>
<!DOCTYPE html>

	<head>
		<meta charset="UTF-8">
		<title> Welcome to Music Math</title>
	</head> 
	<style type="text/css">
			body{
				font-family: Monaco; //change everything after sans to change font
			}    
	</style>
	<body>
		<fieldset>
	
		<legend>Welcome To Music Math</legend>
		
		<!-- change runner.php to actaulyl redierct page -->
			
			<a href="../PreGame/Song Select and play music/New ADD or SUb/ADD or SUB page.php">
			<input type="image" id="sart" alt="start" src="Start.png" height="120" width="160">
			</a>
			
			<a href="../../Login/Login.php">
			<input type="image" id="logout" alt="logout" src="quit.png" height="100" width="150">	
			</a>
		</fieldset>
	</body>
</html>
<?php
	$all_user = get_user_info(USERFILE);
	$namesandscores= array();
	foreach($all_user as $key=>$item){
		$namesandscores[$key]=$item['userscore'];

	}
	arsort($namesandscores);
	echo "<div style ='font:31px/21px Arial,tahoma,sans-serif;color:#000080'> High scores for addition</div>";
	$counter=0;
	foreach ($namesandscores as $key => $val) {
		if($counter<5){
    		echo "$key = $val\n\n";
    		$counter++;
    	}
	}		
	$namesandsubscores= array();
	foreach($all_user as $key=>$item){
		$namesandsubscores[$key]=$item['subscore'];

	}
	arsort($namesandsubscores);
	echo "<div style ='font:31px/21px Arial,tahoma,sans-serif;color:#ff0000'> High scores for subtraction</div>";
	$counter=0;
	foreach ($namesandsubscores as $key => $val) {
		if($counter<5){
    		echo "$key = $val\n";
    		$counter++;
    	}
	}		



?>	
	
