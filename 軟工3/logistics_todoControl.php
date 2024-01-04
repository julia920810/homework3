<?php
require('logistics_todoModel.php');

$act=$_REQUEST['act'];
switch ($act) {
    case "shipping"://列出寄送中清單
        $status = shipping();
        echo json_encode($status);
        return;

    case "Notdelivered"://列出已寄送清單
        $status = Notdelivered();
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