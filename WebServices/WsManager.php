<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	require_once("WebServices.php");

	$obj =  new WebServices();

	$PostInfo = json_decode(file_get_contents("php://input"));
	switch ($PostInfo->{"action"}) {
		case 'user_login':
		echo $obj->UserLogin($PostInfo->{"user"}, $PostInfo->{"password"});
		break;
		default:
		echo "Opción Inválida";
		break;
	}
}
?>
