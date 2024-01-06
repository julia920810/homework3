<?php
require('logistics_todoModel.php');

$act=$_REQUEST['act'];
switch ($act) {
    case "shipping":
        $status = shipping();
        echo json_encode($status);
        return;
    
    case "Notdelivered":
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