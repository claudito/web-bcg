<?php

include'vendor/autoload.php';
include'modelo/Conexion.php';

$conexion = new Conexion();
$conexion = $conexion->get_conexion();

/*
CONFIG MAIL
*/
define("USER_MAIL", "envio.mail.sistemas@gmail.com");
define("USER_PASS","mochilanegra");

$nombres  = trim(addslashes($_REQUEST['nombres']));
$email    = trim(addslashes($_REQUEST['email']));
$asunto   = trim(addslashes($_REQUEST['subject']));
$message  = trim(addslashes($_REQUEST['message']));


//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;

//Create a new PHPMailer instance
$mail = new PHPMailer;

//Tell PHPMailer to use SMTP
$mail->isSMTP();

//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 0;

//Set the hostname of the mail server
$mail->Host = 'smtp.gmail.com';
// use
// $mail->Host = gethostbyname('smtp.gmail.com');
// if your network does not support SMTP over IPv6

//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$mail->Port = 587;

//Set the encryption system to use - ssl (deprecated) or tls
$mail->SMTPSecure = 'tls';

//UTF-8
$mail->CharSet = 'UTF-8';

//Whether to use SMTP authentication
$mail->SMTPAuth = true;

//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = USER_MAIL;

//Password to use for SMTP authentication
$mail->Password = USER_PASS;

//Set who the message is to be sent from
$mail->setFrom(USER_MAIL, 'BCG CONSULTING');

//Set an alternative reply-to address
//$mail->addReplyTo('replyto@example.com', 'First Last');

//Set who the message is to be sent to
$mail->addAddress($email, $nombres);

//Copia Oculta
//$mail->addBCC('comercial@bcgconsultora.com','BCG');

//Set the subject line
$mail->Subject = 'Consultora BCG SAC - "Especialistas en Psicología Ocupacional"';

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body

//Crear Plantilla;

$query  = "SELECT  * FROM plantilla_correo WHERE id=2";
$statement = $conexion->prepare($query);
$statement->execute();
$result    = $statement->fetch(PDO::FETCH_ASSOC);

$html      = $result['cuerpo'];
$html      = str_replace('#cliente#',$nombres, $html);
$html      = str_replace('#asunto#',$asunto, $html);
$html      = str_replace('#consulta#',$message, $html);
$html      = str_replace('#nombres#',$nombres, $html);
$html      = str_replace('#correo#',$email, $html);
$mail->msgHTML($html);

//$mail->msgHTML(file_get_contents('contents.html'), __DIR__);

//Replace the plain text body with one created manually
//$mail->AltBody = 'This is a plain-text message body';

//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');

//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";

}

?>