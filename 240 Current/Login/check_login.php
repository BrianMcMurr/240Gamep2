<?php
require_once '../misc/files.php';
require_once '../misc/config.php';
echo "<pre>";
 /*names of two input: username and password*/
/*foreach($_POST as $key => $val){
    echo "$key:$val\n";
}*/

extract($_POST);


//1: can login 2: user does not exist  3: invaild password
$re = checkLogin($username, $password);
 //Please comment this after completing your checkLogin function  

if($re===1){
	/*Redirect browser*/
	session_start(); 
    $_SESSION['username'] = $username;
	header("Location: ../Homepage/menu.php");

}else{
	echo "Invaild username or password";

	/*Redirect to login.php after 5 seconds*/
    //header("refresh:5; url=login.php");
}


/**
*Returns 1: can login
*		 2: user does not exist
*		 3: invaild password
	*/
function checkLogin($name, $pw){

	$all_user = get_user_info(USERFILE);
	//print_r($all_user);
	foreach($all_user as $key=>$item){
		if ($key==$name){
			$password=$item['password'];
			if(password_verify($pw, $password)){
				return 1;
			
			
			}
			return 3;
		}
	}
	return 2;
    //print_r($all_user);
    //Finish checkLogin function
}


?>
