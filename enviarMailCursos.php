<?php
include ("master.php");
//include ("leerCarpeta.php");
cabeza();
?>
<div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">ENVIAR CORREOS DECLARACION PATRIMONIAL</h1>
                </div>
            </div>
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Enviar correos Declaración Patrimonial</div>
					<div class="panel-body">
						<div class="col-lg-4 form-group">
							<div class="input-group">
								<span class="input-group-addon">TIPO DE ARCHIVO</span>
								<select class="form-control" name="type" id="type" >
									<option value="0" selected>Seleccione el tipo de Archivo a enviar</option>
									<option name="DP" value="DP">Declaración Patrimonial</option>
									
								</select>                    
							</div>
						</div>
						<div class="col-lg-4 form-group" >
							<div class="input-group">
									<div class="input-group">
										<span class="input-group-addon">AÑO</span>
										<input class="form-control" name="anio"  type="date" value="<?php echo date("Y-m-d");?>" />
									</div>
							</div>
						</div>
					</div> 
							
						
						<input type="hidden" name="id_producto"/>
						<div class="col-lg-12 form-group"></div>
						<!--<div class="col-lg-6 form-group">
							<button onclick="quitarProductos();" class="btn btn-danger center-block">Borrar </button>
						</div>-->
						<div class="col-lg-12 form-group ">
							<button onclick="enviarCorreos();" class="btn btn-success center-block">Enviar Correos</i></button>
						</div>
					</div>
				</div>
			</div>
            <div class="clear clean"></div>
			
			<div class="col-lg-12">
				<!--<div class="panel panel-default">
					<div class="panel-heading">
						Productos
					</div>
					<div class="panel-body">
						<div class="table-responsive">
						<table id="productos" class="table table-striped" cellspacing="0" width="100%">
						        <thead>
						            <tr>
						                <th class="col-sm-1">#</th>
						                <th class="col-sm-5">Nombre</th>
						                <th class="col-sm-2">Cant</th>
						                <th class="col-sm-2">Desc</th>
						                <th class="col-sm-1">Precio Uni</th>
						                <th class="col-sm-1">IVA</th>
						                <th class="col-sm-1">Sub</th>
						                <th class="col-sm-1">Total</th>
						            </tr>
						        </thead>
								<tbody>
								</tbody>
						 </table>	
						 </div>
					</div>
				</div>-->
			</div>
<script type="text/javascript"> 
var tablaProductos = []; 
/* funcion para ocultar y mostrar div
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
});*/
function enviarCorreos(){
	
	if($('#type').val() !=0) {
		$.ajax({
		  method: "POST",
		  url: "leerCarpeta.php",
		  data: { accion: "mailDP", 
			tipoNomina : $('#type').val(),
			fechaPago : $("input[name=anio]").val(),

		  }
		}).done(function( msg ) {
			datos = msg.split(",");
			alert("Enviando correos AGUANTAAAAAAAAAAAAAAAAAA....");
			location.reload();
		  });
	}else{
		alert("Selecciona el tipo de Archivo");
	}
}



/*$( document ).ready(function() {	
$(".fechaInv").keyup(function() {
  $(this).next('.fechaInv').focus();	
});
	
});*/
	
</script>

<?php
pie();
?>