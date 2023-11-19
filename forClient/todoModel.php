<?php
require('dbconfig.php');

function getProductList() {
	global $db;
	$sql = "select * from commodity;";
	$stmt = mysqli_prepare($db, $sql ); //precompile sql指令，建立statement 物件，以便執行SQL
	mysqli_stmt_execute($stmt); //執行SQL
	$result = mysqli_stmt_get_result($stmt); //取得查詢結果

	$rows = array(); //要回傳的陣列
	while($r = mysqli_fetch_assoc($result)) {
		$rows[] = $r; //將此筆資料新增到陣列中
	}
	return $rows;
}
function getCartList() {
	global $db;
	$sql = "select * from cart;";
	$stmt = mysqli_prepare($db, $sql ); //precompile sql指令，建立statement 物件，以便執行SQL
	mysqli_stmt_execute($stmt); //執行SQL
	$result = mysqli_stmt_get_result($stmt); //取得查詢結果

	$rows = array(); //要回傳的陣列
	while($r = mysqli_fetch_assoc($result)) {
		$rows[] = $r; //將此筆資料新增到陣列中
	}
	return $rows;
}
function addCart($id) {
    global $db;

    // Assuming $name and $price are obtained from the commodity table
    $sql = "INSERT INTO cart (id, name, price) SELECT id, name, price FROM commodity WHERE id = ?";
    $stmt = mysqli_prepare($db, $sql);

    // Bind the parameter
    mysqli_stmt_bind_param($stmt, "i", $id);

    // Execute the statement
    $result = mysqli_stmt_execute($stmt);

    // Check if the execution was successful
    if ($result) {
        return true;
    } else {
        // You can add error handling here if needed
        return false;
    }
}
?>