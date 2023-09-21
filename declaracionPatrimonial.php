<?php
include ("master.php");

cabeza();
?>
<div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Subir Archivos Declaracion Patrimonial</h1>
                </div>
            </div>
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Subir PDF (Todos deben de empezar por num empleado) </div>
					<div class="panel-body">
						<div class="col-lg-12 form-group">
							<div class="form-group">
							  <form name="MiForm" id="MiForm" method="post" action="cargarPDF_DP.php" enctype="multipart/form-data">
       
								<!--<span class="input-group-addon">Subir archivo PDF ZIP:</span>
                                <label for="exampleFormControlFile1">Subir archivo XML ZIP:</label>-->
                                <!--<input required type="file" class="form-control-file" name="zip_file">                 
								<div >
                                	<button onclick="submitPDF();" class="btn btn-success center-block">Subir .ZIP PDF</i></button>
                            	</div>-->
							</div>
                            <div class="form-group">
                                <!--<label for="exampleFormControlFile1">Subir archivo XML ZIP:</label>-->
                                <input type="file" class="form-control" id="miarchivo[]" name="miarchivo[]" multiple="">                 
								<div >

								<button type="submit" class="btn btn-primary">Cargar archivos PDF </button>
                            	</div>
							</div>
							  </form>
						</div>
						
					
						<!--<input type="hidden" name="id_producto"/>
                            <div class="col-lg-12 form-group">
                            <div class="col-lg-6 form-group">
                                <button onclick="quitarProductos();" class="btn btn-danger center-block">Borrar </button>
                            </div>
                            <div class="col-lg-6 form-group ">
                                <button onclick="submit();" class="btn btn-success center-block">Subir Archivos</i></button>
                            </div>
                        </div>-->
					</div>
				</div>
			</div>
            
<script type="text/javascript"> 
	
</script>
<?php
 /*EMPEZAMOS A CREAR UNA CARPETA */
    $anio = date("Y");
    $mes = date("m");
   // echo $anio.'mes'.$mes;
    /*$micarpeta = 'RECIBOS/';
    if (!file_exists($micarpeta)) {
        mkdir($micarpeta, 0777, true);
    }*/


/*
     $zip = new ZipArchive;
	 // Declaramos el fichero a descomprimir, puede ser enviada desde un formulario
     $comprimido= $zip->open("TEMP/NOMINA_UTEQ_2023-02-28_pdf.zip");
     if ($comprimido=== TRUE) {
	 // Declaramos la carpeta que almacenara ficheros descomprimidos
         $zip->extractTo("RECIBOS");
         $zip->close();
	 // Imprimimos si todo salio bien
         echo "El fichero se descomprimio correctamente!";
     } else {
	 // Si algo salio mal, se imprime esta seccion
         echo "Error descomprimiendo el archivo zip";
     }*/
 pie();
?>