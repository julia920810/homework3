<?php
require('merchant_todoModel.php');

$act=$_REQUEST['act'];
$custID = isset($_REQUEST['custID']) ? (int)$_REQUEST['custID'] : getCustID();
 // Add this line to get the merchantID from the request
switch ($act) {
    case "listproduct":
        $merchantID = (int)$_REQUEST['merchantID'];
        $products = getproductList($merchantID);
        echo json_encode($products);
        return;
    case "addproduct":

        $jsonStr = $_POST['dat'];
        $merchantID = (int)$_REQUEST['merchantID'];
        $products = json_decode($jsonStr);
        //verify
        addproduct($products->name, $products->illustrate,$products->price,$merchantID);
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
    
    case "Notprocessed":
        $merchantID = (int)$_REQUEST['merchantID'];
        $status=getNotprocessed($merchantID); //--> todoModel的Notprocessed()做資料庫的資料處理
        echo json_encode($status);
        return;    

    case "processing":
        $merchantID = (int)$_REQUEST['merchantID'];
        $status=getprocessing($merchantID); //--> todoModel的processed()做資料庫的資料處理
        echo json_encode($status);
        return; 
    
    case "updatestatus":
        $id=(int)$_REQUEST['id'];
        updatestatus($id);
        return;

    case "updatestatus2":
        $id=(int)$_REQUEST['id'];
        updatestatus2($id);
        return;
    default:

}


?>