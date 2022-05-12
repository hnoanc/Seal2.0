<?php
require_once('../cnf/Pdocnx.php');
class WebServices extends ConnectionManager
{
  function UserLogin($User, $Pss){
    $Password = $Pss;
    $Password = hash('sha256',$Password);
    //var_dump($Password);
    $cnx=$this->connectSqlSrv();
		$sth = $cnx->prepare("exec sp_UserLogin ?, ?");
    $sth->bindParam(1, $User);
    $sth->bindParam(2, $Password);
    $retval=$this->ExecuteSelectAssoc($sth);

    return json_encode($retval);
  }


}
 ?>
