<?php
require('todoModel.php');

$act = $_REQUEST['act'];
switch ($act) {
    case "listproduct":
        $products = getproductList();
        echo json_encode($products);
        return;
    case "addproduct": 
        $productname = $_POST['name'];
        $productill = $_POST['ill'];
        $productprice = $_POST['price'];
        //verify
        addproduct($productname, $productill, $productprice);
        return;
    case "delproduct":
        $id = (int)$_REQUEST['id'];
        //verify
        delproduct($id);
        return;
    case "setproduct":
        $id = (int)$_REQUEST['id'];
        //verify
        setproduct($id);
        return;
    default:

}


?>