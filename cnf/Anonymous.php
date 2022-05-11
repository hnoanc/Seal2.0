<?php
require_once('LogManager.php');
class Anonymous extends LogManager
{
  function GetDirectory(){
    $cnx=$this->connectSqlSrv();
		$sth = $cnx->prepare("EXEC sp_GetDirectory");
    $retval=$this->ExecuteSelectAssoc($sth);

    return json_encode($retval);
  }
}
?>
