<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
require_once('../cnf/pdocnx.php');

$method = $_SERVER['REQUEST_METHOD'];

$retval=array(
  "r"=>"ID Invalido"
);
if ($method == 'POST') {

  $j = json_decode(file_get_contents("php://input"));
//var_dump($j);
  if(isset($j->{"Password"}) && isset($j->{"User"})){
    $Pss = $j->{"Password"};
    $Usr = $j->{"User"};
    if($Pss != "" && $Usr != ""){
      $Password = $Pss;
      $Password = hash('sha256',$Password);

      $server="www.mht-jcv.com";
      $usr="sa";
      $psw="AltoGuiso94*";
      $db="HelpIT";

      try{
        $dbCnx = new PDO("sqlsrv:Server=$server;Database=$db", $usr, $psw);
        $dbCnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $cnx = $dbCnx;
      }
      catch(PDOException $e){
        echo $e;
        die();
      }

      $sth = $cnx->prepare("exec sp_UserLogin ?, ?");
      $sth->bindParam(1, $Usr);
      $sth->bindParam(2, $Password);

      $retval=array('data'=>false,
      'error'=>false,
      'User_ID'=>'');
        $sth->execute();
        if ($row=$sth->fetch(PDO::FETCH_ASSOC)) {
          if (isset($row['User_ID'])) {
            $retval['User_ID']= $row['User_ID'];
          }
          else {
            $retval['User_ID']="0";
          }
        }
    }
    else {
      $retval['User_ID']="0";
    }
  }
}

echo Json_encode($retval);

?>
