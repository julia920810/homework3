<?php
require("userModel.php");
//header("Access-Control-Allow-Origin: http://localhost:8000");

$act=$_REQUEST['act'];
switch ($act) {
case "login":
	$username=$_REQUEST['username'];
	$password=$_REQUEST['password'];
	//verify with DB

	$Cid = login($username,$password); //use the login function in userModel
	setcookie('loginRole',$Cid,httponly:true); //another way to restrict the cookie visibility
	//setcookie('loginRole',$role); //another way to restrict the cookie visibility
	if ($Cid > 0) {
		$msg=[
			"msg" => "OK",
			"role" => $Cid
		];
	} else {
		$msg=[
			"msg" => "NO",
			"role" => 0
		];
	}
	echo json_encode($msg);
	return;
	break;
case 'showInfo':
	//檢查是否已登入
	$loginRole=$_COOKIE['loginRole'];
	if ($loginRole>0) {
		$msg="You've logged in. Your role is $loginRole.";
	} else {
		$msg="You need login to use this funtion.";
	}
	echo $msg;
	break;
case 'logout':
	setcookie('loginRole',0,httponly:true);
	//setcookie('loginRole',0);
	break;
case 'register':
	$jsonStr = $_POST['dat'];
    $clientdata= json_decode($jsonStr);

	register($clientdata->username,$clientdata->password,$clientdata->clientrole); //use the login function in userModel

	return;
	break;
default:
}

?>