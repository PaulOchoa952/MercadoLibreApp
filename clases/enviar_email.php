<?php

use PHPMailer\PHPMailer\{PHPMailer,SMTP,Exception};

require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';
require '../phpmailer/src/Exception.php';

$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER; //SMTP::DEBUG_OFF;                     
    $mail->isSMTP();                                            
    $mail->Host       = 'smtp.gmail.com';                     
    $mail->SMTPAuth   = true;                                   
    $mail->Username   = 'equipointerweb@gmail.com';                    
    $mail->Password   = 'equipointer3';                               
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
    $mail->Port       = 465;                                    

    //Recipients
    $mail->setFrom('equipointerweb@gmail.com', 'Equipo 3 interfaces web');
    $mail->addAddress('edwinramon96@gmail.com', 'CLIENTE');    

    //Content
    $mail->isHTML(true);                                 
    $mail->Subject = 'Detalles de su compra';

    $cuerpo = '<h4>Gracias por su ccompra</h4>';
    $cuerpo .= '<p>El ID de su comprra es <b>'. $id_transaccion . '</b></p>';

    $mail->Body    = utf8_decode($cuerpo);
    $mail->AltBody = 'Le enviamos los detalles de su compra.';

    $mail->setLenguaje('es','../phpmailer/language/phpmailer.lang-es.php');

    $mail->send();

} catch (Exception $e) {
    echo "Error al enviar el correo electronico de la cmpra: {$mail->ErrorInfo}";
    exit;
}