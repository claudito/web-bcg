<?php 

include'../vendor/autoload.php';
include'../modelo/Conexion.php';

$conexion = new Conexion();
$conexion = $conexion->get_conexion();

/*
CONFIG MAIL
*/
define("USER_MAIL", "envio.mail.sistemas@gmail.com");
define("USER_PASS","mochilanegra");

$opcion   = $_REQUEST['op'];

switch ($opcion) {
	case 1:

$query  = "SELECT  * FROM plantilla_correo";
$statement = $conexion->prepare($query);
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);

$json   = ['data'=>$result];

echo json_encode($json);



		break;
	case 2:

$id = $_REQUEST['id'];

$query  = "SELECT  * FROM plantilla_correo WHERE id=:id";
$statement = $conexion->prepare($query);
$statement->bindParam(':id',$id);
$statement->execute();
$result    = $statement->fetch(PDO::FETCH_ASSOC);

echo json_encode($result);

		break;


	case 3:

	$id     = $_REQUEST['id'];

	$cuerpo = trim($_REQUEST['cuerpo']);

	$query  = "UPDATE  plantilla_correo SET cuerpo=:cuerpo WHERE id=:id";
	$statement = $conexion->prepare($query);
	$statement->bindParam(':id',$id);
	$statement->bindParam(':cuerpo',$cuerpo);
	$statement->execute();
	echo "ok";

	break;

	case 4:

$id      =  $_REQUEST['id'];
$correo  =  trim($_REQUEST['email']);

//Create a new PHPMailer instance
$mail = new PHPMailer\PHPMailer\PHPMailer;

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
$mail->addAddress($correo, 'BCG PLANTILLA');

//Copia Oculta
//$mail->addBCC('comercial@bcgconsultora.com','BCG');

//Set the subject line
$mail->Subject = 'BCG PLANTILLA';

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body

//Crear Plantilla;

$query  = "SELECT  * FROM plantilla_correo WHERE id=:id";
$statement = $conexion->prepare($query);
$statement->bindParam(':id',$id);
$statement->execute();
$result    = $statement->fetch(PDO::FETCH_ASSOC);

$html      = $result['cuerpo'];
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
   





	break;
	
	default:
	echo "opción no disponible";
		break;
}





 ?>