<?php
require('todoModel.php');

$act=$_REQUEST['act'];
switch ($act) {
case "listProduct":
  $product=getProductList();
  echo json_encode($product);
  return;  
case "addCart":
	$id=(int)$_REQUEST['id'];
	//should verify first
	addCart($id);
	return;
case "checkProduct":
	$item=getCartList();
	echo json_encode($item);
	return;  
default:
  
}

?>