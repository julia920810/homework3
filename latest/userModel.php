<?php
require("dbconfig.php");

function login($username, $password) {
	global $db;
	//verify with DB
	//dangerous way
	//$sql = "select role from user where id='$id' and pwd='$pwd';";
	//$stmt = mysqli_prepare($db, $sql );

	//safer way
	
	$sql = "select Cid from member where username=? and password=?;";
	$stmt = mysqli_prepare($db, $sql );
	mysqli_stmt_bind_param($stmt, "ss", $username, $password);
	

	mysqli_stmt_execute($stmt); //執行SQL
	$result = mysqli_stmt_get_result($stmt); //取得查詢結果
	if($r = mysqli_fetch_assoc($result)) {		
		return $r['Cid'];
	} else {
		return 0;
	}
	
}

function getid($username,$password) {
	global $db;

	$sql = "select id from member where username=? and password=?;";
	$stmt = mysqli_prepare($db, $sql );
	mysqli_stmt_bind_param($stmt, "ss", $username, $password);

	mysqli_stmt_execute($stmt); //執行SQL
	$result = mysqli_stmt_get_result($stmt); //取得查詢結果
	if($r = mysqli_fetch_assoc($result)) {		
		return $r['id'];
	} else {
		return 0;
	}

}

function register($username,$password,$Cid) {
	global $db;

	$sql = "insert into member (username,password,Cid) values (?, ?,?)"; 
	$stmt = mysqli_prepare($db, $sql); //prepare sql statement
	mysqli_stmt_bind_param($stmt, "ssi", $username,$password,$Cid); 
	mysqli_stmt_execute($stmt);  //執行SQL

	return true;
}

function checkregist($username) {
	global $db;

	$sql = "select * from member where username =?;";
	$stmt = mysqli_prepare($db, $sql );
	mysqli_stmt_bind_param($stmt, "s", $username);

	mysqli_stmt_execute($stmt); //執行SQL
	$result = mysqli_stmt_get_result($stmt); //取得查詢結果
	if($r = mysqli_fetch_assoc($result)) {	
		$r['username'];	
		return 1;
	} else {
		return 0;
	}
}

function Mregister($username,$password,$Cid) {
	global $db;


	$sql = "insert into member (username,password,Cid) values (?, ?,?)"; 
	$stmt = mysqli_prepare($db, $sql); //prepare sql statement
	mysqli_stmt_bind_param($stmt, "ssi", $username,$password,$Cid); 
	mysqli_stmt_execute($stmt);  //執行SQL

	return True;
}

?>