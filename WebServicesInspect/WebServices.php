<?php
require_once('Pdocnxws.php');
class WebServices extends ConnectionManager
{
  function UserLogin($User, $Pss, $Company){
    $cnx=$this->connectSqlSrv();
		$sth = $cnx->prepare("exec sp_InsUserLogin ?, ?, ?");
    $sth->bindParam(1, $User);
    $sth->bindParam(2, $Pss);
    $sth->bindParam(3, $Company);
    $retval=$this->ExecuteSelectAssoc($sth);

    return json_encode($retval);
  }

  function GetUnits($UnitType, $Company){
    $cnx=$this->connectSqlSrv();
		$sth = $cnx->prepare("exec sp_GetUnits ?, ?");
    $sth->bindParam(1, $UnitType);
    $sth->bindParam(2, $Company);
    $retval=$this->ExecuteSelectAssoc($sth);

    return json_encode($retval);
  }

  function GetTrips($EmpresaID, $EntSal, $OpcionFiltro, $NoViaje, $Tracto, $Caja){
    $cnx=$this->connectSqlSrv();
    $sth = $cnx->prepare("exec spBuscarViajes ?,?,?,?,?,?");
    $sth->bindParam(1, $EmpresaID);
    $sth->bindParam(2, $EntSal);
    $sth->bindParam(3, $OpcionFiltro);
    $sth->bindParam(4, $NoViaje);
    $sth->bindParam(5, $Tracto);
    $sth->bindParam(6, $Caja);
    $retval=$this->ExecuteSelectAssoc($sth);

    return json_encode($retval);
  }

  function GetDrivers($Company){
    $cnx=$this->connectSqlSrv();
		$sth = $cnx->prepare("exec sp_GetDrivers ?");
    $sth->bindParam(1, $Company);
    $retval=$this->ExecuteSelectAssoc($sth);

    return json_encode($retval);
  }

  function GetDriverPhotos($Name, $Company){
    $cnx=$this->connectSqlSrv();
    $sth = $cnx->prepare("exec spGetDriverImages ?, ?");
    $sth->bindParam(1, $Name);
    $sth->bindParam(2, $Company);
    $retval=$this->ExecuteSelectAssoc($sth);

    $foto = $retval['r'][0]['Foto']; $firma = $retval['r'][0]['Firma'];
    $imagen = null;
    if($foto != "MA==")
    {
      $imagen = $this -> ResizeImage(imagecreatefromstring(base64_decode($foto)), 205, 180);
      $foto = base64_encode($imagen);
    }
    if($firma != "MA==")
    {
      $imagen = $this -> ResizeImage(imagecreatefromstring(base64_decode($firma)), 102, 180);
      $firma = base64_encode($imagen);
    }

    $retval['r'][0]['Foto'] = $foto;
    $retval['r'][0]['Firma'] = $firma;

    return json_encode($retval);
  }

  function UploadImage($PostInfo){
    //Subo las imagenes al servidor
    $original_file_path = "D:/INSPECTIMAGES/";
    $adapted_file_path = $original_file_path.$PostInfo->{"route"};

    if (!file_exists($adapted_file_path))  {
        mkdir($adapted_file_path, 0777, true);
    }

    $cont = $PostInfo->{"count"};

    $data = $PostInfo->{"img".$cont};
    file_put_contents($adapted_file_path.$PostInfo->{"unit"}.$cont.".jpg", base64_decode($data));

    $retval['r'][0]['Response'] = "Ya Quedo";

    return json_encode($retval);
  }

  function UploadInfo($PostInfo){
    //Subo la firma
    $original_file_path = "D:/INSPECTIMAGES/";
    $adapted_file_path = $original_file_path."/".$PostInfo->{"company_id"}."/".$PostInfo->{"no_viaje"}."/".$PostInfo->{"ent_sal"}."/".$PostInfo->{"caja_o_tracto_id"}."/";

    $data = $PostInfo->{"signature"};
    $data2 = $PostInfo->{"signatureinsp"};
    if (!file_exists($adapted_file_path))  {
        mkdir($adapted_file_path, 0777, true);
    }

    if($data != "")
    {
      file_put_contents($adapted_file_path."signature.png", base64_decode($data));
    }

    if($data2 != "")
    {
      file_put_contents($adapted_file_path."signatureinsp.png", base64_decode($data2));
    }

    //Subo la informacion a la base de datos
    $cnx=$this->connectSqlSrv();
    $sth = $cnx->prepare("exec spUploadInspectionInfo ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?");
    $sth->bindParam(1, $PostInfo->{"no_viaje"});
    $sth->bindParam(2, $PostInfo->{"company_id"});
    $sth->bindParam(3, $PostInfo->{"ent_sal"});
    $sth->bindParam(4, $PostInfo->{"caja_o_tracto_id"});
    $sth->bindParam(5, $PostInfo->{"unidad"});
    $sth->bindParam(6, $PostInfo->{"motor_hours_km_miles"});
    $sth->bindParam(7, $PostInfo->{"total_hours"});
    $sth->bindParam(8, $PostInfo->{"diesel_percent"});
    $sth->bindParam(9, $PostInfo->{"driver_id"});
    $sth->bindParam(10, $PostInfo->{"user_id"});
    $sth->bindParam(11, $PostInfo->{"gmtfecha"});
    $sth->bindParam(12, $PostInfo->{"tiposdeinspeccion"});
    $sth->bindParam(13, $PostInfo->{"fechaviaje"});
    $sth->bindParam(14, $PostInfo->{"rutaviaje"});
    $retval2=$this->ExecuteSelectAssoc($sth);

    if(($PostInfo->{"caja_o_tracto_id"} == "2") & ($PostInfo->{"ent_sal"} == "S"))
    {
      $this -> Build_PDF($adapted_file_path, $PostInfo->{"no_viaje"}, $PostInfo->{"company_id"}, $PostInfo->{"unidad"}, $PostInfo->{"company_id_insp"});
    }

    return json_encode($retval2);
  }

  function Build_PDF($Ruta, $Viaje, $Company, $Unidad, $CompanyInsp){
    require("pdf/fpdf/fpdf.php");
    $cnx=$this->connectSqlSrv();
    $sth = $cnx->prepare("exec sp_GetPDFInfo ?, ?, ?, ?");
    $sth->bindParam(1, $Viaje);
    $sth->bindParam(2, $Company);
    $sth->bindParam(3, $Unidad);
    $sth->bindParam(4, $CompanyInsp);
    $retval=$this->ExecuteSelectAssoc($sth);

    $nombre = substr($retval['r'][0]['NombreOpe'], 0, 36);
    $licencia = $retval['r'][0]['LicenciaOpe'];
    $empresa = $retval['r'][0]['DescripcionEmp'];
    $folio = $retval['r'][0]['Folio'];
    $inspector = $retval['r'][0]['NombreInsp'];

    $pdf = new FPDF();

    $pdf -> AddPage();

    // Logo
    $pdf->Image('D:/INSPECTIMAGES/logospng/'.$Company.'.png',5,8,27);
    $pdf->Image('D:/INSPECTIMAGES/logospng/inspectlogo.png',180,8,23);
    // Arial bold 15
    $pdf->SetFont('Arial','B',15);
    // Movernos a la derecha
    $pdf->Cell(80);
    // Título
    $pdf->Cell(30,5,$empresa,0,0,'C');
    // Salto de línea
    $pdf->Ln(10);
    $pdf -> SetFont("Arial", "B", 13);
    $conversion = utf8_decode("INSPECCIÓN DE VIAJE");
    $pdf -> Cell(0,5,$conversion,0,0,"C");

    //Parte Izquierda
    $pdf->SetXY(95,30);
    $pdf -> SetFont("Arial", "B", 12);
    $pdf -> Write(0,'Folio: ');
    $pdf -> SetFont("Arial", "", 12);
    $pdf -> Write(0,$folio);

    //Parte Izquierda
    $pdf->SetXY(10,50);
    $pdf -> SetFont("Arial", "B", 11);
    $pdf -> Write(0,'Inspector: ');
    $pdf -> SetFont("Arial", "", 10);
    $conversion = utf8_decode(substr($inspector, 0, 36));
    $pdf -> Write(0,$conversion);

    $pdf->SetXY(10,60);
    $pdf -> SetFont("Arial", "B", 11);
    $conversion = utf8_decode("Fecha De Inspección: ");
    $pdf -> Write(0,$conversion);
    $pdf -> SetFont("Arial", "", 10);
    $pdf -> Write(0,$retval['r'][0]['FechaInsp']);

    $pdf->SetXY(10,70);
    $pdf -> SetFont("Arial", "B", 11);
    $conversion = utf8_decode("Tipo De Inspección: ");
    $pdf -> Write(0,$conversion);
    $pdf -> SetFont("Arial", "", 10);
    $pdf -> Write(0,"SALIDA");

    $pdf->SetXY(10,80);
    $pdf -> SetFont("Arial", "B", 11);
    $pdf -> Write(0,'Viaje: ');
    $pdf -> SetFont("Arial", "", 10);
    $pdf -> Write(0,$Viaje);

    $pdf->SetXY(10,90);
    $pdf -> SetFont("Arial", "B", 11);
    $pdf -> Write(0,'Fecha De Viaje: ');
    $pdf -> SetFont("Arial", "", 10);
    $pdf -> Write(0,$retval['r'][0]['FechaViaje']);

    //Parte Derecha
    $pdf->SetXY(110,50);
    $pdf -> SetFont("Arial", "B", 11);
    $pdf -> Write(0,'Ruta: ');
    $pdf -> SetFont("Arial", "", 10);
    $conversion = utf8_decode(substr($retval['r'][0]['RutaViaje'], 0, 36));
    $pdf -> Write(0,$conversion);

    $pdf->SetXY(110,60);
    $pdf -> SetFont("Arial", "B", 11);
    $pdf -> Write(0,'Unidad: ');
    $pdf -> SetFont("Arial", "", 10);
    $pdf -> Write(0,$Unidad);

    $pdf->SetXY(110,70);
    $pdf -> SetFont("Arial", "B", 11);
    $conversion = utf8_decode("Millaje: ");
    $pdf -> Write(0,$conversion);
    $pdf -> SetFont("Arial", "", 10);
    $pdf -> Write(0,$retval['r'][0]['Millaje']);

    $pdf->SetXY(110,80);
    $pdf -> SetFont("Arial", "B", 11);
    $pdf -> Write(0,'Porcentaje De Diesel: ');
    $pdf -> SetFont("Arial", "", 10);
    $pdf -> Write(0,$retval['r'][0]['PorcentajeDiesel']);

    $pdf->SetXY(110,90);
    $pdf -> SetFont("Arial", "B", 11);
    $pdf -> Write(0,'Operador: ');
    $pdf -> SetFont("Arial", "", 10);
    $conversion = utf8_decode(substr($nombre, 0, 30));
    $pdf -> Write(0,$conversion);

    $pdf -> SetFont("Arial", "B", 11);
    $pdf->SetXY(30,115);
    $pdf -> Write(0,'Arriba');
    $pdf->Image($Ruta.'Arr/'.$Unidad.'SArr0.jpg',10,120,60,45);
    $pdf->SetXY(95,115);
    $pdf -> Write(0,'Atras');
    $pdf->Image($Ruta.'Atr/'.$Unidad.'SAtr0.jpg',75,120,60,45);
    $pdf->SetXY(160,115);
    $pdf -> Write(0,'Derecha');
    $pdf->Image($Ruta.'Der/'.$Unidad.'SDer0.jpg',140,120,60,45);

    $pdf->SetXY(30,175);
    $pdf -> Write(0,'Frontal');
    $pdf->Image($Ruta.'Fro/'.$Unidad.'SFro0.jpg',10,180,60,45);
    $pdf->SetXY(95,175);
    $pdf -> Write(0,'Izquierda');
    $pdf->Image($Ruta.'Izq/'.$Unidad.'SIzq0.jpg',75,180,60,45);
    $pdf->SetXY(160,175);
    $pdf -> Write(0,'Llantas');
    $pdf->Image($Ruta.'Lla/'.$Unidad.'SLla0.jpg',140,180,60,45);

    $pdf->Ln(65);
    $pdf -> SetFont("Arial", "", 11);
    $pdf->Cell(0,5,utf8_decode('ACEPTO LAS CONDICIONES EN LAS QUE RECIBÍ LA UNIDAD'),0,0,'C');
    //$pdf->Image($Ruta.'signature.png',75,250,75);
    $pdf->Ln(24);
    $pdf->Cell(0,5,utf8_decode('_____________________________________'),0,0,'C');
    $pdf->Ln(5);
    $pdf->Cell(0,5,utf8_decode('FIRMA DE OPERADOR'),0,0,'C');

    $pdf -> AddPage();

    // Logo
    $pdf->Image('D:/INSPECTIMAGES/logospng/'.$Company.'.png',65,8,80);
    // Arial bold 15
    $pdf->SetFont('Arial','B',10);
    // Movernos a la derecha
    $pdf->Cell(80);
    // Título
    $pdf->Cell(30,53,'SERVICIO DE AUTOTRANSPORTE FEDERAL DE CARGA',0,0,'C');

    $pdf->SetXY(140,50);
    $pdf -> SetFont("Arial", "", 9);
    $pdf -> Write(0,'Nogales; Sonora a ');
    $pdf -> Write(0,$retval['r'][0]['FechaInsp']);

    $pdf->SetXY(10,60);

    $pdf -> SetFont("Arial", "", 10);
    $pdf->MultiCell(0,6,utf8_decode("Por medio de la presente yo el Sr.- ".$nombre." mayor de edad, presentando mi licencia de conducir como mi identificación oficial la cual tiene como clave ".
    "de registro los números; ".$licencia." por mi propio derecho expongo lo siguiente:"),0,'J',false);

    $pdf->SetXY(10,90);
    //$pdf -> SetFont("Arial", "B", 10);
    $pdf -> Write(0,'PRIMERA: ');
    //$pdf -> SetFont("Arial", "", 9);
    $pdf -> Write(0,utf8_decode("Laborar en la empresa denominada ".$empresa));
    $pdf->Ln(7);
    //$pdf -> SetFont("Arial", "B", 10);
    $pdf -> Write(0,'SEGUNDA: ');
    //$pdf -> SetFont("Arial", "", 9);
    $pdf -> Write(0,utf8_decode("Desempeñar la función de operador de tracto-camión, labor para la cual fui contratado."));
    $pdf->Ln(4);
    //$pdf -> SetFont("Arial", "B", 10);
    $pdf->MultiCell(0,6,utf8_decode("TERCERA: Haber recibido el tracto-camión de número económico ".$Unidad." el cual se me asigno como parte de mi equipo de trabajo, para desempeñar las actividades ".
    "para las cuales fui contratado y cuenta con las siguientes especificaciones:"),0,'J',false);

    $pdf->Ln(5);
    $pdf-> Write(0,"Marca: ".$retval['r'][0]['Marca']);
    $pdf->Ln(5);
    $pdf-> Write(0,"Modelo: ".$retval['r'][0]['Modelo']);
    $pdf->Ln(5);
    $pdf-> Write(0,"Matricula: ".$retval['r'][0]['Matricula']);
    $pdf->Ln(5);
    $pdf-> Write(0,utf8_decode("Número de serie: ").$retval['r'][0]['NoSerie']);
    $pdf->Ln(5);
    $pdf-> Write(0,"Motor: ".$retval['r'][0]['Motor']);
    $pdf->Ln(5);
    $pdf->MultiCell(0,6,utf8_decode("CUARTA: Mi compromiso para resguardar y mantener en optimas e integras condiciones para su correcto funcionamiento el equipo que se me asigno. ".
    "Por lo cual se realizó inventario general de tracto-camión con número de folio: ".$folio." realizado por el Sr.- ".$inspector." donde se anexa soporte fotográfico de las especificaciones del mismo, ".
    "el cual firme de conformidad."),0,'J',false);
    $pdf->Ln(2);
    $pdf->MultiCell(0,6,utf8_decode("QUINTA: Regresar el equipo cuando así sea necesario en condiciones operables, con la excepción del deterioro natural por carga de trabajo sin haber realizado modificación ".
    "alguna sin previa autorización, esto con fundamento en el artículo 47 fracciones 'V' y 'VI' de la ley federal del trabajo el cual prevé, que son causas de rescisión de la relación de trabajo, ".
    "sin responsabilidad para el patrón:"),0,'J',false);
    $pdf->Ln(2);
    $pdf -> SetFont("Arial", "", 9);
    $pdf->MultiCell(0,5,utf8_decode("V.	Ocasionar el trabajador, intencionalmente, perjuicios materiales durante el desempeño de las labores o con motivo de ellas, en los edificios, obras, ".
    "maquinaria, instrumentos, materias primas y demás objetos relacionados con el trabajo.
    VI.	Ocasionar el trabajador los perjuicios de que habla la fracción anterior siempre que sean graves, sin dolo, pero con negligencia tal, que ella sea la causa única del perjuicio."),0,'J',false);

    $pdf->Ln(13);
    $pdf -> SetFont("Arial", "", 9);
    //$pdf->Image($Ruta.'signature.png',15,245,60);
    $pdf->Ln(24);
    $pdf->Cell(0,5,'__________________________________',0,0,'L');
    $pdf->Ln(5);
    $pdf->Cell(0,5,utf8_decode('             Nombre y firma del operador'),0,0,'L');
    $pdf->Ln(5);
    $pdf->Cell(0,5,utf8_decode('                           (Recibe)'),0,0,'L');

    $pdf->SetXY(0,258);
    //$pdf->Image($Ruta.'signatureinsp.png',140,245,60);
    $pdf->Cell(0,5,'__________________________________',0,0,'R');
    $pdf->Ln(5);
    $pdf->Cell(0,5,utf8_decode('Nombre y firma del inspector             '),0,0,'R');
    $pdf->Ln(5);
    $pdf->Cell(0,5,utf8_decode('(Otorga)                           '),0,0,'R');

    $filename=$Ruta.$Viaje.'-'.$Unidad.'.pdf';
    $pdf->Output($filename,'F');

    $pdf -> Close();
  }

  function QRZSearchGuards(){
    $cnx=$this->connectSqlSrv();
    $sth = $cnx->prepare("exec sp_QRZGetGuards");
    $retval=$this->ExecuteSelectAssoc($sth);

    return json_encode($retval);
  }

  function QRZUploadInfo($Ids, $Zonas, $Fechas){
    $array_ids = explode(",",$Ids);
    $array_zonas = explode(",",$Zonas);
    $array_fechas = explode(",",$Fechas);

    $Query = "";
    $final_limit = count($array_ids) - 1;
    for($i=0;$i<$final_limit;$i++)
    {
      for($j = 1; $j <=50; $j++)
  		{
  			if(hash('crc32',$j) == $array_zonas[$i])
  			{
          $Query .= ("('".$array_ids[$i]."',".$j.",'".$array_fechas[$i]."'),");
          break;
  			}
  		}
    }
    $Query = substr($Query, 0, -1);

    $cnx=$this->connectSqlSrv();
    $sth = $cnx->prepare("exec sp_QRZUploadInfo ?");
    $sth->bindParam(1, $Query);
    $retval=$this->ExecuteSelectAssoc($sth);

    return json_encode($retval);
  }

  function ResizeImage($image, $max_height, $max_width){
    $img_original = $image;

    $width = imagesx($image);
    $height = imagesy($image);

    $image_p = imagecreatetruecolor($max_width, $max_height);
    imagecopyresampled($image_p, $img_original, 0, 0, 0, 0, $max_width, $max_height, $width, $height);

    ob_start();
    imagepng($image_p);
    $data = ob_get_contents();
    ob_end_clean();

    return $data;
  }
}
 ?>
