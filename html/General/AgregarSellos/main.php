<?php
if(isset($_POST['action'])){
    require_once("../../../cnf/Admin.php");
    $obj = new Admin();
    header('Content-Type: application/json');
    switch($_POST['action']){
        case 'LoadUsersInfo':
            echo $obj-> LoadUsersInfo();
            break;
        case 'SaveSeals':
            echo $obj-> SaveSeals($_POST['Data']);
            break;
        
        /*algo*/
    }
}