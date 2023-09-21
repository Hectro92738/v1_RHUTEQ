<?php
//session_start();
include ("master.php");
include ("leerCarpeta.php");
//include("SQLquerys/querysTimbrado.php");

cabeza();
?>
<div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Archivos NOMINA</h1>
                </div>
            </div>
			<div class="col-lg-12">
			</div>
			<?php
			foreach($_FILES["miarchivo"]['tmp_name'] as $key => $tmp_name)
			{
				//condicional si el fuchero existe
				//echo $_FILES["miarchivo"]['tmp_name'];
				if($_FILES["miarchivo"]["name"][$key]) {
					// Nombres de archivos de temporales
					$archivonombre = $_FILES["miarchivo"]["name"][$key]; 
					$fuente = $_FILES["miarchivo"]["tmp_name"][$key]; 
					
					$carpeta = 'TEMP/'; //Declaramos el nombre de la carpeta que guardara los archivos
					
					if(!file_exists($carpeta)){
						mkdir($carpeta, 0777) or die("Hubo un error al crear el directorio de almacenamiento");	
					}

					
					$dir=opendir($carpeta);
					$target_path = $carpeta.'/'.$archivonombre; //indicamos la ruta de destino de los archivos
					
					if(move_uploaded_file($fuente, $target_path)) {	
						echo "Los archivos $archivonombre se han cargado de forma correcta.<br>";
						
						//empezamos a descomprimir los archivos
						$zip = new ZipArchive;
						// Declaramos el fichero a descomprimir, puede ser enviada desde un formulario
						$comprimido= $zip->open("TEMP/".$archivonombre);
						if ($comprimido=== TRUE) {
						// Declaramos la carpeta que almacenara ficheros descomprimidos
							$anio = date("Y");
							$arrayNombre=explode("-", $archivonombre); 
							$tipoNomina=$arrayNombre[0];
							$mes=$arrayNombre[1]; 
							$fechaPago=$arrayNombre[2]; //echo $fechaPago
							$dia=substr($fechaPago,0,2); //echo "ESTEE S EL DIA: ".$dia;
							$tipo=substr($fechaPago,3,3); //echo "ESTEE S EL tipo: ".$tipo;
							$fechaPago=$anio."-".$mes."-".$dia;
							$zip->extractTo("RECIBOS/".$anio."/".$mes."/".$dia."/".$tipoNomina."/".$tipo);
							
							$zip->close();
						// Imprimimos si todo salio bien
							//echo "El fichero se descomprimio correctamente!";
						} else {
						// Si algo salio mal, se imprime esta seccion
							echo "Error descomprimiendo el archivo zip";
						}
						
						} else {	
						echo "Se ha producido un error, por favor revise los archivos e intentelo de nuevo.<br>";
					}
					closedir($dir); //Cerramos la conexion con la carpeta destino
				}
			}
			$path="RECIBOS/".$anio."/".$mes."/".$dia."/".$tipoNomina."/";
			$insertPathPDF=insertDatos($path."pdf",$fechaPago);
			$insertPathXML=updateXML($path."xml",$fechaPago);

		?>
				</div>
			</div>
            <div class="clear clean"></div>
			
			
<script type="text/javascript"> 
var tablaProductos = []; 
$(function() {
    $('#row_dim').hide(); 
    $('#type').change(function(){
        if($('#type').val() == 'diario') {
            $('#row_dim').show(); 
			buscaCierreDiario()
        } else {
            $('#row_dim').hide(); 
        } 
    });
});
function guardarVentaTotal(){
	if($('input[name=total]').val().length > 0) {
		$.ajax({
		  method: "POST",
		  url: "SQLquerys/querys.php",
		  data: { accion: "guardaVenta", 
			productos :tablaProductos,
			ticket : $("input[name=detalle_ticket]").val(),
			cliente : $("input[name=cliente]").val(),
			total : $("input[name=total]").val(),
			subtotal : $("input[name=subtotal]").val(),
			IVA : $("input[name=IVA]").val(),

		  }
		}).done(function( msg ) {
			datos = msg.split(",");
			alert("Imprimiendo....");
			location.reload();
		  });
	}else{
		alert("debes tener mínimo un producto seleccionado");
	}
}
function buscaCierreDiario(){
	alert("estoy en cierre");
	/*if($('#codigo').val().length > 0) { 
		$.ajax({
		  method: "POST",
		  url: "SQLquerys/querys.php",
		  data: { accion: "producto", codigo:$('#codigo').val()}
		}).done(function( msg ) { 
			datos = msg.split(",");
			$("input[name=detalle_nombre]").val(datos[3]);
			$("input[name=detalle_precio]").val(datos[4]);
			$("input[name=detalle_stock]").val(datos[6]);
			$("input[name=id_producto]").val(datos[0]);
			$("input[name=detalle_IVA]").val(datos[8]);
			$("input[name=detalle_descuento]").val(0.00);
			$("input[name=detalle_cantidad]").val(1);
			$("input[name=detalle_cantidad]").focus();
		  })
	}*/
}
function buscaIDventa(){
	//if($('#codigo').val().length > 0) { 
		$.ajax({
		  method: "POST",
		  url: "SQLquerys/querys.php",
		  data: { accion: "idventa", codigo:$('#codigo').val()}
		}).done(function( msg ) { 
			datos = msg.split(",");
			$("input[name=detalle_nombre]").val(datos[3]);
			$("input[name=detalle_precio]").val(datos[4]);
			$("input[name=detalle_stock]").val(datos[6]);
			$("input[name=id_producto]").val(datos[0]);
			$("input[name=detalle_IVA]").val(datos[8]);
			$("input[name=detalle_descuento]").val(0.00);
			$("input[name=detalle_cantidad]").val(1);
			$("input[name=detalle_cantidad]").focus();
		  })
	//}
}
function agregarProductos(){ 
	if($('#codigo').val().length > 0 && $("input[name=detalle_nombre]").val().length > 0 && $("input[name=detalle_cantidad]").val().length > 0 && $("input[name=detalle_precio]").val().length > 0) {
		n=$("input[name=detalle_nombre]").val();
		c=$("input[name=detalle_cantidad]").val();
		d=$("input[name=detalle_descuento]").val();
		p=$("input[name=detalle_precio]").val();
		cd=$("input[name=detalle_codigo]").val();
		id=$("input[name=id_producto]").val();
		st=parseFloat(c)*(parseFloat(p));
		imp=$("input[name=detalle_IVA]").val();
		t=st+(st*(parseFloat(imp)/100));
		if(parseInt(d)>0) t = ((parseFloat(d) *.01) * parseFloat(p)) * parseFloat(c)
		
		bandera = 0;
		$.each(tablaProductos,function(indice,valor){
			if(valor[6]===id){
				bandera = 1;
				//tablaProductos[indice] = [valor[0],(parseInt(valor[1])+parseInt(c)),valor[2],valor[3],(valor[4]+t),valor[5],valor[6],valor[7]];
				tablaProductos[indice] = [valor[0],(parseInt(valor[1])+parseInt(c)),valor[2],valor[3],(valor[4]+st),valor[5],valor[6],valor[7],(valor[8]+t)];
			}
		})
		setTimeout(function(){ 
			if (bandera == 0)			
				tablaProductos.push([n,c,d,p,st,cd,id,imp,t]);				
			$("#productos tbody").html("");
			dibujarTabla();
		}, 100);
	}else {
		alert("falta algun campo");
	}
}
function quitarProductos(){
	tabTemp =[];
	id=$("input[name=id]").val();
	c=$("input[name=detalle_cantidad]").val();
	$.each(tablaProductos,function(indice,valor){
		if(valor[6]===id){
			if((valor[1]-c)>0)
				tabTemp.push([valor[0],(valor[1]-c),valor[2],valor[3],valor[4],valor[5],valor[6],valor[7]]);
		}else
			tabTemp.push([valor[0],valor[1],valor[2],valor[3],valor[4],valor[5],valor[6],valor[7]]);
	});
	$("#productos tbody").html("");
	tablaProductos = tabTemp;
	dibujarTabla();
}
function dibujarTabla() {
	subTotal = 0;
	iva = 0;
	total = 0;
	temp=0;
	ivaT=0;
	cantidad=0;
	fecha = moment().format('LL');
	//console.log(tablaProductos)
	$.each(tablaProductos,function(indice,valor){
		$("#productos tbody").append("<tr><td>"+(indice+1)+"</td><td>"+valor[0]+"</td><td>"+valor[1]+"</td><td>"+valor[2]+"</td><td>"+valor[3]+"</td><td>"+valor[7]+"</td><td>"+valor[4]+"</td><td>"+valor[8]+"</td></tr>");
		iva=((parseFloat(valor[7])/100)*(parseFloat(valor[4])))+iva;
		iva=Math.round(iva * 100) / 100;
		subTotal=parseFloat(valor[4])+parseFloat(subTotal);
		subTotal=Math.round(subTotal * 100) / 100;
		total=parseFloat(valor[8])+total;
		total=Math.round(total * 100) / 100;
		cantidad=(parseFloat(valor[1]))+cantidad;
		//alert (cantidad);
		//console.log(cantidad);
	});
	$("input[name=subtotal]").val(subTotal);
	$("input[name=IVA]").val(iva);
	$("input[name=total]").val(total);
	$("input[name=fecha]").val(fecha);
	
	$("input[name=id_producto],input[name=detalle_codigo],input[name=detalle_nombre], input[name=detalle_precio],input[name=detalle_stock],input[name=id_producto],input[name=detalle_descuento],input[name=detalle_cantidad]").val("");
	$("input[name=detalle_codigo]").focus();
}
function pagar(){
	guardarVentaTotal();	
	//guardarVentaProductos();
	id=$("input[name=id_producto]").val();
	//eliminar cantidad en stock


	//numTicket=$("input[name=detalle_ticket]").val();
		/*$.ajax({
		  method: "POST",
		  url: "SQLquerys/querys.php",
		  data: { accion: "idventa", numTicket:$("input[name=detalle_ticket]").val()}
		}).done(function( msg ) { 
			ventas = msg.split(",");
			alert(ventas[0]);
		  })*/
	//sacar el id_venta 
	
	//guardar cada renglón en bd
	/*tabGuarda =[];

	$.each(tablaProductos,function(indice,valor){
		//alert(valor[6]);
		tabGuarda.push([valor[0],(valor[1]-c),valor[2],valor[3],valor[4],valor[5],valor[6],valor[7]]);
	});*/

}
$( document ).ready(function() {	
$(".fechaInv").keyup(function() {
  $(this).next('.fechaInv').focus();	
});
	/*$('#fechaInv').bind("enterKey",function(e){
	   //do stuff here
	   alert ("toy aqui");
	   //buscaProducto();
	});
	$('#fechaInv').keyup(function(e){
		if(e.keyCode == 13)
		{
			//$(this).trigger("enterKey");
			alert("toy alla");
			//buscaProducto();
		}
	});
	$('[name=detalle_cantidad]').bind("enterKey",function(e){
	   //do stuff here
	   agregarProductos();
	});
	$('[name=detalle_cantidad]').keyup(function(e){
		if(e.keyCode == 13)
		{
			//$(this).trigger("enterKey");
			agregarProductos();
		}
	});*/
	
});
	
</script>

<?php
pie();
?>