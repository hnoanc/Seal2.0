<?php
        require("../../../cnf/Admin.php");
        $obj =  new Admin();
        if($_GET['UserR']!=null){
            $Data = array(
                'User' => $_GET['UserR'],
                'UserR' => $_GET['User'],
            );
            $data = $obj -> GetUsersTransactionInfoUU($Data);
            $data= json_decode($data,true);
        }
        else{
            $Data = array(
                'User' => $_GET['User'],
                'Type' =>$_GET['Type'],
            );
            $data = $obj -> GetUsersTransactionInfoSD($Data);
            $data= json_decode($data,true);
        }
        require("../../../WebServicesInspect/pdf/fpdf/fpdf.php");

        $pdf = new FPDF();
        $pdf -> AddPage();
        
        // Logo
        $pdf->Image('../../../assets/img/JCV.jpeg',65,10,80,15);
        //$pdf->Image('D:/INSPECTIMAGES/1/229105/inspectlogo.png',180,8,23);
        // Arial bold 15
        $pdf->SetFont('Arial','',10);
        // Título
        $pdf->SetXY(0,15);
        $pdf->Cell(210,15,'SERVICIO DE AUTOTRANSPORTE FEDERAL DE CARGA',0,0,'C');
        $pdf->SetFont('Arial','',10);
        $pdf->SetXY(0,19);
        $pdf->Cell(210,15,'R.F.C. TIJ-920611-C60',0,0,'C');

        //Titulo doc
        $pdf->SetXY(0,50);
        $pdf -> SetFont("Arial", "B", 12);
        $conversion = utf8_decode('DOCUMENTO PARA EL CONTROL DEL INVENTARIO DE SELLOS DE ALTA SEGURIDAD');
        $pdf -> Cell(210,14,$conversion,0,0,"C");
        

        //insertar fecha actual
        $todayText = '';
        $today = getdate();
        //Dia de la semana
        $dayWeek = $today['wday'];
        switch($dayWeek){
            case 0:
            $dayWeek= 'Domingo';
            break;
            case 1:
            $dayWeek= 'Lunes';
            break;
            case 2:
            $dayWeek= 'Martes';
            break;
            case 3:
            $dayWeek= 'Miércoles';
            break;
            case 4:
            $dayWeek= 'Jueves';
            break;
            case 5:
            $dayWeek= 'Viernes';
            break;
            case 6:
            $dayWeek= 'Sábado';
            break;
        }
        $todayText =$todayText.$dayWeek.' '.$today['mday'].' ';
        $month = $today['mon'];
        switch($month){
            case 1:
            $month= 'Enero';
            break;
            case 2:
            $month= 'Febrero';
            break;
            case 3:
            $month= 'Marzo';
            break;
            case 4:
            $month= 'Abril';
            break;
            case 5:
            $month= 'Mayo';
            break;
            case 6:
            $month= 'Junio';
            break;
            case 7:
            $month= 'Julio';
            break;
            case 8:
            $month= 'Agosto';
            break;
            case 9:
            $month= 'Septiembre';
            break;
            case 10:
            $month= 'Octubre';
            break;
            case 11:
            $month= 'Noviembre';
            break;
            case 12:
            $month= 'Diciembre';
            break;
        }
        $todayText =$todayText.'de '.$month.' del año '.$today['year'] ;
        $sealQuantity = $_GET['FinalFolio'] - $_GET['InitialFolio'] + 1;
        //titulo Sección 1
        $pdf->SetXY(20,120);
        $pdf -> SetFont("Arial", "", 13);
        $conversion = utf8_decode('        Por medio de este documento hago constar que yo '.$data['r'][0]['DeliveryName'].' el día '.$todayText.' con el número de empleado '.$data['r'][0]['DeliveryNoEmpleado'].' del departamento '.$data['r'][0]['DeliveryDepartment'].' entregué la cantidad de '.$sealQuantity.' sellos de alta seguridad del folio '.str_pad($_GET['InitialFolio'],6,"0",STR_PAD_LEFT).' al '.str_pad($_GET['FinalFolio'],6,"0",STR_PAD_LEFT).' al empleado '.$data['r'][0]['ReceiveName'].' con número de empleado '.$data['r'][0]['ReceiveNoEmpleado'].' del departamento '.$data['r'][0]['ReceiveDepartment'].' por concepto de abastecimiento de los mismos.');
        $pdf->MultiCell(170,5,$conversion);
        
        
        
        
        $pdf->SetXY(35,200);
        $pdf -> SetFont("Arial", "", 13);
        $conversion = utf8_decode('Recibe');
        $pdf -> Cell(50,6,$conversion,0,0,"C",false);
        $pdf->SetXY(35,220);
        $pdf -> SetFont("Arial", "", 13);
        $conversion = utf8_decode('_________________________');
        $pdf -> Cell(50,6,$conversion,0,0,"C",false);
        $pdf->SetXY(35,228);
        $pdf -> SetFont("Arial", "", 13);
        $conversion = utf8_decode($data['r'][0]['ReceiveName']);
        $pdf -> Cell(50,6,$conversion,0,0,"C",false);



        $pdf->SetXY(130,200);
        $pdf -> SetFont("Arial", "", 13);
        $conversion = utf8_decode('Entrega');
        $pdf -> Cell(50,6,$conversion,0,0,"C",false);
        $pdf->SetXY(130,220);
        $pdf -> SetFont("Arial", "", 13);
        $conversion = utf8_decode('_________________________');
        $pdf -> Cell(50,6,$conversion,0,0,"C",false);
        $pdf->SetXY(130,228);
        $pdf -> SetFont("Arial", "", 13);
        $conversion = utf8_decode($data['r'][0]['DeliveryName']);
        $pdf -> Cell(50,6,$conversion,0,0,"C",false);
        

   
        //pie de pagina
        $pdf->SetXY(120,261);
        $pdf -> SetFont("Arial", "", 10); 
        $conversion = utf8_decode('Transportes Internacionales JCV S.A. de C.V.');
        $pdf -> Cell(100,6,$conversion,0,0,"C",false);
        $pdf->SetXY(103,265);
        $pdf -> SetFont("Arial", "", 10); 
        $conversion = utf8_decode(' Carretera Internacional KM20, Nogales, Sonora, México. CP 84000');
        $pdf -> Cell(100,6,$conversion,0,0,"C",false);
        $pdf->SetXY(139,269);
        $pdf -> SetFont("Arial", "", 10); 
        $conversion = utf8_decode(' Tel. (631) 2 09 40 30');
        $pdf -> Cell(100,6,$conversion,0,0,"C",false);

        $pdf->Output();
        $pdf -> Close();
?>
