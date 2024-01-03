<?php
require('dbconfig.php');

function getProductList() {
    global $db;
    $sql = "SELECT * FROM commodity;";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $rows = array();
    while ($r = mysqli_fetch_assoc($result)) {
        $rows[] = $r;
    }
    return $rows;
}


function getCartList($custID) {
    global $db;
    $sql = "SELECT * FROM cart WHERE custID = ?;";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, "i", $custID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $rows = array();
    while ($r = mysqli_fetch_assoc($result)) {
        $rows[] = $r;
    }
    return $rows;
}

function getOrderList($custID) {
    global $db;
    $sql = "SELECT * FROM list WHERE custID = ?;";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, "i", $custID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $rows = array();
    while ($r = mysqli_fetch_assoc($result)) {
        $rows[] = $r;
    }
    return $rows;
}

function addCart($id, $quantity, $custID) {
    global $db;

    $check_sql = "SELECT * FROM cart WHERE id = ? AND custID = ?";
    $check_stmt = mysqli_prepare($db, $check_sql);
    mysqli_stmt_bind_param($check_stmt, "ii", $id, $custID);
    mysqli_stmt_execute($check_stmt);
    $existing_item = mysqli_stmt_get_result($check_stmt)->fetch_assoc();

    if ($existing_item) {
        // 如果商品已經存在，只需更新商品數量
        $update_sql = "UPDATE cart SET quantity = quantity + ? WHERE id = ? AND custID = ?";
        $update_stmt = mysqli_prepare($db, $update_sql);
        mysqli_stmt_bind_param($update_stmt, "iii", $quantity, $id, $custID);
        $result = mysqli_stmt_execute($update_stmt);
    } else {
        // 如果商品不存在，新增商品連同數量
        $insert_sql = "INSERT INTO cart (id, name, price, quantity, custID) SELECT id, name, price, ?, ? FROM commodity WHERE id = ?";
        $insert_stmt = mysqli_prepare($db, $insert_sql);
        mysqli_stmt_bind_param($insert_stmt, "iii", $quantity, $custID, $id);
        $result = mysqli_stmt_execute($insert_stmt);
    }

    return $result;
}


function delCart($id, $custID) {
    global $db;
    $sql = "DELETE FROM cart WHERE id = ? AND custID = ?;";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $id, $custID);
    mysqli_stmt_execute($stmt);

    return true;
}

function checkout($custID) {
    global $db;

    // 取得購物車內容
    $cartList = getCartList($custID);

    if (empty($cartList)) {
        // 購物車內容為空，無需結帳
        echo json_encode(['success' => false, 'message' => '購物車內容為空，無法結帳']);
        return false;
    }

    // 計算總金額
    $totalPrice = 0;
    foreach ($cartList as $item) {
        $totalPrice += $item['price'] * $item['quantity'];
    }

    // 插入至訂單表格
    $insertOrderSQL = "INSERT INTO `list` (custID, price, status, evaluate) VALUES (?, ?, '未處理', 0)";
    $stmt = mysqli_prepare($db, $insertOrderSQL);
    mysqli_stmt_bind_param($stmt, "ii", $custID, $totalPrice);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        // 清空購物車
        clearCart($custID);

        // 返回結帳成功的訊息
        echo json_encode(['success' => true, 'message' => '結帳成功']);
        return true;
    } else {
        // 返回結帳失敗的訊息
        echo json_encode(['success' => false, 'message' => '結帳失敗: ' . mysqli_error($db)]);
        return false;
    }
}



// 例子：清空購物車的實作（需要在您的程式碼中提供）
function clearCart($custID) {
    global $db;
    $sql = "DELETE FROM cart WHERE custID = ?;";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, "i", $custID);
    mysqli_stmt_execute($stmt);
}

function submitEvaluation($orderId, $evaluation) {
    global $db;

    $update_sql = "UPDATE `list` SET evaluate = ? WHERE id = ?";
    $stmt = mysqli_prepare($db, $update_sql);
    mysqli_stmt_bind_param($stmt, "ii", $evaluation, $orderId);
    mysqli_stmt_execute($stmt);
}

?>
