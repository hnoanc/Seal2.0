<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load composer's autoloader
require '../../vendor/autoload.php';

$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();
    $mail->SMTPOptions = array(
    	'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    	)
    );                                      // Set mailer to use SMTP
    $mail->Host = 'tls://smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'helpitmhtjcv@gmail.com';                 // SMTP username
    $mail->Password = 'Jcv0817*';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('helpitmhtjcv@gmail.com', 'Departamento de Sistemas');
    $mail->addAddress('hleal@mht-jcv.net', 'Hernan Leal');     // Add a recipient
    $mail->addAddress('lsanchez@mht-jcv.com.mx', 'Leyda Sanchez');
    $mail->addAddress('it@mht-jcv.net', 'Jesus Bautista');
    $mail->addAddress('rafael@mht-jcv.com.mx', 'Rafael Espericueta');
    $mail->addAddress('jrsanchez@mht-jcv.com', 'Jorge Sanchez');    

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Ticket Nuevo.';
    $mail->Body    = '<html>
    <head>
        <style>
        table {
          font-family:"Poppins", sans-serif;
          font-size:15px;
        }
        .LightGray{
          background-color: #e5e6e6;
          margin: 10px 0px;
          align-content: center;
        }
        .DarkGray{
          background-color: #fff;
        }
        .DarkGray td{
          color: #666;
        }
        .LogoStyle{
        height: 50px;
        width: auto;
        padding: 20px;
        }
        .Text{
          text-align: center;
          padding: 20px;
        }
        .Footer{
          background-color: #212121;
          color: #fff;
        }
        .Contactos{
          text-align: center;
          color: #e5e6e6;
          font-style: normal;
        }
        h1, h2, h3, h4, h5, h6{
          font-family:"Open Sans", sans-serif;
        }
        </style>
    </head>
    <body>
      <table width="750px">
        <tbody>
        <tr class="LightGray">
          <td style="text-align:center;"><img src="http://helpit.mht-jcv.com/assets/img/HITSmall.png" class="LogoStyle"></td>
        </tr>
        <tr class="DarkGray Text" style="height:400px">
            <td style="padding: 20px 0px">
              <h1>Un Usuario creo un ticket Nuevo</h1>
              <a href="http://helpit.mht-jcv.com/html/IT/Tickets_Disponibles/index.html">http://helpit.mht-jcv.com/html/IT/Tickets_Disponibles/index.html</a>
            </td>
        </tr>
        <tr>
          <td class="Footer Text">
          <h3>CONTACTO</h3>
          <table class="Contactos" width="100%">
            <tr>
              <td>
                <h4>Rafael Espericueta</h4>
                  <h5>Ext. 112</h5>
                  <h5>rafael@mht-jcv.com.mx</h5>
              </td>
              <td>
                <h4>Hernan Leal</h4>
                <h5>Ext. 138</h5>
                <h5>hleal@mht-jcv.net</h5>
              </td>
              <td>
                <h4>Jesus Bautista</h4>
                <h5>Ext. 149</h5>
                <h5>it@mht-jcv.net</h5>
              </td>
              <td>
                <h4>Jorge Sanchez</h4>
                <h5>Ext. 136 / 148</h5>
                <h5>jrsanchez@mht-jcv.com.mx</h5>
              </td>
              <td>
                <h4>Leyda Sanchez</h4>
                <h5>Ext. 153</h5>
                <h5>it@mht-jcv.net</h5>
              </td>
            </tr>
          </table>
          <h6>Copyright c 2017 Departamento de sistemas.</h6>
          </td>
        </tr>
        </tbody>
      </table>
    </body>
    </html>';
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}
