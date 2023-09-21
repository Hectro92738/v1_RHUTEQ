<?php
//session_start();
include ("master.php");
include ("leerCarpeta.php");
//include("SQLquerys/querysTimbrado.php");

cabeza();
?>
<div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Archivos Declaracion Patrimonial</h1>
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
					
					$carpeta = 'TEMP/DP'; //Declaramos el nombre de la carpeta que guardara los archivos
					
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
						$comprimido= $zip->open("TEMP/DP/".$archivonombre);
						if ($comprimido=== TRUE) {
						// Declaramos la carpeta que almacenara ficheros descomprimidos
							$anioActual = date("Y");
							$arrayNombre=explode(".", $archivonombre); 
							$carpeta=$arrayNombre[0];
							$path="RECIBOS/DECPAT/".$anioActual."/";
							$zip->extractTo($path);
							
							//$insertPathPDF=insertDatos($path."pdf",$fechaPago);
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
			}echo $fechaActual = date("y-m-d");
			$insertPathPDF=insertDatosDP($path.$carpeta,$fechaActual,"DECPAT");
			

		?>
				</div>
			</div>
            <div class="clear clean"></div>
			
			
<script type="text/javascript"> 

</script>

<?php
pie();
?>