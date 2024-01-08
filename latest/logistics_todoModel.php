<?php
require('dbconfig.php');

function shipping() {//列出寄送中清單
	global $db;
    $sql = "select * from list where status='寄送中';";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $rows = array();
    while ($r = mysqli_fetch_assoc($result)) {
        $rows[] = $r;
    }
    return $rows;
}

function Notdelivered() {
    global $db;
    $sql = "select * from list where status='已寄送';";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $rows = array();
    while ($r = mysqli_fetch_assoc($result)) {
        $rows[] = $r;
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