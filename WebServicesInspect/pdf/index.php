<?php
require("fpdf/fpdf.php");

$pdf = new FPDF();

$pdf -> AddPage();

// Logo
$pdf->Image('D:/INSPECTIMAGES/1/229105/logospng/orchards.png',5,8,27);
$pdf->Image('D:/INSPECTIMAGES/1/229105/inspectlogo.png',180,8,23);
// Arial bold 15
$pdf->SetFont('Arial','B',15);
// Movernos a la derecha
$pdf->Cell(80);
// Título
$pdf->Cell(30,5,'TRANSPORTES INTERNACIONALES JCV SA DE CV',0,0,'C');
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
$pdf -> Write(0,'11');

//Parte Izquierda
$pdf->SetXY(10,50);
$pdf -> SetFont("Arial", "B", 11);
$pdf -> Write(0,'Inspector: ');
$pdf -> SetFont("Arial", "", 10);
$conversion = utf8_decode(substr("JESÚS GILBERTO BAUTISTA CHÁVEZ", 0, 36));
$pdf -> Write(0,$conversion);

$pdf->SetXY(10,60);
$pdf -> SetFont("Arial", "B", 11);
$conversion = utf8_decode("Fecha De Inspección: ");
$pdf -> Write(0,$conversion);
$pdf -> SetFont("Arial", "", 10);
$pdf -> Write(0,'03/11/2018');

$pdf->SetXY(10,70);
$pdf -> SetFont("Arial", "B", 11);
$conversion = utf8_decode("Tipo De Inspección: ");
$pdf -> Write(0,$conversion);
$pdf -> SetFont("Arial", "", 10);
$conversion = utf8_decode("ENTRADA");
$pdf -> Write(0,$conversion);

$pdf->SetXY(10,80);
$pdf -> SetFont("Arial", "B", 11);
$pdf -> Write(0,'Viaje: ');
$pdf -> SetFont("Arial", "", 10);
$pdf -> Write(0,'201554');

$pdf->SetXY(10,90);
$pdf -> SetFont("Arial", "B", 11);
$pdf -> Write(0,'Fecha De Viaje: ');
$pdf -> SetFont("Arial", "", 10);
$pdf -> Write(0,'02/11/2018');

//Parte Derecha
$pdf->SetXY(110,50);
$pdf -> SetFont("Arial", "B", 11);
$pdf -> Write(0,'Ruta: ');
$pdf -> SetFont("Arial", "", 10);
$conversion = utf8_decode(substr("ZAPOTLAN, JAL - NOGALES, SON POR PAC", 0, 36));
$pdf -> Write(0,$conversion);

$pdf->SetXY(110,60);
$pdf -> SetFont("Arial", "B", 11);
$pdf -> Write(0,'Unidad: ');
$pdf -> SetFont("Arial", "", 10);
$pdf -> Write(0,'JCV-357');

$pdf->SetXY(110,70);
$pdf -> SetFont("Arial", "B", 11);
$conversion = utf8_decode("Odómetro: ");
$pdf -> Write(0,$conversion);
$pdf -> SetFont("Arial", "", 10);
$conversion = utf8_decode("13359.4765");
$pdf -> Write(0,$conversion);

$pdf->SetXY(110,80);
$pdf -> SetFont("Arial", "B", 11);
$pdf -> Write(0,'Porcentaje De Diesel: ');
$pdf -> SetFont("Arial", "", 10);
$pdf -> Write(0,'50.52');

$pdf->SetXY(110,90);
$pdf -> SetFont("Arial", "B", 11);
$pdf -> Write(0,'Operador: ');
$pdf -> SetFont("Arial", "", 10);
$conversion = utf8_decode(substr("JESÚS GILBERTO BAUTISTA LOPEZ", 0, 30));
$pdf -> Write(0,$conversion);

$pdf -> SetFont("Arial", "B", 11);
$pdf->SetXY(30,115);
$pdf -> Write(0,'Arriba');

$pdf->Image('D:/INSPECTIMAGES/1/229105/JCV-553SDer0.jpg',10,120,60,45);
$pdf->SetXY(95,115);
$pdf -> Write(0,'Atras');
$pdf->Image('D:/INSPECTIMAGES/1/229105/image1.jpg',75,120,60);
$pdf->SetXY(160,115);
$pdf -> Write(0,'Derecha');
$pdf->Image('D:/INSPECTIMAGES/1/229105/image1.jpg',140,120,60);

$pdf->SetXY(30,175);
$pdf -> Write(0,'Frontal');
$pdf->Image('D:/INSPECTIMAGES/1/229105/image1.jpg',10,180,60);
$pdf->SetXY(95,175);
$pdf -> Write(0,'Izquierda');
$pdf->Image('D:/INSPECTIMAGES/1/229105/image1.jpg',75,180,60);
$pdf->SetXY(160,175);
$pdf -> Write(0,'Llantas');
$pdf->Image('D:/INSPECTIMAGES/1/229105/image1.jpg',140,180,60);

$pdf->Ln(65);
$pdf -> SetFont("Arial", "", 11);
$pdf->Cell(0,5,utf8_decode('ACEPTO LAS CONDICIONES EN LAS QUE RECIBÍ LA UNIDAD'),0,0,'C');
$pdf->Image('D:/INSPECTIMAGES/1/229105/signature.png',75,250,75);
$pdf->Ln(24);
$pdf->Cell(0,5,utf8_decode('_____________________________________'),0,0,'C');
$pdf->Ln(5);
$pdf->Cell(0,5,utf8_decode('FIRMA DE OPERADOR'),0,0,'C');

$pdf -> AddPage();

// Logo
$pdf->Image('D:/INSPECTIMAGES/1/229105/logospng/orchards.png',65,8,80);
// Arial bold 15
$pdf->SetFont('Arial','B',10);
// Movernos a la derecha
$pdf->Cell(80);
// Título
$pdf->Cell(30,53,'SERVICIO DE AUTOTRANSPORTE FEDERAL DE CARGA',0,0,'C');

$pdf->SetXY(140,50);
$pdf -> SetFont("Arial", "", 9);
$pdf -> Write(0,'Nogales; Sonora a ');
$pdf -> Write(0,'11/02/2018');

$pdf->SetXY(10,60);

$pdf -> SetFont("Arial", "", 10);
$nombre = substr("JESÚS GILBERTO BAUTISTA CHÁVEZ", 0, 36);
$curp = "133404011334040113";
$empresa = "TRANSPORTES LNTERNACIONALES JCV S.A. DE C.V.";
$unidad = "JCV-1524";
$folio = "123546";
$inspector = "JESÚS GILBERTO BAUTISTA LOPEZ";
$pdf->MultiCell(0,6,utf8_decode("Por medio de la presente yo el Sr.- ".$nombre." mayor de edad, presentando mi credencial de elector como mi identificación oficial la cual tiene como clave".
"de registro los números; ".$curp." por mi propio derecho expongo lo siguiente:"),0,'J',false);

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
$pdf->MultiCell(0,6,utf8_decode("TERCERA: Haber recibido el tracto-camión de número económico ".$unidad." el cual se me asigno como parte de mi equipo de trabajo, para desempeñar las actividades ".
"para las cuales fui contratado y cuenta con las siguientes especificaciones:"),0,'J',false);

$pdf->Ln(5);
$pdf-> Write(0,"Marca: PATITO");
$pdf->Ln(5);
$pdf-> Write(0,"Modelo: PATITO");
$pdf->Ln(5);
$pdf-> Write(0,"Matricula: PATITO");
$pdf->Ln(5);
$pdf-> Write(0,utf8_decode("Número de serie:")." PATITO");
$pdf->Ln(5);
$pdf-> Write(0,"Marca: PATITO");
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
$pdf->Image('D:/INSPECTIMAGES/1/229105/signature.png',15,245,60);
$pdf->Ln(24);
$pdf->Cell(0,5,'__________________________________',0,0,'L');
$pdf->Ln(5);
$pdf->Cell(0,5,utf8_decode('             Nombre y firma del operador'),0,0,'L');
$pdf->Ln(5);
$pdf->Cell(0,5,utf8_decode('                           (Recibe)'),0,0,'L');

$pdf->SetXY(0,258);
$pdf->Image('D:/INSPECTIMAGES/1/229105/signature.png',140,245,60);
$pdf->Cell(0,5,'__________________________________',0,0,'R');
$pdf->Ln(5);
$pdf->Cell(0,5,utf8_decode('Nombre y firma del inspector             '),0,0,'R');
$pdf->Ln(5);
$pdf->Cell(0,5,utf8_decode('(Recibe)                           '),0,0,'R');

//$filename="D:/INSPECTIMAGES/1/229105/perra.pdf";
$pdf->Output();

//$pdf -> Close();
?>
