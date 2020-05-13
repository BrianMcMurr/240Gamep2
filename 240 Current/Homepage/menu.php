<?php
require_once '../misc/files.php';
require_once '../misc/config.php';
echo "<pre>";
extract($_POST);
//checks to see if user has a username if they dont redirects to login
$username=null;
session_start(); 
$username = $_SESSION['username'];
if($username==null){
	header("Location: ../Login/Login.php");
}
echo "<div style ='font:27px/21px Arial,tahoma,sans-serif;color:#ff00ff'> WELCOME $username </div>";
echo "<div style ='font:23px/21px Arial,tahoma,sans-serif;color:#000080'> your highscore for addition is ".gethighscore($username)."</div>";
echo "<div style ='font:23px/21px Arial,tahoma,sans-serif;color:#000080'> your highscore for subtraction is ".getsubscore($username)."</div>";
//gets user highscore
function gethighscore($username){
	$all_user = get_user_info(USERFILE);
	foreach($all_user as $key=>$item){
		if ($key==$username){
			return $item['userscore'];
		}
	}
}
//gets user highscore for subtraction
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
<html>
<audio src=../PreGame/MusicPic/MenuSong.mp3 autoplay="true">
<div style="border: 1px solid black ; padding: 1px ;">
Sorry, your browser does not support the <audio> tag.
</div>
</audio>
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
			
			<a href="../PreGame/Song Select and play music/New ADD or SUb/ADD or SUB page.php" style="text-decoration: none"><img id="sart" alt="start" src="Start.png" height="120" width="160"></a><br/>
			<a href="../Login/Login.php" style= "text-decoration: none"><img id="logout" alt="logout" src="quit.png" height="120" width="160" ></a>
		</fieldset>
	</body>
</html>
<?php
// creates array with users and their scores
	$all_user = get_user_info(USERFILE);
	$namesandscores= array();
	foreach($all_user as $key=>$item){
		$namesandscores[$key]=$item['userscore'];

	}
	//sorts by score
	arsort($namesandscores);
	echo "<div style ='font:31px/21px Arial,tahoma,sans-serif;color:#000080'> High scores for addition</div>";
	$counter=0;
	//prints top 5 score
	foreach ($namesandscores as $key => $val) {
		if($counter<5){
    		echo "$key = $val\n\n";
    		$counter++;
    	}
	}
	//same as above but for negative
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
	
