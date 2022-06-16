<?php
if(isset($_POST['action'])){
    require_once("../../../cnf/Admin.php");
    $obj = new Admin();
    header('content-Type: application/json');
    switch ($_POST['action']){
        case 'LoadDelivery':
            echo $obj->LoadDelivery();
            break;
    }
}
?>