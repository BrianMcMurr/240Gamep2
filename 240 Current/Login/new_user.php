<?php
	require_once '../misc/files.php';
	require_once '../misc/config.php';

	/******File Handling*******/

	extract($_POST);
	$repeat=false;
	$myfile = fopen(USERFILE, "r") or die("File does not exist");
	$all_user = get_user_info(USERFILE);
	//checks if any input is blank if it is creation fails
	if($username=="" || $password=="" || $class==""){
		header('Location: '.repeatuser.'.'.php);
	}
	// checks to see if the username is taken
	foreach($all_user as $key=>$item){
		if ($key==$username){
			$repeat=true;
		}
	}
	//if username is orginal add it to user system
	if(!$repeat){
		$str="";
	while($line=fgets($myfile)){
		//Convert to array by " " 
		$str.= $line;
	}
	$userscore=0;
	$subscore=0;
	$code=password_hash($password, PASSWORD_DEFAULT);
	$str.= "\n".$username." ".$code." ".$class." ".$userscore." ".$subscore;
	update_file(USERFILE,$str);
	header('Location: '.accountcreated.'.'.php);
	}
	// directs to account creation failiure 
	if($repeat){
	header('Location: '.repeatuser.'.'.php);
}
?>
