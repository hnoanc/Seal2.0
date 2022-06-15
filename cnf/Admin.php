<?php
require_once('Anonymous.php');
class Admin extends Anonymous
{
  function GetUsersForReceiveFromSecurity(){
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_GetUsersForReceiveFromSecurity");
    $retval=$this->ExecuteSelectAssoc($sth);
    return json_encode($retval);
  }
  function GetUsersForReceiveSeals(){
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_GetUsersForReceiveSeals");
    $retval=$this->ExecuteSelectAssoc($sth);
    return json_encode($retval);
  }
  function GetActiveRequisitions(){
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_GetActiveRequisitions");
    $retval=$this->ExecuteSelectAssoc($sth);
    return json_encode($retval);
  }
  function GetSuppliers(){
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_GetSuppliers");
    $retval=$this->ExecuteSelectAssoc($sth);
    return json_encode($retval);
  }

  function LoadSealRecycled(){
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_LoadSealsRecycle");
    $retval=$this->ExecuteSelectAssoc($sth);
    return json_encode($retval);
  }

  function LoadSecuritySeals(){
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_LoadSecuritySeals");
    $retval=$this->ExecuteSelectArray($sth);
    return json_encode($retval);
  }

  function LoadSealsDepartment(){
    session_start();
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_LoadSealsDepartment ?");
    $sth->bindParam(1, $_SESSION['SESSINFOSEAL']['User_Usr']);
    $retval=$this->ExecuteSelectArray($sth);
    return json_encode($retval);
  }
  
  function AddSealsFromPurchase($Data){
    session_start();
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_AddNewSeals ?,?,?,?,?,?,?,?,?,?,?");
    $sth->bindParam(1, $Data["InitialFolio"]);
    $sth->bindParam(2, $Data["FinalFolio"]);
    $sth->bindParam(3, $Data["UserDelivery"]);
    //$sth->bindParam(4, 7);
    $sth->bindParam(4, $Data["Color"]);
    $sth->bindParam(5, $Data["Supplier_ID"]);
    $sth->bindParam(6, $Data["Requisition_ID"]);
    $sth->bindParam(7, $Data["Reference"]);
    $sth->bindParam(8, $Data["Status"]);
    $sth->bindParam(9, $_SESSION['SESSINFOSEAL']['User_Usr']);
    $sth->bindParam(10, $_SESSION['SESSINFOSEAL']['Ofice_ID']);
    $sth->bindParam(11, $Data["Quantity"]);
    //session_write_close();
    $retval=$this->ExecuteNoQuery($sth);
    return json_encode($retval);
  }
  

  function UpdateSealToSecurity($Data){
    session_start();

    if ($_SESSION['SESSINFOSEAL']['Ofice_ID'] ) {
      
    }


    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_UpdateSealToDepartment ?,?,?,?,?");
    $sth->bindParam(1, $Data["InitialFolio_ID"]);
    $sth->bindParam(2, $Data["FinalFolio_ID"]);
    $sth->bindParam(3, $_SESSION['SESSINFOSEAL']['User_Usr']);
    $sth->bindParam(4, $Data["UserReceive"]);
    $sth->bindParam(5, $_SESSION['SESSINFOSEAL']['Ofice_ID']);
    $retval=$this->ExecuteNoQuery($sth);
    session_write_close();
    return json_encode($retval);
  }

  function LoadCurrentTravels(){
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_LoadCurrentTravels ?");
    $sth->bindParam(1, $_SESSION['SESSINFOSEAL']['Ofice_ID']);
    $retval=$this->ExecuteSelectArray($sth);
    return json_encode($retval);
  }

  function LoadDispatchSeals(){
    session_start();
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_LoadDispatchSeals");
    $retval=$this->ExecuteSelectArray($sth);
    $retval['s'] =  $_SESSION['SESSINFOSEAL'];
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
  function LoadSecuritySealsInTransit(){
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_LoadSecuritySealsInTransit");
    $retval=$this->ExecuteSelectArray($sth);
    return json_encode($retval);
  }
  function UpdateSealToRecycledDispatch($Data){
    session_start();
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_UpdateSealToRecycledDispatch ?,?,?");
    $sth->bindParam(1, $Data["Status"]);
    $sth->bindParam(2, $Data["Seals"]);
    $sth->bindParam(3, $_SESSION['SESSINFOSEAL']['User_Usr']);
    $retval=$this->ExecuteNoQuery($sth);
    session_write_close();
    return json_encode($retval);
  }
  function GetDrivers(){
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_GetDrivers");
    $retval=$this->ExecuteSelectAssoc($sth);
    return json_encode($retval);
  }
  function AddSealsFromShipper($Data){
    session_start();
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_AddSealsFromShipper ?,?,?,?,?,?");
    $sth->bindParam(1, $Data["Folio"]);
    $sth->bindParam(2, $Data["Operator"]);
    $sth->bindParam(3, $_SESSION['SESSINFOSEAL']['User_Usr']);
    $sth->bindParam(4, $Data["Color"]);
    $sth->bindParam(5, $_SESSION['SESSINFOSEAL']['Ofice_ID']);
    $sth->bindParam(6, $Data["Travel"]);
    $retval=$this->ExecuteNoQuery($sth);
    session_write_close();
    return json_encode($retval);
  }

  function LoadDispatchRecycledSeals(){
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_LoadDispatchRecycledSeals");
    $retval=$this->ExecuteSelectArray($sth);
    return json_encode($retval);
  }

  function UpdateSealToRecycledSecurity($Data){
    session_start();
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_UpdateSealToRecycledSecurity ?,?,?");
    $sth->bindParam(1, $Data["SealsID"]);
    $sth->bindParam(2, $Data["UserID"]);
    $sth->bindParam(3, $_SESSION['SESSINFOSEAL']['User_Usr']);
    $retval=$this->ExecuteNoQuery($sth);
    session_write_close();
    return json_encode($retval);
  }
  function LoadSecurityRecycledSeals(){
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_LoadSecurityRecycledSeals");
    $retval=$this->ExecuteSelectArray($sth);
    return json_encode($retval);
  }
  function UpdateSealToPuraSangre($Data){
    session_start();
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_UpdateSealToPuraSangre ?,?,?");
    $sth->bindParam(1, $Data["SealsID"]);
    $sth->bindParam(2, $_SESSION['SESSINFOSEAL']['User_Usr']);
    $sth->bindParam(3, $Data["UserID"]);
  
    $retval=$this->ExecuteNoQuery($sth);
    session_write_close();
    return json_encode($retval);
  }
  function LoadSealsInTransitTravel(){
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_LoadSealsInTransitTravel");
    $retval=$this->ExecuteSelectArray($sth);
    return json_encode($retval);
  }

  function LoadPuraSangreSeals(){
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_LoadPuraSangreSeals");
    $retval=$this->ExecuteSelectArray($sth);
    return json_encode($retval);
  }

  function UpdateStatusSealUSA($Data){
    session_start();
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_UpdateStatusSealUSA ?,?");
    $sth->bindParam(1, $Data["SealsID"]);
    $sth->bindParam(2, $_SESSION['SESSINFOSEAL']['User_Usr']);
    $retval=$this->ExecuteNoQuery($sth);
    session_write_close();
    return json_encode($retval);
  }
  function UpdateStatusSealDestroy($Data){
    session_start();
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_UpdateStatusSealDestroy ?,?");
    $sth->bindParam(1, $Data["SealsID"]);
    $sth->bindParam(2, $_SESSION['SESSINFOSEAL']['User_Usr']);
  
    $retval=$this->ExecuteNoQuery($sth);
    session_write_close();
    return json_encode($retval);
  }
  function UpdateSealUSAReplace($Data){
    session_start();
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_UpdateSealUSAReplace ?,?,?");
    $sth->bindParam(1, $Data["Travel"]);
    $sth->bindParam(2, $Data["SealsID"]);
    $sth->bindParam(3, $_SESSION['SESSINFOSEAL']['User_Usr']);
    $retval=$this->ExecuteNoQuery($sth);
    session_write_close();
    return json_encode($retval);
  }

  function SaveSealsDelivery($Data){
    session_start();
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_AddNewDelivery ?,?,?");
    $sth->bindParam(1, $Data["Travel"]);
    $sth->bindParam(2, $Data["SealsID"]);
    $sth->bindParam(3, $_SESSION['SESSINFOSEAL']['User_Usr']);
    $retval=$this->ExecuteNoQuery($sth);
    session_write_close();
    return json_encode($retval);
  }

  function GetTravelInfo($Data){
    
    session_start();
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_GetTravelInfo ?");
    $sth->bindParam(1, $Data["Travel"]);
    $retval=$this->ExecuteSelectAssoc($sth);
    
    if($Data["User"]!=null){
      $cnx=$this->connectSqlSrv();
      $sth = $cnx->prepare("exec sp_UserLoginWOP ?");
      $sth->bindParam(1, $Data["User"]);
      $retval2=$this->ExecuteSelectAssoc($sth);
      $retval['s']=$retval2['r'];
    }
    else{
      $retval['s']=$_SESSION['SESSINFOSEAL'];
    }
    session_write_close();
    return json_encode($retval);
  }

  function GetTravelInfoWalmart($Data){
    session_start();
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_GetTravelInfoWalmart ?");
    $sth->bindParam(1, $Data["Travel"]);
    $retval=$this->ExecuteSelectAssoc($sth);

    if($Data["User"]!=null){
      $cnx=$this->connectSqlSrv();
      $sth = $cnx->prepare("exec sp_UserLoginWOP ?");
      $sth->bindParam(1, $Data["User"]);
      $retval2=$this->ExecuteSelectAssoc($sth);
      $retval['s']=$retval2['r'];
    }
    else{
      $retval['s']=$_SESSION['SESSINFOSEAL'];
    }

    session_write_close();
    return json_encode($retval);
  }

  function GetUsersTransactionInfoUU($Data){
    
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_GetUsersTransactionInfo ?, ?");
      $sth->bindParam(1, $Data["User"]);
      $sth->bindParam(2,  $Data["UserR"]);
    $retval=$this->ExecuteSelectAssoc($sth);
    return json_encode($retval);
  }
  function GetUsersTransactionInfoSR($Data){
    
    session_start();
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_GetUsersTransactionInfo ?, ?");
      $sth->bindParam(1, $Data["User"]);
      $sth->bindParam(2, $_SESSION['SESSINFOSEAL']['User_Usr']);
    $retval=$this->ExecuteSelectAssoc($sth);
    $retval['Type'] = $Data;
    session_write_close();
    return json_encode($retval);
  }
  function GetUsersTransactionInfoSD($Data){
    
    session_start();
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_GetUsersTransactionInfo ?, ?");
    $sth->bindParam(1, $_SESSION['SESSINFOSEAL']['User_Usr']);
    $sth->bindParam(2, $Data["User"]);
    $retval=$this->ExecuteSelectAssoc($sth);
    $retval['Type'] = $Data;
    session_write_close();
    return json_encode($retval);
  }
  function GetSealsNoFolioById($Data){
    
    session_start();
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_GetSealsNoFolioById ?");
    $sth->bindParam(1, $Data["Seals"]);
    $retval=$this->ExecuteSelectAssoc($sth);
    session_write_close();
    return json_encode($retval);
  }
  function GetUsersTransactionInfoSDDriver($Data){
    
    session_start();
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_GetUsersTransactionInfoSDDriver ?, ?");
    $sth->bindParam(1, $_SESSION['SESSINFOSEAL']['User_Usr']);
    $sth->bindParam(2, $Data["Travel"]);
    $retval=$this->ExecuteSelectAssoc($sth);
    $retval['Type'] = $Data;
    session_write_close();
    return json_encode($retval);
  }

  function LoadAllDispatchSeals(){
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_LoadAllDispatchSeals");
    $retval=$this->ExecuteSelectArray($sth);
    return json_encode($retval);
  }
  function LoadAllDispatchSealsDetail(){
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_LoadAllDispatchSealsDetail");
    $retval=$this->ExecuteSelectArray($sth);
    return json_encode($retval);
  }
  function LoadAllSecuritySeals(){
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_LoadAllSecuritySeals");
    $retval=$this->ExecuteSelectArray($sth);
    return json_encode($retval);
  }
  function LoadAllSecuritySealsDetail(){
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_LoadAllSecuritySealsDetail");
    $retval=$this->ExecuteSelectArray($sth);
    return json_encode($retval);
  }
  function LoadSecuritySealsByStatus($Data){
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_LoadSecuritySealsByStatus ?");
    $sth->bindParam(1, $Data["Status"]);
    $retval=$this->ExecuteSelectArray($sth);
    return json_encode($retval);
  }
  function GetUsersAndDrivers(){
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_GetUsersAndDrivers");
    $retval=$this->ExecuteSelectAssoc($sth);
    return json_encode($retval);
  }
  function UpdateSealToLost($Data){
    session_start();
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_UpdateSealToLost ?,?,?,?,?");
    $sth->bindParam(1, $Data["SealsID"]);
    $sth->bindParam(2, $_SESSION['SESSINFOSEAL']['User_Usr']);
    $sth->bindParam(3, $Data["UserID"]);
    $sth->bindParam(4, $Data["Name"]);
    $sth->bindParam(5, $Data["Type"]);
    $retval=$this->ExecuteNoQuery($sth);
    session_write_close();
    return json_encode($retval);
  } 
  function UpdateSealToPaidOut($Data){
    session_start();
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_UpdateSealToPaidOut ?,?,?");
    $sth->bindParam(1, $Data["SealsID"]);
    $sth->bindParam(2, $_SESSION['SESSINFOSEAL']['User_Usr']);
    $sth->bindParam(3, $_SESSION['SESSINFOSEAL']['User_Usr']);
  
    $retval=$this->ExecuteNoQuery($sth);
    session_write_close();
    return json_encode($retval);
  }
  function GetLostSealbyUser($Data){
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_GetLostSealbyUser ?");
    $sth->bindParam(1, $Data["Travel"]);
    $retval=$this->ExecuteSelectArray($sth);
    return json_encode($retval);
  }
  function LoadAllSealsDetail(){
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_LoadAllSealsDetail ");
    $retval=$this->ExecuteSelectArray($sth);
    return json_encode($retval);
  }

  function LoadSecuritySealsByStatusLost($Data){
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_LoadSecuritySealsByStatusLost ?");
    $sth->bindParam(1, $Data["Status"]);
    $retval=$this->ExecuteSelectArray($sth);
    return json_encode($retval);
  }
  function UpdateSealToDispatch($Data){
    session_start();
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_UpdateSealToDispatch ?,?,?");
    $sth->bindParam(1, $Data["SealsID"]);
    $sth->bindParam(2, $_SESSION['SESSINFOSEAL']['User_Usr']);
    $sth->bindParam(3, $Data["UserID"]);
  
    $retval=$this->ExecuteNoQuery($sth);
    session_write_close();
    return json_encode($retval);
  }

  function LoadAllSealsQuantity($Data){
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_LoadAllSealsQuantity ?,?");
    $sth->bindParam(1, $Data["FechaInicial"]);
    $sth->bindParam(2, $Data["FechaFinal"]);
    $retval=$this->ExecuteSelectAssoc($sth);
    return json_encode($retval);
  }
  function LoadTransactions($Data){
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_LoadTransactionsByDate ?,?");
    $sth->bindParam(1, $Data["FechaInicial"]);
    $sth->bindParam(2, $Data["FechaFinal"]);
    $retval=$this->ExecuteSelectArray($sth);
    return json_encode($retval);
  }
  function GetTransactionDetail($Data){
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_LoadTransactionDetail ?");
    $sth->bindParam(1, $Data["Date"]);
    $retval=$this->ExecuteSelectAssoc($sth);
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_LoadTransactionSeals ?");
    $sth->bindParam(1, $Data["Date"]);
    $retval2=$this->ExecuteSelectArray($sth);
    $retval['datatable'] = $retval2['r'];
    return json_encode($retval);
  }
  
  function LoadSealsWithOutPaid(){
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_LoadSealsWithOutPaid ");
    $retval=$this->ExecuteSelectAssoc($sth);
    return json_encode($retval);
  }
  function GetSealPrice(){
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_GetPriceList");
    $retval=$this->ExecuteSelectAssoc($sth);
    return json_encode($retval);
  }
  //    -------------------------------------------------     ///LoadSealsWithOutPaid
  function GetDepartments(){
    $cnx=$this->connectSqlSrv();
		$sth = $cnx->prepare("EXEC GetDepartments");
    $retval=$this->ExecuteSelectAssoc($sth);

    return json_encode($retval);
  }

  function GetOffices(){
    $cnx=$this->connectSqlSrv();
		$sth = $cnx->prepare("EXEC sp_GetOffices");
    $retval=$this->ExecuteSelectAssoc($sth);

    return json_encode($retval);
  }

  function GetRoles(){
    $cnx=$this->connectSqlSrv();
		$sth = $cnx->prepare("EXEC sp_GetRoles");
    $retval=$this->ExecuteSelectAssoc($sth);

    return json_encode($retval);
  }

  function GetRequisition(){
    $cnx=$this->connectSqlSrv();
    $sth = $cnx->prepare("EXEC sp_GetRequisition");
    $retval=$this->ExecuteSelectAssoc($sth);

    return json_encode($retval);
  }

  function RegUsr($UserData){
    $Password = hash('sha256',$UserData["User_Pss"]);
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_UserRegistry ?,?,?,?,?,?,?,?,?,?,?");
    $sth->bindParam(1, $UserData["User_Name"]);
    $sth->bindParam(2, $UserData["User_FLast"]);
    $sth->bindParam(3, $UserData["User_MLast"]);
    $sth->bindParam(4, $UserData["User_Ext"]);
    $sth->bindParam(5, $UserData["User_Email"]);
    $sth->bindParam(6, $UserData["Department_ID"]);
    $sth->bindParam(7, $UserData["Ofice_ID"]);
    $sth->bindParam(8, $UserData["User_Usr"]);
    $sth->bindParam(9, $Password);
    $sth->bindParam(10, $UserData["Role_ID"]);
    $sth->bindParam(11, $UserData["NoEmpleado"]);
    $retval=$this->ExecuteNoQuery($sth);

    return json_encode($retval);
  }

  function SaveSeals($SealsData){
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_AddSealsRecycled ?,?,?");
    $sth->bindParam(1, $SealsData["NoSello"]);
    $sth->bindParam(2, $SealsData["Color"]);
    $sth->bindParam(3, $SealsData["Reference"]);
    $retval=$this->ExecuteNoQuery($sth);

    return json_encode($retval);
  }

  function LoadUsersInfo(){
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_GetUsers");
    $retval=$this->ExecuteSelectArray($sth);

    return json_encode($retval);
  }

  function ChangeUserStatus($Data){
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("Exec sp_ChangeUserStatus ?,?");
    $sth->bindParam(1, $Data["User"]);
    $sth->bindParam(2, $Data["Status"]);
    $retval=$this->ExecuteNoQuery($sth);
    return json_encode($retval);
  }

  function GetUserInfo($Data){
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("exec sp_GetUserInfo ?");
    $sth->bindParam(1, $Data["ID"]);
    $retval=$this->ExecuteSelectArray($sth);

    return json_encode($retval);
  }

  function UpdateUserInfo($Data){
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("exec sp_UpdateUserInfo ?, ?, ?, ?, ?, ?, ?, ?, ?, ?");
    $sth->bindParam(1, $Data["ID"]);
    $sth->bindParam(2, $Data["Name"]);
    $sth->bindParam(3, $Data["FLast"]);
    $sth->bindParam(4, $Data["MLast"]);
    $sth->bindParam(5, $Data["Email"]);
    $sth->bindParam(6, $Data["Extencion"]);
    $sth->bindParam(7, $Data["Office"]);
    $sth->bindParam(8, $Data["Department"]);
    $sth->bindParam(9, $Data["Role"]);
    $sth->bindParam(10, $Data["NoEmpleado"]);
    $retval=$this->ExecuteSelectArray($sth);

    return json_encode($retval);
  }
  function UpdateUserPass($Data){
    $Password = hash('sha256',$Data["Pass"]);
    $cnx=$this->connectSqlSrv();
    $sth=$cnx->prepare("exec sp_UpdateUserPass ?, ?");
    $sth->bindParam(1, $Data["ID"]);
    $sth->bindParam(2, $Password);
    $retval=$this->ExecuteSelectArray($sth);
    return json_encode($retval);
  }

function CheckRole(){
  session_start();
  $role = $_SESSION['SESSINFOSEAL']['Role_ID'];
  $retval= $role;
session_write_close();
  return json_encode($retval);
}

function GetUsers(){
  session_start();
  $cnx=$this->connectSqlSrv();
  $sth=$cnx->prepare("Exec sp_GetUsers");
  $retval=$this->ExecuteSelectArray($sth);

  session_write_close();
  return json_encode($retval);
}
function GetStatus(){
  $cnx=$this->connectSqlSrv();
  $sth=$cnx->prepare("Exec sp_GetStatus");
  $retval=$this->ExecuteSelectAssoc($sth);
  return json_encode($retval);
}
function UpdateSealToStatus($Data){
  session_start();
  $cnx=$this->connectSqlSrv();
  $sth=$cnx->prepare("Exec sp_UpdateSealToStatus ?,?,?,?,?");
  $sth->bindParam(1, $Data["SealsID"]);
  $sth->bindParam(2, $_SESSION['SESSINFOSEAL']['User_Usr']);
  $sth->bindParam(3, $Data["UserID"]);
  $sth->bindParam(4, $Data["StatusID"]);
  $sth->bindParam(5, $Data["Reference"]);

  $retval=$this->ExecuteNoQuery($sth);
  session_write_close();
  return json_encode($retval);
}
function UpdateStockSealToStatus($Data){
  session_start();
  $cnx=$this->connectSqlSrv();
  $sth=$cnx->prepare("Exec sp_UpdateStockSealToStatus ?,?,?,?,?,?");
  $sth->bindParam(1, $Data["InitialFolio_ID"]);
  $sth->bindParam(2, $Data["FinalFolio_ID"]);
  $sth->bindParam(3, $_SESSION['SESSINFOSEAL']['User_Usr']);
  $sth->bindParam(4, $Data["UserID"]);
  $sth->bindParam(5, $Data["StatusID"]);
  $sth->bindParam(6, $Data["Reference"]);
  $retval=$this->ExecuteNoQuery($sth);
  session_write_close();
  return json_encode($retval);
}
function GetInspectionSeals(){
  $cnx=$this->connectSqlSrv();
  $sth=$cnx->prepare("Exec sp_LoadInspectionSeals");
  $retval=$this->ExecuteSelectAssoc($sth);
  return json_encode($retval);
}
function UpdateSealToStatusFromInspection($Data){
  session_start();
  $cnx=$this->connectSqlSrv();
  $sth=$cnx->prepare("Exec sp_UpdateSealToStatusFromInspection ?,?,?,?,?");
  $sth->bindParam(1, $Data["Seal"]);
  $sth->bindParam(2, $_SESSION['SESSINFOSEAL']['User_Usr']);
  $sth->bindParam(3, $Data["Status"]);
  $sth->bindParam(4, $Data["Reference"]);
  $sth->bindParam(5, $Data["Trip"]);
  $retval=$this->ExecuteNoQuery($sth);
  session_write_close();
  return json_encode($retval);
}
function LoadSecuritySealsInTrailer(){
  $cnx=$this->connectSqlSrv();
  $sth=$cnx->prepare("Exec sp_LoadSecuritySealsInTrailer");
  $retval=$this->ExecuteSelectArray($sth);
  return json_encode($retval);
}
function UpdateSealToDestroy($Data){
  session_start();
  $cnx=$this->connectSqlSrv();
  $sth=$cnx->prepare("Exec sp_UpdateSealToDestroy ?,?,?");
  $sth->bindParam(1, $Data["Status"]);
  $sth->bindParam(2, $Data["Seals"]);
  $sth->bindParam(3, $_SESSION['SESSINFOSEAL']['User_Usr']);
  $retval=$this->ExecuteNoQuery($sth);
  session_write_close();
  return json_encode($retval);
}
function GetUsersWithOutAccess(){
  session_start();
  $cnx=$this->connectSqlSrv();
  $sth=$cnx->prepare("Exec sp_GetUsersWithOutAccess");
  $retval=$this->ExecuteSelectAssoc($sth);

  session_write_close();
  return json_encode($retval);
}

function AddUser($Data){
  $cnx=$this->connectSqlSrv();
  $sth=$cnx->prepare("Exec sp_CreateUser ?,?");
  $sth->bindParam(1, $Data["User"]);
  $sth->bindParam(2, $Data["Roll"]);
  $retval=$this->ExecuteNoQuery($sth);
  return json_encode($retval);
}
function UpdateUser($Data){
  $cnx=$this->connectSqlSrv();
  $sth=$cnx->prepare("Exec sp_UpdateUser ?,?,?");
  $sth->bindParam(1, $Data["ID"]);
  $sth->bindParam(2, $Data["Roll"]);
  $sth->bindParam(3, $Data["Active"]);
  $retval=$this->ExecuteNoQuery($sth);
  return json_encode($retval);
}
function GetK9Seals(){
  $cnx=$this->connectSqlSrv();
  $sth=$cnx->prepare("Exec sp_LoadK9Seals");
  $retval=$this->ExecuteSelectAssoc($sth);
  return json_encode($retval);
}

function LoadClientSeals(){
  $cnx=$this->connectSqlSrv();
  $sth=$cnx->prepare("Exec sp_LoadClientSeals");
  $retval=$this->ExecuteSelectArray($sth);
  return json_encode($retval);
}
function LoadClientAmmountSeals(){
  $cnx=$this->connectSqlSrv();
  $sth=$cnx->prepare("Exec sp_LoadAmmountSealsByClient");
  $retval=$this->ExecuteSelectArray($sth);
  return json_encode($retval);
}
function LoadSecuritySealsInError(){
  $cnx=$this->connectSqlSrv();
  $sth=$cnx->prepare("Exec sp_LoadSecuritySealsInError");
  $retval=$this->ExecuteSelectArray($sth);
  return json_encode($retval);
}
function UpdateSealToErrorDispatch($Data){
  session_start();
  $cnx=$this->connectSqlSrv();
  $sth=$cnx->prepare("Exec sp_UpdateSealToErrorDispatch ?,?,?");
  $sth->bindParam(1, $Data["Status"]);
  $sth->bindParam(2, $Data["Seals"]);
  $sth->bindParam(3, $_SESSION['SESSINFOSEAL']['User_Usr']);
  $retval=$this->ExecuteNoQuery($sth);
  session_write_close();
  return json_encode($retval);
}
function LoadAudits(){
  $cnx=$this->connectSqlSrv();
  $sth=$cnx->prepare("Exec Schema_Audit.sp_LoadAudits");
  $retval=$this->ExecuteSelectArray($sth);
  return json_encode($retval);
}
function UpdateDate($data){
  $cnx=$this->connectSqlSrv();
  $sth=$cnx->prepare("Exec Schema_Audit.sp_UpdateDate ?, ?");
  $sth->bindParam(1, $data["Audit_ID"]);
  $sth->bindParam(2, $data["New_Date"]);
  $retval=$this->ExecuteNoQuery($sth);
  return json_encode($retval);
}
function UpdateRisk($data){
  $cnx=$this->connectSqlSrv();
  $sth=$cnx->prepare("Exec Schema_Audit.sp_UpdateRisk ?, ?");
  $sth->bindParam(1, $data["Audit_ID"]);
  $sth->bindParam(2, $data["Risk"]);
  $retval=$this->ExecuteNoQuery($sth);
  return json_encode($retval);
}
function LoadSealHistory(){
  $cnx=$this->connectSqlSrv();
  $sth=$cnx->prepare("Exec sp_LoadSealHistory");
  $retval=$this->ExecuteSelectArray($sth);
  return json_encode($retval);
}
function LoadSealsByTravel($data){
  $cnx=$this->connectSqlSrv();
  $sth=$cnx->prepare("Exec sp_LoadSealsByTravel ?");
  $sth->bindParam(1, $data["travel"]);
  $retval=$this->ExecuteSelectArray($sth);
  return json_encode($retval);
}
function UpdateSealToExport($data){
  session_start();
  $cnx=$this->connectSqlSrv();
  $sth=$cnx->prepare("Exec sp_UpdateSealToExport ?, ?");
  $sth->bindParam(1, $data["Seals"]);
  $sth->bindParam(2, $_SESSION['SESSINFOSEAL']['User_Usr']);
  $retval=$this->ExecuteNoQuery($sth);
  session_write_close();
  return json_encode($retval);
}

}

?>
