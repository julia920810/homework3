<?php
require('merchant_todoModel.php');

$act=$_REQUEST['act'];
switch ($act) {
    case "listproduct":
        $products = getproductList();
        echo json_encode($products);
        return;
    case "addproduct":

        $jsonStr = $_POST['dat'];
        $products = json_decode($jsonStr);
        //verify
        addproduct($products->name, $products->illustrate,$products->price,$product->id);
        return;
    case "delproduct":
        $id = (int)$_REQUEST['id'];
        //verify
        delproduct($id);
        return;
	case "updateproduct":
	    $id = (int)$_REQUEST['id'];
        $jsonStr = $_POST['dat'];
        $products = json_decode($jsonStr);
        updateproduct($id,$products->name, $products->illustrate,$products->price);
        return;
    
    default:

}


?>