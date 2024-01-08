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
        $requestData = json_decode(file_get_contents('php://input'), true);
        var_dump($requestData);
        $id = isset($requestData['id']) ? (int)$requestData['id'] : 0;
        $quantity = isset($requestData['quantity']) ? (int)$requestData['quantity'] : 0;
        $custID = isset($requestData['custID']) ? (int)$requestData['custID'] : 0;
        $merchantID = isset($requestData['merchantID']) ? (int)$requestData['merchantID'] : 0;
        echo "id: " . $id;
        echo "quantity: " . $quantity;
        echo "custID: " . $custID;
        
        // 不再使用此行：$custID = isset($requestData['custID']) ? (int)$requestData['custID'] : 0;
        
        if ($id > 0 && $quantity > 0) {
            addCart($id, $quantity, $custID, $merchantID);
            // 不再使用此行：addCart($id, $quantity, $custID);
            // addCart($id, $quantity, $_SESSION['custID']); // 使用 session 中的 custID
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
        $OrderID = (int)$_REQUEST['OrderID'];
        $merchantID = (int)$_REQUEST['merchantID'];

        if ($orderId > 0 && $evaluation > 0 && $evaluation <= 5) {
            submitEvaluation($evaluation, $OrderID, $merchantID, $custID);
            echo "評價提交成功";
        } else {
            echo "無效的評價參數";
        }
        return;
    case "completeOrder":
        $orderId = isset($_REQUEST['orderId']) ? (int)$_REQUEST['orderId'] : 0;
    
        if ($orderId > 0) {
            completeOrder($orderId);
            echo json_encode(['success' => true, 'message' => '訂單完成成功']);
        } else {
            echo json_encode(['success' => false, 'message' => '無效的訂單ID']);
        }
        return;
    case "orderEvaluate":
        $orderID = (int)$_REQUEST['orderID'];
        $merchantID = (int)$_REQUEST['merchantID'];
        $custID = (int)$_REQUEST['custID'];
        $orders = orderEvaluate($orderID, $merchantID, $custID);
        echo json_encode($orders);
        return;

    default:
}
?>
