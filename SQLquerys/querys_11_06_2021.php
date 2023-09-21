<?php session_start();
date_default_timezone_set('America/Mexico_City');

if(isset($_POST["accion"])) {
	
	switch ($_POST["accion"]) {
		case 'producto': { buscarProducto($_POST["codigo"]); break;}
		case 'InsertUpdate': { if(isset($_POST["id"])&& strlen($_POST["id"])==0) {  agregarProducto(); } else { actualizarProducto(); } break;}
		case 'InsertUpdateCategoria': { if(isset($_POST["idCate"])&& strlen($_POST["idCate"])>0) {  actualizarCategoria(); } else { agregarCategoria(); } break;}
		case 'guardaVenta': { guardaVenta(); }
		case 'guardarVentaProductos':{guardarVentaProductos();}
		case 'InsertInfoDr': { if(isset($_POST["id"])&& strlen($_POST["id"])>0) {  actualizarDr(); } else { agregarDr(); } break;}
		case 'recetas': { buscarTicket($_POST["ticket"]); break;}
		case 'buscaDR': { getInfo(); break;}

	}
}

function validarUsr($usuario,$password){ 
	$r=0;
	require("lib/conectar_php.php"); 
		if($result= mysqli_query($mysqli, "SELECT * FROM users WHERE email='".$usuario."' AND  password = '".md5($password)."'")){
			$r =mysqli_num_rows($result);
			$_SESSION['count'] = $r;
		}
	require("lib/cerrar_php.php"); 	
	return $r;
}

function validarSession() {
	return $_SESSION['count'];
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
function buscarProducto($i){
	require("lib/conectar_php.php"); //echo 'producto:'.$i;
	//if($result= mysqli_query($mysqli, "SELECT * FROM productos where codigo = '".$i."'")){
	$result= mysqli_query($mysqli, "select * from productos p join impuestos i on i.id_impuesto=p.id_impuesto where codigo = '".$i."'");
	$row_cnt = mysqli_num_rows($result);
	if($row_cnt>0){ 
		$r =mysqli_fetch_array($result);
		echo $r["id_productos"].",".$r["id_categoria"].",".$r["codigo"].",".$r["nombre"].",".$r["precioVenta"].",".$r["precioCompra"].",".$r["stockActual"].",".$r["stockMinimo"].",".$r["porcentaje"].",".$r["id_impuesto"];
	}else {
		//echo "No existe el producto";
		return 0;
	}
	require("lib/cerrar_php.php"); 	
}

function buscarIDventa($numTicket){ 
	$ret=0;
	require("lib/conectar_php.php"); 
	//if($result= mysqli_query($mysqli, "SELECT id_venta FROM gestionventas WHERE numTicket='".$numTicket."'")){
	if($result= mysqli_query($mysqli, "SELECT id_venta FROM gestionventas WHERE numTicket='".$numTicket."'")){	
		while ($r =mysqli_fetch_array($result)){
			$ret =$r["id_venta"];
		}
	}
	require("lib/cerrar_php.php"); 	
	return $ret;
}
function buscarCantidad($id_producto){ 
	$ret=0;
	require("lib/conectar_php.php"); 
	//if($result= mysqli_query($mysqli, "SELECT id_venta FROM gestionventas WHERE numTicket='".$numTicket."'")){
	if($result= mysqli_query($mysqli, "SELECT stockActual FROM productos WHERE id_productos='".$id_producto."'")){	
		while ($r =mysqli_fetch_array($result)){
			$ret =$r["stockActual"];
		}
	}
	require("lib/cerrar_php.php"); 	
	return $ret;
}
function catalogo() {
	$ret ="";
	require("lib/conectar_php.php"); 
	if($result= mysqli_query($mysqli, "SELECT * FROM categorias")){
		while ($r =mysqli_fetch_array($result)){
			$ret .= "<option value='".$r["id_categorias"]."'>".$r["nombre"]."</option>";
		}
	}
	require("lib/cerrar_php.php"); 	
	return $ret;
}
function Impuestos() {
	$ret ="";
	require("lib/conectar_php.php"); 
	if($result= mysqli_query($mysqli, "SELECT * FROM impuestos")){
		while ($r =mysqli_fetch_array($result)){
			$ret .= "<option value='".$r["id_impuesto"]."'>".$r["porcentaje"]."</option>";
		}
	}
	require("lib/cerrar_php.php"); 	
	return $ret;
}
function agregarProducto(){
	$r = "Problemas para agregar producto";
	$query = "INSERT INTO productos VALUES (NULL, '".$_POST["categoria"]."', '".$_POST["codigo"]."', '".$_POST["nombre"]."', ".$_POST["precio"].", ".$_POST["compra"].", ".$_POST["stock"].", '".$_POST["minimo"]."','".$_POST["impuestos"]."', NULL, NULL);";
	require("lib/conectar_php.php"); 
	//echo("agrega".$query);
	if($result= mysqli_query($mysqli, $query)){
		$r = "Producto Agregado";
	}
	require("lib/cerrar_php.php"); 	
	echo $r;
}

function actualizarProducto(){
	$r = "Problemas para actualizar producto";
	$query ="UPDATE productos SET nombre = '".$_POST["nombre"]."',  id_categoria = '".$_POST["categoria"]."', 
		precioVenta = ".$_POST["precio"].",  precioCompra = ".$_POST["compra"].",  stockActual = '".$_POST["stock"]."', 
		stockMinimo = '".$_POST["minimo"]."', id_impuesto='".$_POST["impuestos"]."' WHERE id_productos = ".$_POST["id"];
	require("lib/conectar_php.php");
		//echo "actualiza: ".$query;
	if(mysqli_query($mysqli, $query)){
		$r = "Producto Actualizado";
	}
	require("lib/cerrar_php.php"); 	
	echo $r;
}

function agregarCategoria(){
	$r = "Problemas para agregar categorías";
	$query = "INSERT INTO categorias VALUES (NULL, '".$_POST["categoria"]."',NULL,NULL,NULL);";
	require("lib/conectar_php.php"); 
	//echo $query;
	if($result= mysqli_query($mysqli, $query)){
		$r = "Categoría Agregada";
	}
	require("lib/cerrar_php.php"); 	
	echo $r;
}
function guardaVenta(){
	$ticket = $_POST["ticket"];
	$cliente = $_POST["cliente"];
	$total = $_POST["total"];
	$subtotal = $_POST["subtotal"];
	$IVA = $_POST["IVA"];
	$productos = $_POST["productos"];
	$created_at=date('Y-m-d'); 
	$FechaVenta=date('Y-m-d H:m:s'); 
	//echo $productos;
	//GUARDAMOS LA VENTA GLOBAL
	$r = "Problemas para agregar venta";
	$query = "INSERT INTO gestionventas(id_venta, NumVenta, cliente, FechaVenta, subtotal, ivaGlobal, total, numTicket, remember_token, created_at, updated_at) VALUES (NULL,NULL,NULL,'".$FechaVenta."','".$subtotal."','".$IVA."','".$total."','".$ticket."','1','".$created_at."',NULL);";
	require("lib/conectar_php.php"); 
	//echo $query;
	if($result= mysqli_query($mysqli, $query)){
		//GUARDAMOS TODOS LAS LINEAS DEL TICKET
		$handle=printer_open("POS58 (copy 3)");
		printer_start_doc($handle, "Tickets");
		printer_start_page($handle);
		printer_draw_text($handle,"Fecha: ".$FechaVenta,10, 50);
		printer_draw_text($handle,"FARMACIA SAN LUCAS",10, 100);
		$font = printer_create_font("Arial",12,12,12,false,false,false,0);
		printer_select_font($handle, $font);
		$var+=250;
		 foreach($productos as $valueP){  $id_venta=buscarIDventa($ticket);
	            foreach($valueP as $valueProductos=>$ProductosArray){
	               //echo $valueProductos."=>".$ProductosArray."<br/>";
	                if($valueProductos==0){$nombre=$ProductosArray;}
	                if($valueProductos==1){$cantidad=$ProductosArray;}
	                if($valueProductos==2){$descuento=$ProductosArray;}
	                if($valueProductos==3){$precio=$ProductosArray;}
	                if($valueProductos==4){$subtotalPro=$ProductosArray;}
	                if($valueProductos==5){$codigo=$ProductosArray;}
	                if($valueProductos==6){$id_producto=$ProductosArray;}
	                if($valueProductos==7){$impuesto=$ProductosArray;}
	                if($valueProductos==8){$totalPro=$ProductosArray;}
	            }

	            $query = "INSERT INTO ventaproducto(id_venta,id_producto, precioVenta, numTicket, cantidad, descuento, subtotal, total, remember_token, created_at, updated_at) VALUES ('".$id_venta."','".$id_producto."','".$precio."','".$ticket."','".$cantidad."','".$descuento."','".$subtotalPro."','".$totalPro."',NULL,NULL,NULL);";
				//mandar impresion de ticket
						//printer_draw_text($handle,$cantidad." ".$nombre." $".$total,20, 20+$var);
						echo '|'.$cantidad.'|.'.$nombre. '|'.$total ;
						$cantidad = str_replace( '',PHP_EOL,$cantidad);
						$nombre = str_replace( '',PHP_EOL,$nombre);
						$total = str_replace( '',PHP_EOL,$total);
						printer_draw_text($handle, $cantidad,10,20+$var);
						printer_draw_text($handle, $nombre,30,20+$var);
						printer_draw_text($handle, "$".$total,350,20+$var);
						echo "<br>"; $var=$var+20;
						
	            require("lib/conectar_php.php"); 
				//echo $query;
				if($result= mysqli_query($mysqli, $query)){
					
					//en cantidad restarle menos la cantidad y hacer update al id_producto 
					$stockActual=buscarCantidad($id_producto);
					$cantActual=$stockActual-$cantidad;
					//mysqli_query("UPDATE productos SET stockActual='".$cantActual."' WHERE id_productos='".$id_producto."';");
					mysqli_query($mysqli,"UPDATE productos SET stockActual='".$cantActual."' WHERE id_productos='".$id_producto."'");
					if($result= mysqli_query($mysqli, $query)){
						
				
					}
					$r = "ticket guardado"; 
				}
				//echo $r;
	     }				
		/*IMPRESION*/
		printer_delete_font($font);
		$font = printer_create_font("Times New Roman",20,20,20,false,false,false,0);
		printer_select_font($handle, $font);
		printer_draw_text($handle, "Subtotal: $".$subtotal,100,$var+200 );
		if(($iva=='null')||($iva=="")){
			printer_draw_text($handle, "IVA: $0",100,$var+230 );	
		}else{
			printer_draw_text($handle, "IVA: $".$iva,100,$var+230 );
		}
		printer_draw_text($handle, "Total: $".$total,100,$var+260 );
		printer_delete_font($font);
		$font = printer_create_font("Times New Roman",18,18,18,false,false,false,0);
		printer_select_font($handle, $font);
		printer_draw_text($handle, "Gracias por su Visita!",10,$var+550);
		printer_end_page($handle);
		printer_end_doc($handle);
		printer_close($handle);
	}
	require("lib/cerrar_php.php"); 	
	echo $r;
	
}
function guardarVentaProductos(){
	$ticket = $_POST["ticket"];
	$cliente = $_POST["cliente"];
	$total = $_POST["total"];
	$productos = $_POST["productos"];
	//echo $productos;
	$r = "Problemas para agregar venta";
	$query = "INSERT INTO ventaproducto(id_venta, id_producto, precioVenta, numTicket, cantidad, descuento, subtotal, total, remember_token, created_at, updated_at) VALUES (NULL, 1,'10.00','1265433','1','0', '"-$total."','".$total."', NULL,NULL,NULL);";
	require("lib/conectar_php.php"); 
	echo $query;
	if($result= mysqli_query($mysqli, $query)){
		$r = "venta guardada";
	}
	require("lib/cerrar_php.php"); 	
	echo $r;
}
function generaTicket(){
	$ret ="";
	require("lib/conectar_php.php"); 
	if($result= mysqli_query($mysqli, "SELECT MAX(id_venta) AS id FROM gestionventas WHERE created_at = curdate()")){
		$r =mysqli_fetch_array($result);
		$ret= ($r[0]) +1;
	}
	require("lib/cerrar_php.php"); 	
	$ret = (date("Ymd")). $ret;
	return $ret;
}
function getInfo(){
	$id_user=selectDR($_SESSION['usuario']);
	$r="";
	require("lib/conectar_php.php"); 
	if($result= mysqli_query($mysqli, "SELECT * FROM infodoctor WHERE id_user = '".$id_user."'")){
		$r =mysqli_fetch_array($result);
		echo $r["id_dr"].",".$r["id_user"].",".$r["nombre"].",".$r["apellidos"].",".$r["especialidad"].",".$r["universidad"].",".$r["cedula"].",".$r["telefono"].",".$r["celular"].",".$r["email"];
	}
	require("lib/cerrar_php.php"); 	
	return $r;
}
function agregarDr(){
	$id_user=selectDR($_SESSION['usuario']);
	//$id_user=$_SESSION['usuario'];
	$r = "Problemas para agregar información de Dr";
	$query = "INSERT INTO infoDoctor VALUES (NULL, '".$id_user."', '".$_POST["nombre"]."', '".$_POST["apellidos"]."', '".$_POST["espe"]."', '".$_POST["uni"]."', '".$_POST["cedula"]."', '".$_POST["tel"]."', '".$_POST["cel"]."','".$_POST["mail"]."');";
	require("lib/conectar_php.php"); 
	//echo($query);
	if($result= mysqli_query($mysqli, $query)){
		$r = "Información Agregada";
	}
	require("lib/cerrar_php.php"); 	
	echo $r;
}

function actualizarDr(){

	$r = "Problemas para actualizar Información de Dr";
	$query ="UPDATE infoDoctor SET nombre = '".$_POST["nombre"]."',  apellidos = '".$_POST["apellidos"]."', 
		especialidad = ".$_POST["espe"].",  universidad = ".$_POST["uni"].",  cedula = '".$_POST["cedula"]."', 
		telefono = '".$_POST["tel"]."', celular='".$_POST["cel"]."', email='".$_POST["email"]."' WHERE id_dr = ".$_POST["id"];
	require("lib/conectar_php.php"); 
	if(mysqli_query($mysqli, $query)){
		$r = "Información Actualizada";
	}
	require("lib/cerrar_php.php"); 	
	echo $r;
}
function buscarDr($i){
	require("lib/conectar_php.php"); 
	//if($result= mysqli_query($mysqli, "SELECT * FROM productos where codigo = '".$i."'")){
	if($result= mysqli_query($mysqli, "select * from infoDoctor p where p.nombre = '".$nombre."'")){ 
		$r =mysqli_fetch_array($result);
		echo $r["id_productos"].",".$r["id_categoria"].",".$r["codigo"].",".$r["nombre"].",".$r["precioVenta"].",".$r["precioCompra"].",".$r["stockActual"].",".$r["stockMinimo"].",".$r["porcentaje"].",".$r["id_impuesto"];
	}
	require("lib/cerrar_php.php"); 	
}
/*FUNCION PARA BUSCAR TICKET EN RECETAS*/
function buscarTicket($numTicket){
	require("lib/conectar_php.php"); 
	//if($result= mysqli_query($mysqli, "SELECT * FROM productos where codigo = '".$i."'")){
	if($result= mysqli_query($mysqli, "select * from productos p join ventaproducto pro on pro.id_producto=p.id_productos join impuestos i on i.id_impuesto=p.id_impuesto join gestionventas gv on gv.id_venta=pro.id_venta
where gv.numTicket = '".$numTicket."' group by pro.numTicket")){ 
		$r =mysqli_fetch_array($result);
		echo $r["codigo"].",".$r["nombre"].",".$r["stockActual"].",".$r["ivaGlobal"].",".$r["total"].",".$r["cantidad"];
	}
	require("lib/cerrar_php.php"); 	
}
/*FUNCION PARA MANDAR IMPRESION DE TICKET*/
function imprimirTicket(){
	$html = "Test de Impresión de Tickets";
	$html .= "Aquí todo el contenido del Ticket";
	$printer="POS-58 (copy 3)";	
	$enlace=printer_open($printer);
	printer_write($enlace, $html);
	printer_close($enlace);
}
?>