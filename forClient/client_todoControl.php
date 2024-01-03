<?php
require('client_todoModel.php');

$act = $_REQUEST['act'];
$custID = isset($_REQUEST['custID']) ? (int)$_REQUEST['custID'] : 1; // 修改這裡，以便在所有地方正確取得 custID
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
        $id = isset($_REQUEST['id']) ? (int)$_REQUEST['id'] : 0;
        $quantity = isset($_REQUEST['quantity']) ? (int)$_REQUEST['quantity'] : 0;
        if ($id > 0 && $quantity > 0) {
            addCart($id, $quantity, $custID);
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