<?php session_start();
function usuariosVal(){
	if(!$_SESSION['usr']){
		header("location:login.php");
	}else{
	
	validar_pagina();
	}
}
function validar_pagina(){
	$ban=false;
	require("conectar_php.php");
	$url=explode("/",$_SERVER['REQUEST_URI']);
	$url1=explode("?",$url[count($url)-1]);
	$sql=mysql_query("SELECT `url` FROM `pslp_tab_modulos` , `pslp_tab_permisos` WHERE pslp_tab_permisos.id_usr = '".$_SESSION['usr']."' AND pslp_tab_permisos.id_modulo =pslp_tab_modulos.id_modulo");
		while ($variables=mysql_fetch_array($sql)){
			if($url1[0]==$variables['url']&&$ban!=true){
					$ban=true;break;}
			else{			
				$ban=false;}
		}	
	require("cerrar_php.php");
	if($ban==false)header("location:index.php?error=5");
}
?>