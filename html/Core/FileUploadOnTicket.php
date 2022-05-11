<?php
session_start();

$ds             = DIRECTORY_SEPARATOR;  //1
$storeFolder    = $_GET['User'];   //2
$TicketFolder   = $_GET['Ticket'];

if (!empty($_FILES)) {

    $tempFile = $_FILES['file']['tmp_name'];          //3

    $targetPath = 'D:/PHPUPLOAD' . $ds. $storeFolder . $ds . $TicketFolder . $ds;  //4
    if (!file_exists($targetPath))  {
        mkdir($targetPath, 0777, true);
    }

    $targetFile =  $targetPath. $_FILES['file']['name'];  //5


    move_uploaded_file($tempFile,$targetFile); //6
session_write_close();
}
?>
