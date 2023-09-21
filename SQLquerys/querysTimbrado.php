<?php 
//session_start();
date_default_timezone_set('America/Mexico_City');
setlocale(LC_MONETARY, 'es_MX');

function returncampo($campo,$tabla,$where,$eRFC){ 
	$ret=0;
	require("lib/conectar_php.php"); 
	if($result= mysqli_query($mysqli, "SELECT num_emp FROM emp_uteq WHERE rfc_emp='".$eRFC."' and status='A'")){
	//if($result= mysqli_query($mysqli, "SELECT * FROM $tabla WHERE $where='".$eRFC."' and status='A'")){	
		while ($r =mysqli_fetch_array($result)){
			$ret =$r["num_emp"];//$ret =$r["$campo"];
		}
	}
	require("lib/cerrar_php.php"); 	
	return $ret;
}
function insertPath($id_emp,?string $pathPDF,$fechaPago,$tipoArchivo){
	$r = "Problemas para guardar ruta";
	$pathXML=null;
	$query = "INSERT INTO path(id_path,id_emp,pathPDF,pathXML,fechaPago,tipoArchivo, envio) VALUES (NULL, '".$id_emp."', '".$pathPDF."', '".$pathXML."', '".$fechaPago." ','".$tipoArchivo."' , 'NO');";
	require("lib/conectar_php.php"); 
	//echo("agrega".$query."<BR/>");
	if($result= mysqli_query($mysqli, $query)){
		 $r = "se insertaron datos";
	}else{
		echo $r;
	}
	require("lib/cerrar_php.php"); 	
}
function updatePathXML($id_emp,?string $pathXML){
	$r = "Problemas para guardar ruta";
	$query = "UPDATE path SET pathXML='".$pathXML."' WHERE id_emp='".$id_emp."' and tipoArchivo='NOMINA';";
	require("lib/conectar_php.php"); 
	//echo("agrega".$query);
	if($result= mysqli_query($mysqli, $query)){
		$r = "ruta agregada";
	}else{
		echo $r;
	}
	require("lib/cerrar_php.php"); 	
}
function updateEnvio($id_emp,$fechaPago){
	$r = "Problemas para guardar ruta";
	$query = "UPDATE path SET envio='SI' WHERE id_emp='".$id_emp."' and fechaPago='".$fechaPago."';";
	require("lib/conectar_php.php"); 
	//echo("agrega".$query);
	if($result= mysqli_query($mysqli, $query)){
		$r = "enviado";
	}else{
		echo $r;
	}
	require("lib/cerrar_php.php"); 	
}
/*NO EN PRODUCCION AUN FALTA HACER LA VALIDACION PARA IMPLEMENTARLA*/
//function existePath($id_emp,$pathPDF=null,$fechaPago){
function existePath($id_emp,?string $pathPDF,$fechaPago){
	$ret=0;
	require("lib/conectar_php.php"); 
	if($result= mysqli_query($mysqli, "SELECT fechaPago FROM emp_uteq WHERE rfc_emp='".$eRFC."' and status='A'")){
	//if($result= mysqli_query($mysqli, "SELECT * FROM $tabla WHERE $where='".$eRFC."' and status='A'")){	
		while ($r =mysqli_fetch_array($result)){
			$ret =$r["num_emp"];//$ret =$r["$campo"];
		}
	}
	require("lib/cerrar_php.php"); 	
	return $ret;	
}
function enviarMail($id_emp,$campo,$fechaPago,$tipoNomina){
	$ret=0;
	//$id_emp='125377';
	//echo "soy tipo de nomina:".$tipoNomina."<br/>";
	require("lib/conectar_php.php"); //e.num_emp numEmp,e.nombre empleado,p.pathXML pathXML,p.pathPDF
	
	if($tipoNomina=="DP"){ //echo "ESTOY DENTOR DE DEC PATR";
		if($result= mysqli_query($mysqli, "select $campo campo from path p join emp_uteq e on p.id_emp=e.num_emp where p.id_emp='".$id_emp."' and p.fechaPago='".$fechaPago."' and e.status='A' AND p.tipoArchivo='DECPAT' AND p.envio='NO' ")){	
			$ret=array();
			while ($r =mysqli_fetch_array($result)){
				$ret= $r["campo"];
			}
		}
		require("lib/cerrar_php.php"); 	
		return $ret;	
	}elseif($tipoNomina=="UTEQ"){
		//echo "ESTOY DENTOR DE UTEQ";
		/*if($result= mysqli_query($mysqli, "select $campo campo from path p join emp_uteq e on p.id_emp=e.num_emp where p.id_emp='125377' and p.fechaPago='2023-04-15' and e.status='A' AND p.tipoArchivo='NOMINA'")){*/
		if($result= mysqli_query($mysqli, "select $campo campo from path p join emp_uteq e on p.id_emp=e.num_emp where p.id_emp='".$id_emp."' and p.fechaPago='".$fechaPago."' and e.status='A' AND p.tipoArchivo='NOMINA' AND p.envio='NO'")){
			$ret=array();
			while ($r =mysqli_fetch_array($result)){
				$ret =$r["campo"];
			}
		}
		require("lib/cerrar_php.php"); 	
		return $ret;
	}elseif($tipoNomina=="JUBPENUTEQ"){
		//echo "ESTOY DENTOR DE UTEQ";
		/*if($result= mysqli_query($mysqli, "select $campo campo from path p join emp_uteq e on p.id_emp=e.num_emp where p.id_emp='125377' and p.fechaPago='2023-04-15' and e.status='A' AND p.tipoArchivo='NOMINA'")){*/
		if($result= mysqli_query($mysqli, "select $campo campo from path p join emp_uteq e on p.id_emp=e.num_emp where p.id_emp='".$id_emp."' and e.tipo_nomina IN ('JUBPENUTEQ') AND e.num_emp in(
			'7',
			'19',
			'23',
			'26',
			'28',
			'37',
			'44',
			'46',
			'48',
			'49',
			'50',
			'51',
			'53',
			'54',
			'60',
			'66',
			'67',
			'69',
			'72',
			'75',
			'14',
			'81',
			'101',
			'43',
			'103') and p.fechaPago='".$fechaPago."' and e.status='A' AND p.tipoArchivo='NOMINA' AND p.envio='NO' ")){
			$ret=array();
			while ($r =mysqli_fetch_array($result)){
				$ret =$r["campo"];
			}
		}
		require("lib/cerrar_php.php"); 	
		return $ret;
	}
}

function enviarMasivos($tipoNomina,$fechaPago){
	$ret=0;
	//$id_emp=zendy: '125377', olga: 61377, naye:107033 , ara:125258 , gaby:124919 125334, lic:125238, fer:125586
	//,'125586',61377,107033,125258,124919,125238
	//and e.num_emp in('125377','125586')
	require("lib/conectar_php.php"); //e.num_emp numEmp,e.nombre empleado,p.pathXML pathXML,p.pathPDF
	if($tipoNomina=='UTEQ'){
		if($result= mysqli_query($mysqli, "select e.num_emp numEmp from emp_uteq e join path p on e.num_emp=p.id_emp where p.fechaPago='".$fechaPago."' and e.tipo_nomina IN ('".$tipoNomina."','UTEQ_EVDOC') and e.status='A' AND p.tipoArchivo='NOMINA' AND p.envio='NO'")){	
			$ret=array();
			while ($r =mysqli_fetch_array($result)){
				 $ret[] =$r["numEmp"];
			}
		}
	}else if($tipoNomina=='JUBPENUTEQ'){
		if($result= mysqli_query($mysqli, "select e.num_emp numEmp from emp_uteq e join path p on e.num_emp=p.id_emp where p.fechaPago='".$fechaPago."'and e.num_emp in(
		'7',
		'19',
		'23',
		'26',
		'28',
		'37',
		'44',
		'46',
		'48',
		'49',
		'50',
		'51',
		'53',
		'54',
		'60',
		'66',
		'67',
		'69',
		'72',
		'75',
		'14',
		'81',
		'101',
		'43',
		'103') and e.tipo_nomina IN ('JUBPENUTEQ') and e.status='A' AND p.tipoArchivo='NOMINA' ")){	
			$ret=array();
			while ($r =mysqli_fetch_array($result)){
				$ret []=$r["numEmp"];
			}
		}
	}else if($tipoNomina=='DP'){
		/*if($result= mysqli_query($mysqli, "select e.num_emp numEmp from emp_uteq e join path p on e.num_emp=p.id_emp where p.fechaPago='".$fechaPago."' and e.status='A' AND p.tipoArchivo='DECPAT'")){*/	
		if($result= mysqli_query($mysqli, "select e.num_emp numEmp from emp_uteq e join path p on e.num_emp=p.id_emp where p.fechaPago='".$fechaPago."' and e.num_emp in('125377','125586') and e.status='A' AND p.tipoArchivo='DECPAT' and p.envio='NO'")){
			$ret=array();
			while ($r =mysqli_fetch_array($result)){
				 $ret[] =$r["numEmp"];
			}
		}
	}
	
	require("lib/cerrar_php.php"); 	
	return $ret;	
}
?>