<?php
if(isset($_POST['action'])){
	require_once("../../../cnf/Admin.php");
	$obj =  new Admin();
	header('Content-Type: application/json');
	switch ($_POST['action']) {
		case 'GetUsersForReceiveSeals':
		echo $obj->GetUsersForReceiveSeals();
			break;
        case 'LoadSecuritySeals':
            echo $obj->LoadSecuritySeals();
            break;
		
		case 'LoadSealsDepartment':
			echo $obj->LoadSealsDepartment();
			break;

		default:
		echo "Opción Inválida";
		break;
	}
}
?>
