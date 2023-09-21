<?php
//include ("master.php");
ini_set('display_errors',1); error_reporting(E_ALL);
include("SQLquerys/querysTimbrado.php");
require '../vendor/autoload.php';
// Importar la clase PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
//cabeza();

if(isset($_POST["accion"])) {
	
	switch ($_POST["accion"]) {
	  case 'mailDP': { enviarMasivosCorreo($_POST["tipoNomina"],$_POST["fechaPago"]); 
	  break;}
	  /*case 'mailRecibos': { enviarCorreo($_POST["tipoNomina"],$_POST["fechaPago"],"125377");*/
	  case 'mailRecibos': { enviarMasivosCorreo($_POST["tipoNomina"],$_POST["fechaPago"]); 
	  break;}

	}
}

/***LEER CARPETA DE PDF */
function insertDatos($pathPDF,$fechaPago){
    //$thefolder = "RECIBOS/2023/03/15/pdf/";
    $thefolder = $pathPDF;
    if ($handler = opendir($thefolder)) {
        while (false !== ($file = readdir($handler))) {
                $file;
                $arrayNombre=explode(".", $file); 
                $rfcPdf=$arrayNombre[0]; //13 POSICIONES RFC
                $eRFC = substr($rfcPdf,0,13); 
                $eRFC=trim($eRFC);
                //echo "emp:".$eRFC."<br>";
                $bdNumEmp=returncampo("num_emp","emp_uteq","rfc_emp",$eRFC);  
                //echo $bdNumEmp."<br>";
                if($bdNumEmp<>0){
                    insertPath($bdNumEmp,$pathPDF."/".$file,$fechaPago,'NOMINA');
                }

        }
        closedir($handler);
    }
}
function updateXML($pathXML,$fechaPago){
    //$thefolder = "RECIBOS/2023/03/15/xml/";
    $thefolder = $pathXML;
    if ($handler = opendir($thefolder)) {
        while (false !== ($file = readdir($handler))) {
                //echo "$file<br>";
                $arrayNombre=explode("_", $file); 
                $eRFC=$arrayNombre[0]; //13 POSICIONES RFC
                $eRFC = substr($eRFC, 0, 13); 
                $eRFC=trim($eRFC);
                //echo $eRFC;
                $bdNumEmp=returncampo("num_emp","emp_uteq","rfc_emp",$eRFC);  
               //echo $bdNumEmp."<br>";
                if($bdNumEmp<>0){
                    updatePathXML($bdNumEmp,$pathXML."/".$file);
                }


        }
        closedir($handler);
    }
}
/*function enviarMasivosCorreo($tipoNomina,$fechaPago){
	//echo $tipoNomina."<br>";
	//echo $fechaPago;
	$num_empls=enviarMasivos($tipoNomina,$fechaPago);
	//var_dump($num_empls);
	//echo $num_empls[0];
    //$enviarCorreo=enviarCorreo($tipoNomina,$fechaPago);
	foreach ($num_empls as $clave=>$valor)
   	{
   		//echo "El valor de $clave es: $valor";
		enviarCorreo($tipoNomina,$fechaPago,$valor);
   	}
	
}*/
function enviarMasivosCorreo($tipoNomina,$fechaPago ){
	echo $tipoNomina."<br>";
	echo $fechaPago;
	
	$num_empls=enviarMasivos($tipoNomina,$fechaPago);
	//var_dump($num_empls);
	//echo $num_empls[0];
    //$enviarCorreo=enviarCorreo($tipoNomina,$fechaPago);
	foreach ($num_empls as $clave=>$valor)
   	{
   		//echo "El valor de $clave es: $valor";
		enviarCorreo($tipoNomina,$fechaPago,$valor);
   	}
	
}
function enviarCorreo($tipoNomina,$fechaPago,$id_emp){
	/*echo $tipoNomina."<br/>";
	echo $fechaPago."<br/>";
	echo $id_emp."<br/>";*/
	$anio=date("Y");
    $mail = new PHPMailer(true);

	try {
		$mail->isSMTP();
		$mail->Host       = 'smtp.gmail.com'; // El host del servidor SMTP
		$mail->SMTPAuth   = true;             // Habilitar la autenticación SMTP
		$mail->Username   = 'percepcionesuteq@uteq.edu.mx'; // Tu correo electrónico
		$mail->Password   = 'qdlnrvmgqfjxhfzp';//'hvcwhmrscasekjjz';//'mvlxuhcrgpqwtjeh';//'qmywsmczlmqukcup';//'ebpnaqppjggvkxgz';//'mvlxuhcrgpqwtjeh';   // Tu contraseña
		$mail->SMTPSecure = 'tls';            // Habilitar la encriptación TLS
		$mail->Port       = 587;              // El puerto SMTP para la conexión

    // Configurar el correo electrónico
    if($tipoNomina=='DP'){
		$mail->setFrom('percepcionesuteq@uteq.edu.mx', 'HOJA AYUDA DECLARACION PATRIMONIAL');
		$nombre=enviarMail($id_emp,"e.nombre",$fechaPago,'DP');
		$correo=enviarMail($id_emp,"e.correo",$fechaPago,'DP');
		//echo "este es el correo:".var_dump($correo)."<br/>";
		$mail->addAddress($correo,$nombre);
		//$mail->addReplyTo('pevize@gmail.com', 'Tu nombre');

		$mail->isHTML(true); // Habilitar el formato HTML
		$mail->Subject = 'RECIBO DECLARACION PATRIMONIAL'.$anio;
		$pathPDF=enviarMail($id_emp,"p.pathPDF",$fechaPago,'DP');
			//$pathXML=enviarMail($id_emp,"p.pathPDF",$fechaPago);
		$mail->Body    = '<br/>Estimado(a) '.$nombre."<br/><br/><br/>
						 A continuación se anexa la hoja de ayuda para la declaración patrimonial: ".$anio.".<br/><br/>
						  Favor de no responder este correo debido a que es un envío  automatizado.<br/><br/>
						 Saludos.<br/><br/>";
		$mail->AddAttachment($pathPDF); 
	}else if($tipoNomina=='UTEQ'){
			$mail->isHTML(true); // Habilitar el formato HTML
			/*echo "estoy dentro de UTEQ: ".$tipoNomina."<br/>";
			echo $fechaPago."<br/>";
			echo $id_emp."<br/>";*/
			$mail->setFrom('percepcionesuteq@uteq.edu.mx', 'RECIBOS ELECTRONICOS UTEQ');
			$nombre=enviarMail($id_emp,"e.nombre",$fechaPago,$tipoNomina);
			$correo=enviarMail($id_emp,"e.correo",$fechaPago,$tipoNomina);
			//var_dump( $correo);
			$mail->addAddress($correo, $nombre);
			$mail->Subject = 'RECIBO NOMINA DE '.$fechaPago;
			$pathPDF=enviarMail($id_emp,"p.pathXML",$fechaPago,$tipoNomina);
			$pathXML=enviarMail($id_emp,"p.pathPDF",$fechaPago,$tipoNomina);
			$mail->Body    = '<br/>Estimado(a) '.$nombre."<br/><br/><br/>
						 Adjunto encontrarás tu recibo de nómina en formato PDF y XML de la fecha: ".$fechaPago.".<br/><br/>
						 Favor de no responder este correo debido a que es un envío  automatizado.<br/><br/>
						 Saludos.<br/><br/>";
			$productos = array($pathPDF,$pathXML);
			$j = 0;
			 
			foreach($productos as $clave=>$elemento)
			{
			   echo "Elemento $clave: $elemento <br>";
			   $mail->AddAttachment($elemento); 
			   ++$j;
			}
	}else if($tipoNomina=='JUBPENUTEQ'){
			$mail->isHTML(true); // Habilitar el formato HTML
			$mail->setFrom('percepcionesuteq@uteq.edu.mx', 'RECIBOS ELECTRONICOS UTEQ');
			$nombre=enviarMail($id_emp,"e.nombre",$fechaPago,$tipoNomina);
			$correo=enviarMail($id_emp,"e.correo",$fechaPago,$tipoNomina);
			$mail->addAddress($correo, $nombre);
			$mail->Subject = 'RECIBO JUBILACION-PENSION DE '.$fechaPago;
			$pathPDF=enviarMail($id_emp,"p.pathXML",$fechaPago,$tipoNomina);
			$pathXML=enviarMail($id_emp,"p.pathPDF",$fechaPago,$tipoNomina);
			$mail->Body    = '<br/>Estimado(a) '.$nombre."<br/><br/><br/>
						 Adjunto encontrarás tu recibo de nómina en formato PDF y XML de la fecha: ".$fechaPago.".<br/><br/>
						 Favor de responder el correo confirmando 'Ya lo recibí', la recepción de recibo de cada mes.<br/><br/>
						Por lo tanto si este no se llegase a responder tendrá que presentarse a firmar personalmente el mes en curso y ya no se enviaran por correo.<br/><br/>
						 En caso de si responder 'Ya lo recibí' , se presentará el primer día hábil de los meses de Enero y Julio de cada año, en Recursos Humanos para firmar los recibos que apliquen.<br/><br/>
						 Dudas favor de comunicarse en este mismo correo.<br/><br/>
						 Saludos.<br/><br/>";
			$productos = array($pathPDF,$pathXML);
			$j = 0;
			 
			foreach($productos as $clave=>$elemento)
			{
			   //echo "Elemento $clave: $elemento <br>";
			   $mail->AddAttachment($elemento); 
			   ++$j;
			}
		
	}
		// Enviar el correo electrónico
		$mail->send();
		//update a la tabla de path envio SI   ,$fechaPago,$id_emp
		updateEnvio($id_emp,$fechaPago);
		echo 'El correo electrónico ha sido enviado correctamente.';
	} catch (Exception $e) {
		echo "El correo electrónico no se pudo enviar. Error: {$mail->ErrorInfo}";
	}
}
//************************LEER ARCHIVOS PDF DECLARACION PATRIMONIAL
function insertDatosDP($pathPDF,$fechaPago,$tipoArchivo){
    //$thefolder = "/var/www/html/RHUTEQ/RECIBOS/DECPAT/2023/2022_PDF_DECPRUEBA2";
    $thefolder = $pathPDF; //int $i;
    if ($handler = opendir($thefolder)) {
        while (false !== ($file = readdir($handler))) {
               // $i++:
				echo $file."<br>";
			 if ($file != "." && $file != "..") {
                $arrayNombre=explode(".", $file); 
                $bdNumEmp=$arrayNombre[0]; //NUM EMLEADO
                //echo "emp:".$bdNumEmp."<br>";
                if($bdNumEmp<>0 OR($bdNumEmp <> NULL)){
                    insertPath($bdNumEmp,$pathPDF."/".$file,$fechaPago,$tipoArchivo);
                }
			}

        }
        closedir($handler);
    }
}
function enviarCorreoDP($anio,$id_emp){
		echo $anio."<br>";
	echo $id_emp;

}
// pie();
?>