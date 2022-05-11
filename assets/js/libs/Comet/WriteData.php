<?php
$FileName = dirname(__FILE__).'/data.txt';

$msg = isset($_GET['msg']) ? $_GET['msg'] : '';
//var_dump($msg);
if ($msg != '')
{
  file_put_contents($FileName,$msg);
  die();
}
?>
