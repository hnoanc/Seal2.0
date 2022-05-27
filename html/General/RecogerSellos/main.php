<?php
if(isset($_POST['action'])){
	require_once("../../../cnf/Admin.php");
	$obj =  new Admin();
	header('Content-Type: application/json');
	switch ($_POST['action']) {
		case 'GetUsersForReceiveFromSecurity':
		echo $obj-> GetUsersForReceiveFromSecurity();
		break;

		case 'LoadSecuritySeals':
			echo $obj->LoadSecuritySeals();
	}
}
?>