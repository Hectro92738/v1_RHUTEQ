<?php
include ("master.php");
//include ("leerCarpeta.php");
cabeza();
?>
<div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">ENVIAR CORREOS ELECTRONICOS</h1>
                </div>
            </div>
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Enviar correos XML Y PDF</div>
					<div class="panel-body">
						<div class="col-lg-4 form-group">
							<div class="input-group">
								<span class="input-group-addon">TIPO DE NOMINA</span>
								<select class="form-control" name="type" id="type" >
									<option value="0" selected>Seleccione el tipo de Nómina</option>
									<option name="UTEQ" value="UTEQ">NOMINA</option>
									<option name="JUBPENUTEQ" value="JUBPENUTEQ">JUBPENUTEQ</option>
								</select>                    
							</div>
						</div>
						<div class="col-lg-4 form-group" >
							<div class="input-group">
									<div class="input-group">
										<span class="input-group-addon">FECHA DE PAGO</span>
										<input class="form-control" name="fechaInv"  type="date" value="<?php echo date("Y-m-d");?>" />
									</div>
							</div>
						</div>
						<div class="col-lg-4 form-group" >
							<div class="input-group">
									<div class="checkbox checkbox-primary">
										<input id="checkbox2" type="checkbox"> <!--checked="">-->
										<label for="checkbox2">
											Sindicalizado
										</label>
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
	
	if ($('#checkbox2').is(":checked"))
		{
		 alert("soy sindicalizado"+$('#checkbox2').is(":checked"));
		}
	
	if($('#type').val() !=0) {
		$.ajax({
		  method: "POST",
		  url: "leerCarpeta.php",
		  data: { accion: "mailRecibos", 
			tipoNomina : $('#type').val(),
			fechaPago : $("input[name=fechaInv]").val(),
			Sindicalizado : $('#checkbox2').is(":checked"), /*true si esta checado si no vacio*/

		  }
		}).done(function( msg ) {
			datos = msg.split(",");
			alert("Enviando correos AGUANTAAAAAAAAAAAAAAAAAA....");
			location.reload();
		  });
	}else{
		alert("Selecciona el tipo de Nómina");
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