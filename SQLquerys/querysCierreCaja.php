<?php session_start();
date_default_timezone_set('America/Mexico_City');
setlocale(LC_MONETARY, 'es_MX');
require __DIR__ . '/autoload.php'; //Nota: si renombraste la carpeta a algo diferente de "ticket" cambia el nombre en esta línea
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

if(isset($_POST["accion"])) {
	
	switch ($_POST["accion"]) {
		case 'totalesDiario': { buscarTotales($_POST["fechaInv"]); break;}
		case 'hacerCierre': { /*if(isset( $_POST["id"])&& strlen($_POST["id"])==0) { */hacerCierre($_POST["fechaInv"]);/*} else { actualizarProducto(); }*/ break;}
		/*case 'InsertUpdate': { if(isset($_POST["id"])&& strlen($_POST["id"])==0) {  agregarProducto(); } else { actualizarProducto(); } break;}
		case 'InsertUpdateCategoria': { if(isset($_POST["idCate"])&& strlen($_POST["idCate"])>0) {  actualizarCategoria(); } else { agregarCategoria(); } break;}
		case 'guardaVenta': { guardaVenta(); }
		//case 'guardarVentaProductos':{guardarVentaProductos();}
		//case 'InsertInfoDr': { if(isset($_POST["id"])&& strlen($_POST["id"])>0) {  actualizarDr(); } else { agregarDr(); } break;}
		case 'recetas': { buscarTicket($_POST["ticket"]); break;}*/
		case 'mostrarTablaCierre': { dibujarTablaCierre($_POST["fechaInv"]); break;}

	}
}

function buscarTotales($fecha){
	require("lib/conectar_php.php"); //echo 'producto:'.$i;
	//$result= mysqli_query($mysqli, "select count(*) numero from gestionventas where CAST(FechaVenta AS DATE) = CURDATE()");
	$result= mysqli_query($mysqli, "select count(*) numero , sum(total) sumaTotal, sum(subtotal) sumaSubTotal, sum(ivaGlobal) IVA from gestionventas where CAST(FechaVenta AS DATE) = '".$fecha."'");
	$row_cnt = mysqli_num_rows($result);
	if($row_cnt>0){ 
		$r =mysqli_fetch_array($result);
		
		echo $r["numero"].",".$r["sumaTotal"].",".$r["sumaSubTotal"].",".$r["IVA"].",".$r["IVA"];
	}else {
		//echo "No existe el producto";
		return null;
	}
	require("lib/cerrar_php.php"); 	
}
function selectDR($usuario) {
	$ret=0; $usuario=$_SESSION['usuario'];
	require("lib/conectar_php.php"); 
	if($result= mysqli_query($mysqli, "SELECT * FROM users WHERE email='".$usuario."'")){
		while ($r =mysqli_fetch_array($result)){
			$ret =$r["id"];
		}
	}
	require("lib/cerrar_php.php"); 	
	return $ret;
}
function hacerCierre($fecha){
	$id_user=selectDR($_SESSION['usuario']);
	$r = "Problemas para agregar información de usuario";
	// validamos si ya existen cierres de ese tipo y de ese día
	$querydr = "INSERT INTO cierrecaja VALUES (NULL, '".$id_user."', 'diario', '".$fecha."', '".$_POST["fechaInv"]."', '".$_POST["numTickets"]."', '".$_POST["subtotal"]."', '".$_POST["descuento"]."', '".$_POST["iva"]."','".$_POST["total"]."');";
	require("lib/conectar_php.php"); 
	//echo($query);
	if($result= mysqli_query($mysqli, $querydr)){
		$r = "Información Agregada";
	}
	require("lib/cerrar_php.php"); 	
	echo $r;
}

function dibujarTablaCierre($fechaInv){
	$return_arr = array();
	require("lib/conectar_php.php"); // cambiar la fecha por la que introduzca el usuario
	$result= mysqli_query($mysqli, 'select p.id_productos, p.codigo, p.nombre, pro.cantidad,gv.numTicket, pro.descuento,pro.subtotal,pro.total,pro.precioVenta,gv.ivaGlobal from productos p join ventaproducto pro on pro.id_producto=p.id_productos join impuestos i on i.id_impuesto=p.id_impuesto join gestionventas gv on gv.id_venta=pro.id_venta where CAST(gv.FechaVenta AS DATE)="2022-12-04"');//"'.$fechaInv.'"'); 
	
	
	while($r = mysqli_fetch_array($result)){
		$id_productos=$r["id_productos"];
		$codigo=$r["codigo"];
		$nombre=$r["nombre"];
		$cantidad=$r["cantidad"];
		$descuento=$r["descuento"];
		$subtotal=$r["subtotal"];
		$ivaGlobal=$r["ivaGlobal"];
		$total=$r["total"];
		$precioVenta=$r["precioVenta"];
		$numTicket=$r["numTicket"];
		$return_arr[] = array("id_productos" => $id_productos,
                    "codigo" => $codigo,
					"numTicket" => $numTicket,
                    "nombre" => $nombre,
					"cantidad" => $cantidad,
					"precioVenta" => $precioVenta,
					"descuento" => $descuento,
					"subtotal" => $subtotal,
					"ivaGlobal" => $ivaGlobal,
					"total" => $total);
	}
		
	 echo json_encode($return_arr);
	require("lib/cerrar_php.php"); 	
}

?>