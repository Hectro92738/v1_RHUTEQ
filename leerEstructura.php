<?php
include("SQLquerys/querysEstructura.php");
ini_set('memory_limit', '-1');
/**
 * Demostrar lectura de hoja de cálculo o archivo
 * de Excel con PHPSpreadSheet: leer todo el contenido
 * de un archivo de Excel usando índices, no iteradores
 *
 * @author parzibyte
 */
 /** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

require_once "class/PhpSpreadsheet/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
$rutaArchivo = "/var/www/html/RHUTEQ/TEMP/ESTRUCTURA/ESTRU_HOY.csv";
$documento = IOFactory::load($rutaArchivo);
$sheetData = $documento->getActiveSheet()->toArray(null, true, true, true);
//var_dump($sheetData);
# obtener conteo e iterar
$totalDeHojas = $documento->getSheetCount();
borrarInfoEstru();
# Iterar hoja por hoja
for ($indiceHoja = 0; $indiceHoja < $totalDeHojas; $indiceHoja++) {
    # Obtener hoja en el índice que vaya del ciclo
    $hojaActual = $documento->getSheet($indiceHoja);
    //echo "<h3>Vamos en la hoja con índice $indiceHoja</h3>";

    # Calcular el máximo valor de la fila como entero, es decir, el
    # límite de nuestro ciclo
    $numeroMayorDeFila = $hojaActual->getHighestRow(); // Numérico
    $letraMayorDeColumna = $hojaActual->getHighestColumn(); // Letra
    # Convertir la letra al número de columna correspondiente
    $numeroMayorDeColumna = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($letraMayorDeColumna);

    # Iterar filas con ciclo for e índices
    for ($indiceFila = 1; $indiceFila <= $numeroMayorDeFila; $indiceFila++) {
        for ($indiceColumna = 1; $indiceColumna <= $numeroMayorDeColumna; $indiceColumna++) {
            # Obtener celda por columna y fila
            $celda = $hojaActual->getCellByColumnAndRow($indiceColumna, $indiceFila);
            # Y ahora que tenemos una celda trabajamos con ella igual que antes
            # El valor, así como está en el documento
            $valorRaw = $celda->getValue();

            # Formateado por ejemplo como dinero o con decimales
            $valorFormateado = $celda->getFormattedValue();

            # Si es una fórmula y necesitamos su valor, llamamos a:
            $valorCalculado = $celda->getCalculatedValue();

            # Fila, que comienza en 1, luego 2 y así...
            $fila = $celda->getRow();
            # Columna, que es la A, B, C y así...
            $columna = $celda->getColumn();

            //echo "En <strong>$columna$fila</strong> tenemos el valor <strong>$valorRaw</strong>. ";
            if($columna==="A"){  $DIRE=$valorRaw; /* echo "SOY A:".$DIRE."<BR/>";*/ }
            if($columna==="B"){  $DEPT=$valorRaw;  /*echo "SOY B:".$DEPT."<BR/>"; */}
            if($columna==="C"){  $ORG=$valorRaw;  /*echo "SOY C:".$ORG."<BR/>";*/ }
            if($columna==="D"){  $POS_NAME=$valorRaw; /* echo "SOY A:".$DIRE."<BR/>";*/ }
            if($columna==="E"){  $POS_STATUS=$valorRaw;  /*echo "SOY B:".$DEPT."<BR/>"; */}
            if($columna==="F"){  $JOB_NAME=$valorRaw;  /*echo "SOY C:".$ORG."<BR/>";*/ }
            if($columna==="G"){  $POS_TIPO_DESC=$valorRaw; /* echo "SOY A:".$DIRE."<BR/>";*/ }
            if($columna==="H"){  $POS_REF=$valorRaw;  /*echo "SOY B:".$DEPT."<BR/>"; */}
            if($columna==="I"){  $CATE_FED_ORIGINAL=$valorRaw;  /*echo "SOY C:".$ORG."<BR/>";*/ }
            if($columna==="J"){  $CAT_FED=$valorRaw; /* echo "SOY A:".$DIRE."<BR/>";*/ }
            if($columna==="K"){  $SDO_FED=$valorRaw;  /*echo "SOY B:".$DEPT."<BR/>"; */}
            if($columna==="L"){  $GPO_FED=$valorRaw;  /*echo "SOY C:".$ORG."<BR/>";*/ }
            if($columna==="M"){  $HRS_FED=$valorRaw;  /*echo "SOY B:".$DEPT."<BR/>"; */}
            if($columna==="N"){  $EMP_NUM=$valorRaw;  /*echo "SOY C:".$ORG."<BR/>";*/ }
            if($columna==="O"){  $EMP_NAME=$valorRaw; /* echo "SOY A:".$DIRE."<BR/>";*/ }
            if($columna==="P"){  $EMP_CURP=$valorRaw;  /*echo "SOY B:".$DEPT."<BR/>"; */}
            if($columna==="Q"){  $EMP_RFC=$valorRaw;  /*echo "SOY C:".$ORG."<BR/>";*/ }
            if($columna==="R"){  $EMP_IMSS=$valorRaw; /* echo "SOY A:".$DIRE."<BR/>";*/ }
            if($columna==="S"){  $EMP_SEX=$valorRaw;  /*echo "SOY B:".$DEPT."<BR/>"; */}
            if($columna==="T"){  $EMP_BIRTHDATE=$valorRaw;  /*echo "SOY C:".$ORG."<BR/>";*/ }
            if($columna==="U"){  $EMP_AGE=$valorRaw;  /*echo "SOY B:".$DEPT."<BR/>"; */}
            if($columna==="V"){  $EMP_PRIN_CON=$valorRaw;  /*echo "SOY C:".$ORG."<BR/>";*/ }
            if($columna==="W"){  $EMP_ACT_CON=$valorRaw; /* echo "SOY A:".$DIRE."<BR/>";*/ }
            if($columna==="X"){  $ASG_INI=$valorRaw;  /*echo "SOY B:".$DEPT."<BR/>"; */}
            if($columna==="Y"){  $ASG_FIN=$valorRaw;  /*echo "SOY C:".$ORG."<BR/>";*/ }
            if($columna==="Z"){  $ASG_NUM=$valorRaw; /* echo "SOY A:".$DIRE."<BR/>";*/ }
            if($columna==="AA"){ $ASG_SIN=$valorRaw;  /*echo "SOY B:".$DEPT."<BR/>"; */}
            if($columna==="AB"){ $SINDICALIZADO_N_S=$valorRaw;  /*echo "SOY C:".$ORG."<BR/>";*/ }
            if($columna==="AC"){ $TIPO_CONTRATO=$valorRaw;  /*echo "SOY B:".$DEPT."<BR/>"; */}
            if($columna==="AD"){ $ASG_SDO=$valorRaw;  /*echo "SOY C:".$ORG."<BR/>";*/ }
            if($columna==="AE"){ $ASG_SDO_FEC=$valorRaw; /* echo "SOY A:".$DIRE."<BR/>";*/ }
            if($columna==="AF"){ $ASG_HOR=$valorRaw;  /*echo "SOY B:".$DEPT."<BR/>"; */}
            if($columna==="AG"){ $NOM_NAME_1=$valorRaw;  /*echo "SOY C:".$ORG."<BR/>";*/ }
            if($columna==="AH"){ $BASE_NAME_1=$valorRaw; /* echo "SOY A:".$DIRE."<BR/>";*/ }
            if($columna==="AI"){ $ASG_REF=$valorRaw;  /*echo "SOY B:".$DEPT."<BR/>"; */}
            if($columna==="AJ"){ $EMAIL=$valorRaw;  /*echo "SOY C:".$ORG."<BR/>";*/ }
            if($columna==="AK"){ $QUINQUENIO=$valorRaw;  /*echo "SOY B:".$DEPT."<BR/>"; */}     
        }
        if($indiceFila!=1){ 
            
            if($EMP_NUM!=""){ 
                //echo $EMP_PRIN_CON."<br/>";
                $EMP_PRIN_CON=explode("/", $EMP_PRIN_CON); $dia=$EMP_PRIN_CON[0]; $mes=$EMP_PRIN_CON[1]; $anio=$EMP_PRIN_CON[2];$EMP_PRIN_CON="$anio-$mes-$dia";
                $ASG_INI=explode("/", $ASG_INI); $diaASG=$ASG_INI[0]; $mesASG=$ASG_INI[1]; $anioASG=$ASG_INI[2];$ASG_INI="$anioASG-$mesASG-$diaASG";
                $ASG_FIN=explode("/", $ASG_FIN); $diaF=$ASG_FIN[0]; $mesF=$ASG_FIN[1]; $anioF=$ASG_FIN[2];$ASG_FIN="$anioF-$mesF-$diaF";
                $ASG_SDO_FEC=explode("/", $ASG_SDO_FEC); $diaASF=$ASG_SDO_FEC[0]; $mesASF=$ASG_SDO_FEC[1]; $anioASF=$ASG_SDO_FEC[2];$ASG_SDO_FEC="$anioASF-$mesASF-$diaASF";
                $EMP_ACT_CON=explode("/", $EMP_ACT_CON); $diaAC=$EMP_ACT_CON[0]; $mesAC=$EMP_ACT_CON[1]; $anioAC=$EMP_ACT_CON[2];$EMP_ACT_CON="$anioAC-$mesAC-$diaAC";
                $EMP_BIRTHDATE=explode("/", $EMP_BIRTHDATE); $diaB=$EMP_BIRTHDATE[0]; $mesB=$EMP_BIRTHDATE[1]; $anioB=$EMP_BIRTHDATE[2];$EMP_BIRTHDATE="$anioB-$mesB-$diaB";
    
                    $insertBD=insertEstructura($DIRE,$DEPT,$ORG,$POS_NAME,
                $POS_STATUS,$JOB_NAME, $POS_TIPO_DESC,$POS_REF,$CATE_FED_ORIGINAL,$CAT_FED,$SDO_FED,$GPO_FED,$HRS_FED,$EMP_NUM,
                $EMP_NAME,$EMP_CURP,$EMP_RFC,$EMP_IMSS,$EMP_SEX,
                $EMP_AGE,$EMP_PRIN_CON,$ASG_INI, $ASG_FIN,$ASG_NUM,$ASG_SIN, $SINDICALIZADO_N_S, $TIPO_CONTRATO,
                $ASG_SDO, $ASG_SDO_FEC, $ASG_HOR, $NOM_NAME_1, $BASE_NAME_1,$EMAIL, $QUINQUENIO,$EMP_ACT_CON, $EMP_BIRTHDATE);
            }
        }
    }
}
   
?>

