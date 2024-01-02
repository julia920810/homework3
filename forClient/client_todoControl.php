<?php
require('client_todoModel.php');

$act = $_REQUEST['act'];
switch ($act) {
    case "listProduct":
        $product = getProductList();
        echo json_encode($product);
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
		
		
    default:
}
?>
