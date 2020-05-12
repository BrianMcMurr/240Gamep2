<?php
require_once 'files.php';
require_once 'config.php';
echo "<pre>";

 /*names of two input: username and password*/
/*foreach($_POST as $key => $val){
    echo "$key:$val\n";
}*/
//echo("username " + $_SESSION['username']);
//$postVar = json_decode($_POST);
session_start();
$username = $_SESSION['username'];
//$entityBody = file_get_contents('php://input');
//error_log("entity: ". $entityBody);
$postVar = json_decode(file_get_contents('php://input'));
//error_log("postVar: ". $postVar);
$score = $postVar->score;
$gameType = $postVar->gameType;
error_log("score: ". $score . " username: ". $username);
/*session_start();
$username = $_SESSION['username'];*/
if($gameType="addition"){
checkScore($username,$score);	
}
else{
checkSubScore($username,$score);
}
//1: can login 2: user does not exist  3: invaild password

function checkScore($name, $score){
	$all_user = get_user_info(USERFILE);
	//print_r($all_user);
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
function checkSubScore($name, $score){
	$all_user = get_user_info(USERFILE);
	//print_r($all_user);
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