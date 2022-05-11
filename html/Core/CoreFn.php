<?php
if(isset($_POST['action'])){
	require_once("../../cnf/LogManager.php");
	$obj =  new LogManager();
	header('Content-Type: application/json');
	switch ($_POST['action']) {
		case 'LoadTopBar':
		echo $obj->LoadTopBar();
		break;
		case 'SideBar':
		echo $obj->SideBar();
		break;
		case 'LogOut':
		echo $obj->LogOut();
		break;
		case 'CheckSession':
		echo $obj->CheckSession($_POST['url']);
		break;
		default:
		echo "Opción Inválida";
		break;
	}
}
?>
