<?php
if(isset($_POST['action'])){
	require_once("../../cnf/LogManager.php");
	$obj =  new LogManager();
	header('Content-Type: application/json');
	switch ($_POST['action']) {
		case 'UserLogin':
		echo $obj->UserLogin($_POST['user'],$_POST['password'],$_POST['remember']);
		break;
		default:
		echo "Opción Inválida";
		break;
	}
}
?>
