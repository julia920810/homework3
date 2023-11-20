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

// function addCart($id) {
// 	global $db;

// 	$sql = "INSERT INTO cart (id, name, price) SELECT id, name, price FROM commodity WHERE id = ?"; //SQL中的 ? 代表未來要用變數綁定進去的地方
// 	$stmt = mysqli_prepare($db, $sql); //prepare sql statement
// 	mysqli_stmt_bind_param($stmt, "isi", $id,$name,$price); //bind parameters with variables, with types "sss":string, string ,string
// 	mysqli_stmt_execute($stmt);  //執行SQL
// 	return True;
// }

function addCart($id, $quantity) {
    global $db;

    // Assuming $name and $price are obtained from the commodity table
    // $sql = "INSERT INTO cart (id, name, price, quantity) SELECT id, name, price, ? FROM commodity WHERE id = ?";
	$check_sql = "SELECT * FROM cart WHERE id = ?";
    $check_stmt = mysqli_prepare($db, $check_sql);
    mysqli_stmt_bind_param($check_stmt, "i", $id);
    mysqli_stmt_execute($check_stmt);
    $existing_item = mysqli_stmt_get_result($check_stmt)->fetch_assoc();

    if ($existing_item) {
        // Item already exists, update the quantity
        $update_sql = "UPDATE cart SET quantity = quantity + ? WHERE id = ?";
        $update_stmt = mysqli_prepare($db, $update_sql);
        mysqli_stmt_bind_param($update_stmt, "ii", $quantity, $id);
        $result = mysqli_stmt_execute($update_stmt);
    } else {
        // Item doesn't exist, insert a new row
        $insert_sql = "INSERT INTO cart (id, name, price, quantity) SELECT id, name, price, ? FROM commodity WHERE id = ?";
        $insert_stmt = mysqli_prepare($db, $insert_sql);
        mysqli_stmt_bind_param($insert_stmt, "ii", $quantity, $id);
        $result = mysqli_stmt_execute($insert_stmt);
    }

    // Bind the parameters
    // mysqli_stmt_bind_param($stmt, "ii", $quantity, $id);

    // Execute the statement
    // $result = mysqli_stmt_execute($stmt);

    // Check if the execution was successful
    if ($result) {
        return true;
    } else {
        // You can add error handling here if needed
        return false;
    }
}


// function updateJob($id, $jobName,$jobUrgent,$jobContent) {
// 	echo $id, $jobName,$jobUrgent,$jobContent;
// 	return;
// }

function delCart($id) {
	global $db;

	$sql = "delete from cart where id=?;"; //SQL中的 ? 代表未來要用變數綁定進去的地方
	$stmt = mysqli_prepare($db, $sql); //prepare sql statement
	mysqli_stmt_bind_param($stmt, "i", $id); //bind parameters with variables, with types "sss":string, string ,string
	mysqli_stmt_execute($stmt);  //執行SQL
	return True;
}
?>