<?php
//require_once 'funciones.php';
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
$path=$_SERVER["DOCUMENT_ROOT"];
require_once "../../vendor/PHPExcel/PHPExcel/IOFactory.php";



$anio = date("Y");
    $mes = date("m");
    echo $anio;
/*include ("../master.php");

cabeza();
    $anio = date("Y");
    $mes = date("m");
 
 pie();*/
?>