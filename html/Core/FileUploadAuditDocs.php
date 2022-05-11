<?php
session_start();

$ds             = DIRECTORY_SEPARATOR;  //1
$storeFolder    = $_GET['User'];   //2
$AuditFolder   = $_GET['Audit'];
$Type   = $_GET['Type'];

if (!empty($_FILES)) {

    $temp = explode(".", $_FILES["file"]["name"]);

    $tempFile = $_FILES['file']['tmp_name'];    //3

    $targetPath = 'D:/PHPUPLOADSEAL' . $ds. $storeFolder . $ds . $AuditFolder . $ds . 'Archivos' . $ds;  //4
    if (!file_exists($targetPath))  {
        mkdir($targetPath, 0777, true);
    }

    $targetFile =  $targetPath. $Type . '.' . end($temp);;  //5


    move_uploaded_file($tempFile,$targetFile); //6
    session_write_close();
}
?>
