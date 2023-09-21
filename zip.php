<?php
 
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
     }
 
?>