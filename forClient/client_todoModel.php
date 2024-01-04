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

    // 驗證 $id、$quantity 和 $custID 是否有效
    if (!is_numeric($id) || !is_numeric($quantity) || !is_numeric($custID) || $quantity <= 0) {
        echo "無效的參數";
        echo "id" . $id;
        echo "quantity" . $quantity;
        echo "custID" . $custID;
        exit;
    }

    // 查詢商品資訊
    $check_sql = "SELECT name, price FROM commodity WHERE id = ?";
    $check_stmt = mysqli_prepare($db, $check_sql);
    mysqli_stmt_bind_param($check_stmt, "i", $id);
    mysqli_stmt_execute($check_stmt);
    $product = mysqli_stmt_get_result($check_stmt)->fetch_assoc();

    if (!$product) {
        echo "錯誤: 無法找到商品";
        exit;
    }

    $productName = $product['name'];
    $productPrice = $product['price'];

    // 檢查購物車是否已存在相同商品
    $check_sql = "SELECT * FROM cart WHERE id = ? AND custID = ?";
    $check_stmt = mysqli_prepare($db, $check_sql);
    mysqli_stmt_bind_param($check_stmt, "ii", $id, $custID);
    mysqli_stmt_execute($check_stmt);
    $existing_item = mysqli_stmt_get_result($check_stmt)->fetch_assoc();

    // 根據存在與否進行不同的處理
    if ($existing_item) {
        // 更新現有商品的數量和價格
        $update_sql = "UPDATE cart SET quantity = quantity + ?, price = ? WHERE id = ? AND custID = ?";
        $update_stmt = mysqli_prepare($db, $update_sql);
        mysqli_stmt_bind_param($update_stmt, "diii", $quantity, $productPrice, $id, $custID);
        $result = mysqli_stmt_execute($update_stmt);
    } else {
        // 新增商品到購物車
        $insert_sql = "INSERT INTO cart (id, name, price, quantity, custID) VALUES (?, ?, ?, ?, ?)";
        $insert_stmt = mysqli_prepare($db, $insert_sql);
        mysqli_stmt_bind_param($insert_stmt, "ssdii", $id, $productName, $productPrice, $quantity, $custID);
        $result = mysqli_stmt_execute($insert_stmt);
    }

    // 檢查操作結果並返回結果
    if (!$result) {
        echo "錯誤: " . mysqli_error($db);
        exit;
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

    $cartList = getCartList($custID);

    if (empty($cartList)) {
        echo json_encode(['success' => false, 'message' => '購物車內容為空，無法結帳']);
        return false;
    }

    $totalPrice = 0;
    foreach ($cartList as $item) {
        $totalPrice += $item['price'] * $item['quantity'];
    }

    $insertOrderSQL = "INSERT INTO `list` (custID, price, status, evaluate) VALUES (?, ?, '未處理', 0)";
    $stmt = mysqli_prepare($db, $insertOrderSQL);
    mysqli_stmt_bind_param($stmt, "ii", $custID, $totalPrice);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        clearCart($custID);
        echo json_encode(['success' => true, 'message' => '結帳成功']);
        return true;
    } else {
        echo json_encode(['success' => false, 'message' => '結帳失敗: ' . mysqli_error($db)]);
        return false;
    }
}


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

function getCustID() {
    global $db;

    $username = 'charlie';

    $sql = "SELECT id, username FROM member WHERE username = ? LIMIT 1";

    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $custID, $resultUsername);

    if (mysqli_stmt_fetch($stmt)) {
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

function completeOrder($orderId) {
    global $db;

    $update_sql = "UPDATE `list` SET status = '已完成' WHERE id = ?";
    $stmt = mysqli_prepare($db, $update_sql);
    mysqli_stmt_bind_param($stmt, "i", $orderId);
    mysqli_stmt_execute($stmt);
}
?>
