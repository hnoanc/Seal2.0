<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	require_once("WebServices.php");

	$obj =  new WebServices();

	$PostInfo = json_decode(file_get_contents("php://input"));
	switch ($PostInfo->{"action"}) {
		case 'user_login':
		echo $obj->UserLogin($PostInfo->{"user"}, $PostInfo->{"password"}, $PostInfo->{"company"});
		break;
		case 'get_units':
		echo $obj->GetUnits($PostInfo->{"unittype"}, $PostInfo->{"company"});
		break;
		case 'get_trips':
		echo $obj->GetTrips($PostInfo->{"empresa_id"}, $PostInfo->{"ent_sal"}, $PostInfo->{"opcion_filtro"}, $PostInfo->{"no_viaje"}, $PostInfo->{"tracto"}, $PostInfo->{"caja"});
		break;
		case 'get_drivers':
		echo $obj->GetDrivers($PostInfo->{"company"});
		break;
		case 'get_driverphotos':
		echo $obj->GetDriverPhotos($PostInfo->{"name"}, $PostInfo->{"company"});
		break;
		case 'upload_trip_photo':
		echo $obj->UploadImage($PostInfo);
		break;
		case 'upload_trip_info':
		echo $obj->UploadInfo($PostInfo);
		break;
		case 'QRZ_search_guards':
		echo $obj->QRZSearchGuards();
		break;
		case 'QRZ_upload_info':
		echo $obj->QRZUploadInfo($PostInfo->{"ids"}, $PostInfo->{"zonas"}, $PostInfo->{"fechas"});
		break;
		default:
		echo "Opción Inválida";
		break;
	}
}
?>
