<?php
require('todoModel.php');

$act=$_REQUEST['act'];
switch ($act) {
case "listProduct":
  $product=getProductList();
  echo json_encode($product);
  return;  
case "addCart":
	// echo $id;
	$id = isset($_REQUEST['id']) ? (int)$_REQUEST['id'] : 0;
	$quantity = isset($_REQUEST['quantity']) ? (int)$_REQUEST['quantity'] : 0;
    // Verify the ID before proceeding
	if ($id > 0 && $quantity > 0) {
		addCart($id, $quantity);
	}
    return;
case "delCart":
	$id=(int)$_REQUEST['id']; //$_GET, $_REQUEST
	//verify
	delCart($id);
	return;
case "checkProduct":
	$item=getCartList();
	echo json_encode($item);
	return;  
default:
  
}

?>