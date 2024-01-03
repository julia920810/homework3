<?php
require('client_todoModel.php');

$act = $_REQUEST['act'];
$custID = isset($_REQUEST['custID']) ? (int)$_REQUEST['custID'] : getCustID();

switch ($act) {
    case "listProduct":
        $product = getProductList();
        echo json_encode($product);
        return;
    case "listOrder":
        $order = getOrderList($custID);
        echo json_encode($order);
        return;
    case "addCart":
        $requestData = json_decode(file_get_contents('php://input'), true); //***
        var_dump($requestData);
        $id = isset($requestData['id']) ? (int)$requestData['id'] : 0;
        $quantity = isset($requestData['quantity']) ? (int)$requestData['quantity'] : 0;
        // 不再使用此行：$custID = isset($requestData['custID']) ? (int)$requestData['custID'] : 0;

        if ($id > 0 && $quantity > 0) {
            // 不再使用此行：addCart($id, $quantity, $custID);
            addCart($id, $quantity, $custID); // 這裡不需要再次指定 $custID
        }
        return;
    case "delCart":
        $id = (int)$_REQUEST['id'];
        delCart($id, $custID);
        return;
    case "checkProduct":
        $item = getCartList($custID);
        echo json_encode($item);
        return;
    case "checkoutCart":
        checkout($custID);
        return;
    case "submitEvaluation":
        $orderId = isset($_REQUEST['orderId']) ? (int)$_REQUEST['orderId'] : 0;
        $evaluation = isset($_REQUEST['evaluation']) ? (int)$_REQUEST['evaluation'] : 0;

        if ($orderId > 0 && $evaluation > 0 && $evaluation <= 5) {
            submitEvaluation($orderId, $evaluation);
            echo "評價提交成功";
        } else {
            echo "無效的評價參數";
        }
        return;
    default:
}
?>
