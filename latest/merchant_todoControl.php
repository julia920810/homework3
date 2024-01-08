<?php
require('merchant_todoModel.php');

$act=$_REQUEST['act'];
$custID = isset($_REQUEST['custID']) ? (int)$_REQUEST['custID'] : getCustID();
 // Add this line to get the merchantID from the request
switch ($act) {
    case "listproduct"://列出商品清單
        $merchantID = (int)$_REQUEST['merchantID'];
        $products = getproductList($merchantID);
        echo json_encode($products);
        return;
    case "addproduct"://新增商品

        $jsonStr = $_POST['dat'];
        $merchantID = (int)$_REQUEST['merchantID'];
        $products = json_decode($jsonStr);
        //verify
        addproduct($products->name, $products->illustrate,$products->price,$merchantID);
        return;
    case "delproduct"://刪除商品
        $id = (int)$_REQUEST['id'];
        //verify
        delproduct($id);
        return;
	case "updateproduct"://更改商品資訊
	    $id = (int)$_REQUEST['id'];
        $jsonStr = $_POST['dat'];
        $products = json_decode($jsonStr);
        updateproduct($id,$products->name, $products->illustrate,$products->price);
        return;
    
    case "Notprocessed"://列出未處理清單
        $merchantID = (int)$_REQUEST['merchantID'];
        $status=getNotprocessed($merchantID); //--> todoModel的Notprocessed()做資料庫的資料處理
        echo json_encode($status);
        return;    

    case "processing"://列出處理中清單
        $merchantID = (int)$_REQUEST['merchantID'];
        $status=getprocessing($merchantID); //--> todoModel的processed()做資料庫的資料處理
        echo json_encode($status);
        return; 
    
    case "updatestatus"://改為處理中
        $id=(int)$_REQUEST['id'];
        updatestatus($id);
        return;

    case "updatestatus2"://改為寄送中
        $id=(int)$_REQUEST['id'];
        updatestatus2($id);
        return;
    default:

}


?>