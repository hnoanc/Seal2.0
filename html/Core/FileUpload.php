<?php
session_start();

$ds             = DIRECTORY_SEPARATOR;  //1
$storeFolder    = $_SESSION['SESSINFOSEAL']['User_ID'];   //2
$AuditFolder   = $_GET['Audit'];
$Question   = $_GET['Question'];

if (!empty($_FILES)) {

    $tempFile = $_FILES['file']['tmp_name'];          //3
    $newfilename = $Question . '_' . $_FILES["file"]["name"];
    $targetPath = 'D:/PHPUPLOADSEAL' . $ds. $storeFolder . $ds . $AuditFolder . $ds . $Question . $ds;  //
    if (!file_exists($targetPath))  {
        mkdir($targetPath, 0777, true);
    }

    $targetFile =  $targetPath . $newfilename;  //5


    move_uploaded_file($tempFile,$targetFile); //6
    session_write_close();
}
?>
