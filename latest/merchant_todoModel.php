<?php
require('dbconfig.php');

function getproductList($merchantID) {//列出商品清單
    global $db;
    // Modify the SQL query to include the merchantID condition
    $sql = "select * from commodity where merchantID = ?;";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, "i", $merchantID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $rows = array();
    while ($r = mysqli_fetch_assoc($result)) {
        $rows[] = $r;
    }
    return $rows;
}

function addproduct($name,$illustrate,$price,$merchantID) {//新增商品
	global $db;
	$sql = "insert into commodity (name, illustrate, price,merchantID) values (?, ?, ?,?)"; //SQL中的 ? 代表未來要用變數綁定進去的地方
	$stmt = mysqli_prepare($db, $sql); //prepare sql statement
	mysqli_stmt_bind_param($stmt, "ssii", $name, $illustrate,$price,$merchantID); //bind parameters with variables, with types "sss":string, string ,string
	mysqli_stmt_execute($stmt);  //執行SQL
	return True;
}

function updateproduct($id,$name,$illustrate,$price) {//更改商品資訊
	global $db;
    
	$sql = "update commodity set name=?, illustrate=?, price=? where id=?"; //SQL中的 ? 代表未來要用變數綁定進去的地方
	$stmt = mysqli_prepare($db, $sql); //prepare sql statement
	mysqli_stmt_bind_param($stmt, "ssii", $name, $illustrate,$price,$id); //bind parameters with variables, with types "sss":string, string ,string
	mysqli_stmt_execute($stmt);  //執行SQL
	return True;

}

function delproduct($id) {//刪除商品
	global $db;

	$sql = "delete from commodity where id=?"; //SQL中的 ? 代表未來要用變數綁定進去的地方
	$stmt = mysqli_prepare($db, $sql); //prepare sql statement
	mysqli_stmt_bind_param($stmt, "i", $id); //bind parameters with variables, with types "sss":string, string ,string
	mysqli_stmt_execute($stmt);  //執行SQL
	return True;
}

function getNotprocessed($merchantID)//列出未處理清單
{
    global $db;
    $sql = "select * from list where status='未處理'and merchantID=?;";
    $stmt = mysqli_prepare($db, $sql);
	mysqli_stmt_bind_param($stmt, "i", $merchantID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $rows = array();
    while ($r = mysqli_fetch_assoc($result)) {
        $rows[] = $r;
    }
    return $rows;
}

function getProcessing($merchantID)//列出處理中清單
{
    global $db;
    $sql = "select * from list where status='處理中'and merchantID=?;";
    $stmt = mysqli_prepare($db, $sql);
	mysqli_stmt_bind_param($stmt, "i", $merchantID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $rows = array();
    while ($r = mysqli_fetch_assoc($result)) {
        $rows[] = $r;
    }
    return $rows;
}

function updatestatus($id) {//改為處理中
	global $db;
    
	$sql = "update list set status='處理中' where id=?"; //SQL中的 ? 代表未來要用變數綁定進去的地方
	$stmt = mysqli_prepare($db, $sql); //prepare sql statement
	mysqli_stmt_bind_param($stmt, "i",$id); 
	mysqli_stmt_execute($stmt);  //執行SQL
	return True;
}

function updatestatus2($id) {//改為寄送中
	global $db;
    
	$sql = "update list set status='寄送中' where id=?"; //SQL中的 ? 代表未來要用變數綁定進去的地方
	$stmt = mysqli_prepare($db, $sql); //prepare sql statement
	mysqli_stmt_bind_param($stmt, "i",$id); 
	mysqli_stmt_execute($stmt);  //執行SQL
	return True;
}

function getCustID() {//利用loginName取得id
    global $db;

    $username = $_COOKIE['loginName'];

    $sql = "SELECT id, username FROM member WHERE username = ? LIMIT 1";

    $stmt = mysqli_prepare($db, $sql);//prepare sql statement
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);//執行SQL
    mysqli_stmt_bind_result($stmt, $custID, $resultUsername);//儲存結果

    if (mysqli_stmt_fetch($stmt)) {//取得資料
        mysqli_stmt_close($stmt);
        $result = ['id' => $custID, 'username' => $resultUsername];
        echo json_encode($result); // 返回 JSON 格式
        return $result;
    } else {
        mysqli_stmt_close($stmt);
        echo json_encode(['error' => '未獲取到有效的custID']); // 返回 JSON 格式
        return false;
    }
}

?>
