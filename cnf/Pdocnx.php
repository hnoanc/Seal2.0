<?php
class ConnectionManager {
	//private $server="DESKTOP-536MU9N\SQLVICIOUS";
    //private $server="(local)";
    //private $server="66.150.174.143";
    private $server="10.80.19.12";
	private $usr="sa";
	private $psw="Ohnomeatropeyan80*";
	private $db="db_Seal";

	public function connectSqlSrv(){
		try{
			$dbCnx = new PDO("sqlsrv:Server=$this->server;Database=$this->db", $this->usr, $this->psw);
			$dbCnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $dbCnx;
		}
		catch(PDOException $e){
			echo $e;
			die();
			return null;
		}
	}

	public function ExecuteNoQuery($sth)
    {
        $r=array('data'=>false,
        'error'=>false,
        'r'=>'');
        try {
            $sth->execute();
            if ($r['r'] = $sth->rowCount()) {
                $r['data'] = true;
            }
        } catch (PDOException $e) {
            $r['error']=true;
            $r['r'] = $e->getMessage();
        }
        return $r;
    }

    public function ExecuteSelectAssoc($sth)
    {
        $r=array('data'=>false,
        'error'=>false,
        'r'=>array());
        try {
            $sth->execute();
            while ($row=$sth->fetch(PDO::FETCH_ASSOC)) {
                $r['data'] = true;
                $keys = array_keys($row);
                $tmp = array();
                foreach($keys as $key)
                {
                    $tmp[$key] = $row[$key];
                }
                array_push($r['r'], $tmp);
            }
        } catch (PDOException $e) {
            $r['error']=true;
            $r['r'] = $e->getMessage();
        }
        return $r;
    }

    public function ExecuteSelectArray($sth)
    {
        $r=array('data'=>false,
        'error'=>false,
        'r'=>array());
        try {
            $sth->execute();
            while ($row=$sth->fetch(PDO::FETCH_NUM)) {
                $r['data'] = true;
                $tmp = array();
                foreach($row as $value)
                {
                    array_push($tmp, $value);
                }
                array_push($r['r'], $tmp);
            }
        } catch (PDOException $e) {
            $r['error']=true;
            $r['r'] = $e->getMessage();
        }
        return $r;
    }
}
?>
