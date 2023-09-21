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
function insertEstructura($DIRE,$DEPT,$ORGANIZACION,$POS_NAME,$POS_STATUS,$JOB_NAME, $POS_TIPO_DESC,
$POS_REF,$CATE_FED_ORIGINAL,$CAT_FED,$SDO_FED,$GPO_FED,$HRS_FED,$EMP_NUM,$EMP_NAME,$EMP_CURP,$EMP_RFC,$EMP_IMSS,$EMP_SEX,
$EMP_AGE,$EMP_PRIN_CON,$ASG_INI, $ASG_FIN,$ASG_NUM,$ASG_SIN, $SINDICALIZADO_N_S, $TIPO_CONTRATO, $ASG_SDO, $ASG_SDO_FEC,
$ASG_HOR, $NOM_NAME_1, $BASE_NAME_1,$EMAIL,$QUINQUENIO,$EMP_ACT_CON, $EMP_BIRTHDATE){
	$r = "Problemas para guardar estructura";
	
	$query = "INSERT INTO xxhr_estructura_uteq(DIRE,DEPT,ORGANIZACION,POS_NAME,POS_STATUS,JOB_NAME, POS_TIPO_DESC,
	POS_REF,CATE_FED_ORIGINAL,CAT_FED,SDO_FED,GPO_FED,HRS_FED,EMP_NUM,EMP_NAME,EMP_CURP,EMP_RFC,EMP_IMSS,EMP_SEX,
	EMP_AGE,EMP_PRIN_CON,ASG_INI, ASG_FIN,ASG_NUM,ASG_SIN, SINDICALIZADO_N_S, TIPO_CONTRATO, ASG_SDO, ASG_SDO_FEC,
	ASG_HOR, NOM_NAME_1,BASE_NAME_1, EMAIL,QUINQUENIO,EMP_ACT_CON, EMP_BIRTHDATE
	
	) VALUES ('".$DIRE."', '".$DEPT."', '".$ORGANIZACION."', '".$POS_NAME." ','".$POS_STATUS."' , 
	'".$JOB_NAME."', '".$POS_TIPO_DESC."', '".$POS_REF." ','".$CATE_FED_ORIGINAL."' , 
	'".$CAT_FED."', '".$SDO_FED."', '".$GPO_FED."', '".$HRS_FED." ','".$EMP_NUM."' , 
	'".$EMP_NAME."', '".$EMP_CURP."', '".$EMP_RFC."', '".$EMP_IMSS." ','".$EMP_SEX."' , 
	'".$EMP_AGE."', '".$EMP_PRIN_CON."', '".$ASG_INI."', '".$ASG_FIN." ','".$ASG_NUM." ','".$ASG_SIN."' , 
	'".$SINDICALIZADO_N_S."', '".$TIPO_CONTRATO."', '".$ASG_SDO."', '".$ASG_SDO_FEC." ','".$ASG_HOR."' , 
	'".$NOM_NAME_1."', '".$BASE_NAME_1."', '".$EMAIL." ','".$QUINQUENIO."' , 
	'".$EMP_ACT_CON."' , 
	'".$EMP_BIRTHDATE."');";
	require("lib/conectar_php.php"); 
	echo($query."<BR/>");
	if($result= mysqli_query($mysqli, $query)){
		 $r = "se insertaron datos";
	}else{
		echo $r;
	}
	require("lib/cerrar_php.php"); 	
}
function borrarInfoEstru(){
	$r = "Problemas eliminar";
	$query = "DELETE FROM xxhr_estructura_uteq;";
	require("lib/conectar_php.php"); 
	//echo("agrega".$query);
	if($result= mysqli_query($mysqli, $query)){
		$r = 0;//"ELIMINADO";
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


?>