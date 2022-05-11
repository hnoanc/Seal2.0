<?php
require_once('pdocnx.php');
class LogManager extends ConnectionManager
{
    function UserLogin($User, $Password, $Remember)
    {
        session_start();
        $Password = hash('sha256', $Password);

        $cnx=$this->connectSqlSrv();
        $sth = $cnx->prepare("exec sp_UserLogin ?, ?");
        $sth->bindParam(1, $User);
        $sth->bindParam(2, $Password);
        $retval=$this->ExecuteSelectAssoc($sth);

        if ($retval['r']['0']['Respuesta']=='Bienvenido') {
            $_SESSION['SESSINFOSEAL'] =$retval['r']['0'];
        } else {
            $retval['error']=true;
        }

        if ($Remember == 'true') {
            //var_dump($_SESSION['SESSINFOSEAL']);
            $Token=$this->TokenGen();
            $Expires=time()+(36000);
            $UserID=$retval['r']['0']['User_ID'];
            // Se asigna un token de sesion al usuario y se guarda la cookie para eliminar el proceso de login

            $cnx2=$this->connectSqlSrv();
            $sth2 = $cnx->prepare("exec sp_TokenRegistry  ?, ?, ?");
            $sth2->bindParam(1, $UserID);
            $sth2->bindParam(2, $Token);
            $sth2->bindParam(3, $Expires);
            $retval2=$this->ExecuteNoQuery($sth2);

            $this->LoadCookie($Token);
        }
        session_write_close();

        return json_encode($retval);
    }
    function ClientLogin($User, $Password, $Remember)
    {
        session_start();

        $cnx=$this->connectSqlSrv();
        $sth = $cnx->prepare("exec sp_ClientLogin ?, ?");
        $sth->bindParam(1, $User);
        $sth->bindParam(2, $Password);
        $retval=$this->ExecuteSelectAssoc($sth);

       
        if ($retval['r']['0']['Respuesta']=='Bienvenido') {
            $_SESSION['SESSINFOSEAL'] =$retval['r']['0'];
        } else {
            $retval['error']=true;
        }
        if ($Remember == 'true') {
            //var_dump($_SESSION['SESSINFOSEAL']);
            $Token=$this->TokenGen();
            $Expires=time()+(36000);
            $UserID=$retval['r']['0']['User_ID'];
            // Se asigna un token de sesion al usuario y se guarda la cookie para eliminar el proceso de login

            $cnx2=$this->connectSqlSrv();
            $sth2 = $cnx->prepare("exec sp_TokenRegistry  ?, ?, ?");
            $sth2->bindParam(1, $UserID);
            $sth2->bindParam(2, $Token);
            $sth2->bindParam(3, $Expires);
            $retval2=$this->ExecuteNoQuery($sth2);

            $this->LoadCookie($Token);
        }
        session_write_close();

        return json_encode($retval);
    }

  //Si la pagina es cargada y existe una cookie verifica si debe existir.
  //si no existe un coockie revisa la DB para ver si deberia existir uno y lo crea en caso de ser correcto
    function LoadCookie($Token)
    {
        $cnx=$this->connectSqlSrv();
        $sth = $cnx->prepare("exec sp_GetCookieInfo  ?");
        $sth->bindParam(1, $Token);
        $retval=$this->ExecuteSelectAssoc($sth);

        if ($retval['r'][0]['Token_Expires'] <= time()) {
            setcookie('Auth', $Token, time()-1, '/');
        } else {
            setcookie('Auth', $Token, $retval['r'][0]['Token_Expires'], '/');
        }
    }

    function TokenGen($length = 10)
    {
        $buf = '';
        for ($i = 0; $i < $length; ++$i) {
            $buf .= chr(mt_rand(0, 255));
        }
        return strtoupper(bin2hex($buf));
    }

    public function CheckSession($Current)
    {
        session_start();
        $cnx=$this->connectSqlSrv();

        if (isset($_COOKIE['Auth'])) {
         
            $this->LoadCookie($_COOKIE['Auth']);

            $sth = $cnx->prepare("exec sp_GetSessionData  ?");
            $sth->bindParam(1, $_COOKIE['Auth']);
            $retval=$this->ExecuteSelectAssoc($sth);
            $_SESSION['SESSINFOSEAL'] =$retval['r']['0'];
        }

        if (isset($_SESSION['SESSINFOSEAL'])) {
            if ($Current != 'Login') {
                $sth = $cnx->prepare("exec sp_GetPagePermit  ?");
                $sth->bindParam(1, $Current);

                $PermitNeeded=$this->ExecuteSelectAssoc($sth);
                $PermitNeeded=$PermitNeeded['r'][0]['MinPerm'];

                $retval['Permit']=$PermitNeeded;
            }
            $retval['data']=true;
            $retval['r']=$_SESSION['SESSINFOSEAL']['Role_ID'];
        } else {
            $retval['data']=false;
        }

        session_write_close();
        return json_encode($retval);
    }

    public function LoadTopBar()
    {
        session_start();
        if (isset($_SESSION['SESSINFOSEAL'])) {
            $retval['r']=$_SESSION['SESSINFOSEAL'];
        }
        session_write_close();
        return json_encode($retval);
    }

    public function LogOut()
    {
        $retval=array('data'=>false,
        'error'=>false,
        'r'=>'');

        session_start();
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
        }

        session_destroy();

        if(isset($_COOKIE['Auth'])){
          unset($_COOKIE['Auth']);
          setcookie('Auth', null, -1, '/');
        }

        session_write_close();

        return json_encode($retval);
    }

    public function SideBar()
    {
        session_start();
        $cnx=$this->connectSqlSrv();
        $sth = $cnx->prepare("Exec sp_Sidebar ?");
        $sth->bindParam(1, $_SESSION['SESSINFOSEAL']['Role_ID']);
        $retval=$this->ExecuteSelectAssoc($sth);
        session_write_close();
        return json_encode($retval);
    }

    public function BuildMenu($Level)
    {
        session_start();
        $cnx=$this->connectSqlSrv();
        $sth = $cnx->prepare("Exec sp_MenuBuild ?, ?");
        $sth->bindParam(1, $Level);
        $sth->bindParam(2, $_SESSION['SESSINFOSEAL']['Role_ID']);
        $retval=$this->ExecuteSelectAssoc($sth);
        session_write_close();
        return json_encode($retval);
    }
}
