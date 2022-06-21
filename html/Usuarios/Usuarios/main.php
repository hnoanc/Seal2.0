<?php
if(isset($_POST['action'])){
	require_once("../../../cnf/Admin.php");
	$obj =  new Admin();
	header('Content-Type: application/json');
	switch ($_POST['action']) {
      case 'LoadUsersInfo':
      echo $obj -> LoadUsersInfo();
      break;
      case 'GetUsersWithOutAccess':
        echo $obj-> GetUsersWithOutAccess();
        break;
        case 'GetDepartments':
          echo $obj-> GetDepartments();
          break;
          case 'UpdateUser':
            echo $obj->UpdateUser($_POST['Data']);
            break;
    }
}
?>