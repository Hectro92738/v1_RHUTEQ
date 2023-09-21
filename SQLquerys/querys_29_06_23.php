<?php session_start();
date_default_timezone_set('America/Mexico_City');
setlocale(LC_MONETARY, 'es_MX');

function insertEstructura($dire,$dept,$organizacion,$pos_name,$pos_status,$job_name){
	$r = "Problemas para guardar ruta";
	$pathXML=null;
	$query = "INSERT INTO xxhr_estructura_uteq(DIRE,DEPT,ORGANIZACION,POS_NAME,POS_STATUS,JOB_NAME) 
	VALUES (NULL, '".$dire."', '".$dept."', '".$organizacion."', '".$pos_name." ','".$pos_status."' , '".$job_name."');";
	require("lib/conectar_php.php"); 
	//echo("agrega".$query."<BR/>");
	if($result= mysqli_query($mysqli, $query)){
		 $r = "se insertaron datos";
	}else{
		echo $r;
	}
	require("lib/cerrar_php.php"); 	
}
?>