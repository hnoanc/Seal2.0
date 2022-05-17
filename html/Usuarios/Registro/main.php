<?php
if(isset($_POST['action'])){
	require_once("../../../cnf/Admin.php");
	$obj =  new Admin();
	header('Content-Type: application/json');
	switch ($_POST['action']) {
		case 'GetUsersForReceiveSeals':
		echo $obj->GetUsersForReceiveSeals();
			break;

    /*    case 'AddNewSeals':
            echo $obj->AddSealsFromPurchase($_POST['Data']);
            break;
		case 'GetSuppliers':
				echo $obj->GetSuppliers();
			break;
		default:
		echo "Opción Inválida";
		break;*/
	}
}
?>