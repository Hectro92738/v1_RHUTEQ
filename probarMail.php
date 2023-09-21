<?php
ini_set('display_errors',1); error_reporting(E_ALL);
// Importar la clase PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Cargar el archivo de autoloader de Composer

require '../vendor/autoload.php';

// Crear una nueva instancia de PHPMailer
$mail = new PHPMailer(true);

try {
    // Configurar el servidor SMTP
    //$mail->SMTPDebug=smtp::DEBUG_SERVER;
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com'; // El host del servidor SMTP
    $mail->SMTPAuth   = true;             // Habilitar la autenticaci�n SMTP
    $mail->Username   = 'percepcionesuteq@uteq.edu.mx';//'zendy.perez@uteq.edu.mx';//// Tu correo electr�nico
    $mail->Password   = 'qdlnrvmgqfjxhfzp';//'uwrdzdecjlfmqqsa ';// // Tu contrase�a
    $mail->SMTPSecure = 'tls';            // Habilitar la encriptaci�n TLS
    $mail->Port       = 587;              // El puerto SMTP para la conexi�n

    // Configurar el correo electr�nico
    $mail->setFrom('percepcionesuteq@uteq.edu.mx', 'RECIBOS ELECTRONICOS UTEQ');
    $mail->addAddress('zendy.perez@uteq.edu.mx', 'PEREZ VILLEDA ZENDY');
    //$mail->addReplyTo('pevize@gmail.com', 'Tu nombre');

    $mail->isHTML(true); // Habilitar el formato HTML
    $mail->Subject = 'RECIBO TIMBRADO XML Y PDF';
    $mail->Body    = 'Contenido del correo electr�nico en formato HTML';
	$pathPDF="AAAH6611271311527829.pdf";
	$pathXML="AAAH661127131_4651670_2023-07-15.xml";
	$productos = array($pathPDF,$pathXML);
	$j = 0;
	 
	foreach($productos as $clave=>$elemento)
	{
	   echo "Elemento $clave: $elemento <br>";
	   $mail->AddAttachment($elemento); 
	   ++$j;
	}
	
    // Enviar el correo electr�nico
    $mail->send();
    echo 'El correo electr�nico ha sido enviado correctamente.';
} catch (Exception $e) {
    echo "El correo electr�nico no se pudo enviar. Error: {$mail->ErrorInfo}";
}
?>


