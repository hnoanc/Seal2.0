<?php

$FileName = dirname(__FILE__).'/data.txt';

$LastModif = isset($_GET['timestamp']) ? $_GET['timestamp'] : 0;
$CurrentModif = filemtime($FileName);

while ($CurrentModif <= $LastModif) {
  usleep(100000);
  clearstatcache();
  $CurrentModif = filemtime($FileName);
}

$response=array();
session_start();
$response['CurrentUser']=$_SESSION['SESSINFO']['Role_ID'];
session_write_close();
$response['Count'] = file_get_contents($FileName);
$response['timestamp'] = $CurrentModif;

echo json_encode($response);
flush();
?>
