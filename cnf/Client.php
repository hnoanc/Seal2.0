<?php
require_once('Anonymous.php');
class Client extends Anonymous
{
  function LoadClientDispatchSeals(){
    session_start();
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_LoadClientDispatchSeals ?");
    $sth->bindParam(1, $_SESSION['SESSINFOSEAL']['User_ID']);
    $retval=$this->ExecuteSelectArray($sth);
    $retval['s'] =  $_SESSION['SESSINFOSEAL'];
    session_write_close();
    return json_encode($retval);
  }
  function LoadCurrentTravelsByClient(){
    session_start();
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_LoadCurrentTravelsByClient ?");
    $sth->bindParam(1, $_SESSION['SESSINFOSEAL']['User_ID']);
    $retval=$this->ExecuteSelectArray($sth);
    session_write_close();
    return json_encode($retval);
  }
  function UpdateSealToOperator($Data){
    session_start();
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_UpdateSealToOperator ?,?,?,?");
    $sth->bindParam(1, $Data["Travel"]);
    $sth->bindParam(2, $Data["Seals"]);
    $sth->bindParam(3, $_SESSION['SESSINFOSEAL']['User_Usr']);
    $sth->bindParam(4, $Data["Comments"]);
    $retval=$this->ExecuteNoQuery($sth);
    session_write_close();
    return json_encode($retval);
  }
  function LoadAudit(){ //Schema_Audit.sp_LoadAudit
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec Schema_Audit.sp_LoadAudit");
    $retval=$this->ExecuteSelectAssoc($sth);
    return json_encode($retval);
  }
  function loadPercentajes($data){
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec Schema_Audit.sp_loadPercentajes ?");
    $sth->bindParam(1, $data['Audit_ID']);
    $retval=$this->ExecuteSelectAssoc($sth);
    return json_encode($retval);
  }
  function auditExists($data){
    session_start();

    if(is_numeric($_SESSION['SESSINFOSEAL']['User_Usr'])){
      $dato = (int)$_SESSION['SESSINFOSEAL']['User_Usr'];
    }else{
      $dato = 0;
    }

    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec Schema_Audit.sp_auditExists ?, ?");
    $sth->bindParam(1,  $dato );
    $sth->bindParam(2, $data['Audit_ID']);
    $retval=$this->ExecuteSelectArray($sth);
    session_write_close();
    return json_encode($retval);
  }
  function loadInfo($data){
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec Schema_Audit.sp_loadInfo ?");
    $sth->bindParam(1, $data['Audit_ID']);
    $retval=$this->ExecuteSelectArray($sth);
    return json_encode($retval);
  }
  function GetAuditAnswers($data){
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec Schema_Audit.sp_GetAuditAnswers ?");
    $sth->bindParam(1, $data['Audit_ID']);
    $retval=$this->ExecuteSelectAssoc($sth);
    return json_encode($retval);
  }
  function GetStates(){
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec Inspect.dbo.sp_IWGetStates 1");
    $retval=$this->ExecuteSelectAssoc($sth);
    return json_encode($retval);
  }
  function GetCities($data){
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec Inspect.dbo.sp_IWGetTowns ?, ?");
    $sth->bindParam(1, $data['stateid']);
    $sth->bindParam(2, $data['option']);
    $retval=$this->ExecuteSelectAssoc($sth);
    return json_encode($retval);
  }
  function SaveAudit($data){
    session_start();
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec Schema_Audit.sp_AuditInsert ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?");
    $sth->bindParam(1, $_SESSION['SESSINFOSEAL']['User_Usr']);
    $sth->bindParam(2, $data['Company_Name']);
    $sth->bindParam(3, $data['Company_Rol']);
    $sth->bindParam(4, $data['Company_Address']);
    $sth->bindParam(5, $data['State_ID']);
    $sth->bindParam(6, $data['City_ID']);
    $sth->bindParam(7, $data['Company_PostalCode']);
    $sth->bindParam(8, $data['Company_Employees']);
    $sth->bindParam(9, $data['User_Name']);
    $sth->bindParam(10, $data['User_Job']);
    $sth->bindParam(11, $data['User_Phone']);
    $sth->bindParam(12, $data['User_Email']);
    $sth->bindParam(13, $data['Company_BranchOffice']);
    $sth->bindParam(14, $data['Audit_ID']);
    $retval=$this->ExecuteNoQuery($sth);
    session_write_close();
    return json_encode($retval);
  }
  function SaveAnswer($data){
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec Schema_Audit.sp_AnswersInsert  ?, ?, ?, ?");
    $sth->bindParam(1, $data['Audit_ID']);
    $sth->bindParam(2, $data['Question_ID']);
    $sth->bindParam(3, $data['Answer_Value']);
    $sth->bindParam(4, $data['Answer_Comment']);
    $retval=$this->ExecuteNoQuery($sth);
    return json_encode($retval);
  }
  function LoadFullAudit($audit){
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec Schema_Audit.sp_LoadFullAudit ?");
    $sth->bindParam(1, $audit);
    $retval=$this->ExecuteSelectAssoc($sth);
    return json_encode($retval);
  }
  function LoadFiles($data){
    $directory = "D:/PHPUPLOADSEAL/" . "/" . $data["User"] . "/" . $data["Audit"] . "/" . $data["Question"];
    $array = scandir($directory);
  
    return Json_encode($array);
  }
  function CheckFiles($data){
    $directory = "D:/PHPUPLOADSEAL/" . "/" . $data["User"] . "/" . $data["Audit"] . "/Archivos";
    $array = scandir($directory);
  
    return Json_encode($array);
  }
  function SaveComment($data){
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec Schema_Audit.sp_SaveComment ?, ?");
    $sth->bindParam(1, $data['Audit_ID']);
    $sth->bindParam(2, $data['Audit_Comment']);
    $retval=$this->ExecuteNoQuery($sth);
    return json_encode($retval);
  }
}

?>
