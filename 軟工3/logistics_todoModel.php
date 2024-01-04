<?php
require('dbconfig.php');

function shipping() {//列出寄送中清單
	global $db;
	$sql = "select id,custID,price,status from list where status='寄送中';";
	$stmt = mysqli_prepare($db, $sql ); //precompile sql指令，建立statement 物件，以便執行SQL
	mysqli_stmt_execute($stmt); //執行SQL
	$result = mysqli_stmt_get_result($stmt); //取得查詢結果

	$rows = array(); //要回傳的陣列
	while($r = mysqli_fetch_assoc($result)) {
		$rows[] = $r; //將此筆資料新增到陣列中
	}
	return $rows;
}

function Notdelivered() {
	global $db;
	$sql = "select id,custID,price,status from list where status='已寄送';";
	$stmt = mysqli_prepare($db, $sql ); //precompile sql指令，建立statement 物件，以便執行SQL
	mysqli_stmt_execute($stmt); //執行SQL
	$result = mysqli_stmt_get_result($stmt); //取得查詢結果

	$rows = array(); //要回傳的陣列
	while($r = mysqli_fetch_assoc($result)) {
		$rows[] = $r; //將此筆資料新增到陣列中
	}
	return $rows;
}

function updatestatus($id) {
	global $db;
    
	$sql = "update list set status='已寄送' where id=?"; //SQL中的 ? 代表未來要用變數綁定進去的地方
	$stmt = mysqli_prepare($db, $sql); //prepare sql statement
	mysqli_stmt_bind_param($stmt, "i",$id); 
	mysqli_stmt_execute($stmt);  //執行SQL
	return True;
}

function updatestatus2($id) {
	global $db;
    
	$sql = "update list set status='已送達' where id=?"; //SQL中的 ? 代表未來要用變數綁定進去的地方
	$stmt = mysqli_prepare($db, $sql); //prepare sql statement
	mysqli_stmt_bind_param($stmt, "i",$id); 
	mysqli_stmt_execute($stmt);  //執行SQL
	return True;
}
?>