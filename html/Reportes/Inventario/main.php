<?php
if(isset($_POST['action'])){
	require_once("../../../cnf/Admin.php");
	$obj =  new Admin();
	header('Content-Type: application/json');
	switch ($_POST['action']) {

		case 'LoadAllSecuritySeals':
			echo $obj->LoadAllSecuritySeals();
				break;

		case 'LoadAllSecuritySealsDetail':
		echo $obj->LoadAllSecuritySealsDetail();
			break;

		default:
		echo "Opción Inválida";
		break;
	}
}
?>
