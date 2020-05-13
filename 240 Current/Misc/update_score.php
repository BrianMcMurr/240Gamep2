<?php
require_once 'files.php';
require_once 'config.php';
echo "<pre>";

session_start();
$username = $_SESSION['username'];
$postVar = json_decode(file_get_contents('php://input'));

$score = $postVar->score;
$gameType = $postVar->gameType;
error_log("score: ". $score . " username: ". $username);

if($gameType="addition"){
checkScore($username,$score);	
}
else{
checkSubScore($username,$score);
}

// checks if currentscore is higher than highscore if it is sends to update score
function checkScore($name, $score){
	$all_user = get_user_info(USERFILE);
	foreach($all_user as $key=>$item){
		if ($key==$name){
			$userscore=$item['userscore'];
			if($userscore<$score){
				echo(" US:".$userscore);
				updateScore($name, $score, $all_user);
			
			}
		}
	}
}

// updates highscore
function updateScore($name, $score, $users){
	$str ="";
	foreach($users as $key=>$item){
		if($key==$name){
			$item['userscore']=$score;
		}
		$str .= $item['username']." ".$item['password']." ".$item['class']." ".$item['userscore']." ".$item['subscore'];
	}
	update_file(USERFILE,$str);
}
// same as above but for negative game mode
function checkSubScore($name, $score){
	$all_user = get_user_info(USERFILE);
	foreach($all_user as $key=>$item){
		if ($key==$name){
			$subscore=$item['subscore'];
			if($subscore<$score){
				echo(" US:".$subscore);
				updateSubScore($name, $score, $all_user);
			
			}
		}
	}
}
function updateSubScore($name, $score, $users){
	$str = "";
	foreach($users as $key => $item){
		if($key == $name){
			$item['subscore']=$score;
		}
		$str.= $item['username']." ".$item['password']." ".$item['class']." ".$item['userscore'].$item['subscore'];
	}
	update_file(USERFILE,$str);
}

?>