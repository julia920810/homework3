<!-- 109213069 梁心瑜 109213041 林國棟 -->
<?php
require('client_todoModel.php');

$act=$_REQUEST['act'];
switch ($act) {
case "listProduct":
  $product=getProductList(); // --> todoModel的getProductList()做資料庫的資料處理
  echo json_encode($product);
  return;  
case "addCart":
	// echo $id;
	$id = isset($_REQUEST['id']) ? (int)$_REQUEST['id'] : 0;
	$quantity = isset($_REQUEST['quantity']) ? (int)$_REQUEST['quantity'] : 0;
    // Verify the ID before proceeding
	if ($id > 0 && $quantity > 0) { 
		addCart($id, $quantity); //--> todoModel的addCart()做資料庫的資料處理
	}
    return;
case "delCart":
	$id=(int)$_REQUEST['id']; //$_GET, $_REQUEST
	//verify
	delCart($id); //--> todoModel的delCart()做資料庫的資料處理
	return;
case "checkProduct":
	$item=getCartList(); //--> todoModel的getCartList()做資料庫的資料處理
	echo json_encode($item);
	return;  
default:
  
}

?>