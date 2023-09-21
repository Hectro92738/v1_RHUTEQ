<?php
	//incluimos la clase
    //
	require_once '/var/www/html/RHUTEQ/vendor/php/PHPExcel/IOFactory.php';
	//require_once 'connection_aplicanet.php';
    require_once '/var/www/html/RHUTEQ/SQLquerys/querysEstructura.php';
	class MigracionExcel{
		function nomiImpuestos($file){
				//cargamos el archivo que deseamos leer
				$objPHPExcel = PHPExcel_IOFactory::load($file);
				//obtenemos los datos de la hoja activa (la primera)
				$objHoja=$objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
				$num_rows=$objPHPExcel->getActiveSheet()->getHighestColumn();
				$num_rows = PHPExcel_Cell::columnIndexFromString($num_rows);
				if($num_rows==6){
					return true;
				}else{
					return false;
				}
		}
		function nomiConceptos($file){
			//cargamos el archivo que deseamos leer
			$objPHPExcel = PHPExcel_IOFactory::load($file);
			//obtenemos los datos de la hoja activa (la primera)
			$objHoja=$objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			$num_rows=$objPHPExcel->getActiveSheet()->getHighestColumn();
			$num_rows = PHPExcel_Cell::columnIndexFromString($num_rows);
			if($num_rows==9){
					return true;
				}else{
					return false;
				}
		}
		function nomiDeducciones($file){
			//cargamos el archivo que deseamos leer
			$objPHPExcel = PHPExcel_IOFactory::load($file);
			//obtenemos los datos de la hoja activa (la primera)
			$objHoja=$objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			$num_rows=$objPHPExcel->getActiveSheet()->getHighestColumn();
			$num_rows = PHPExcel_Cell::columnIndexFromString($num_rows);
			if($num_rows==9){
					return true;
				}else{
					return false;
				}
		}
		function nomiPercepciones($file){
			//cargamos el archivo que deseamos leer
			$objPHPExcel = PHPExcel_IOFactory::load($file);
			//obtenemos los datos de la hoja activa (la primera)
			$objHoja=$objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			$num_rows=$objPHPExcel->getActiveSheet()->getHighestColumn();
			$num_rows = PHPExcel_Cell::columnIndexFromString($num_rows);
			if($num_rows==9){
					return true;
				}else{
					return false;
				}
		}
		function nomiComNomina($file){
			//cargamos el archivo que deseamos leer
			$objPHPExcel = PHPExcel_IOFactory::load($file);
			//obtenemos los datos de la hoja activa (la primera)
			$objHoja=$objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			$num_rows=$objPHPExcel->getActiveSheet()->getHighestColumn();
			$num_rows = PHPExcel_Cell::columnIndexFromString($num_rows);
			if($num_rows==26){
					return true;
				}else{
					return false;
				}
		}
		function nomiFacturas($file){
			//cargamos el archivo que deseamos leer
			$objPHPExcel = PHPExcel_IOFactory::load($file);
			//obtenemos los datos de la hoja activa (la primera)
			$objHoja=$objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			$num_rows=$objPHPExcel->getActiveSheet()->getHighestColumn();
			$num_rows = PHPExcel_Cell::columnIndexFromString($num_rows);
			if($num_rows==30){
					return true;
				}else{
					return false;
				}
		}
		function nomiEmpleado($file){
			//cargamos el archivo que deseamos leer
			$objPHPExcel = PHPExcel_IOFactory::load($file);
			//obtenemos los datos de la hoja activa (la primera)
			$objHoja=$objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			$num_rows=$objPHPExcel->getActiveSheet()->getHighestColumn();
			$num_rows = PHPExcel_Cell::columnIndexFromString($num_rows);
			if($num_rows==20){
					return true;
				}else{
					return false;
				}
		}
		function insert($empleado,$factura,$complemento,$impuestos,$conceptos,$percepciones,$deducciones,$origen){
			$objEmpleados = PHPExcel_IOFactory::load($empleado);
			$arrayEmpleados=$objEmpleados->getActiveSheet()->toArray(null,true,true,true);
			foreach($arrayEmpleados as $key=>$row){
				if($key>1){
					$rfc=$row['D'];
					$status='A';//echo $row['T']."<br/>";
                    $diagonal = strpos($row['T'], '/');
                    //echo $pos."<br/>";
                    if(($diagonal==null)||($diagonal==0)){
                        $fragmentos = explode("-", $row['T']);
                    }else{
                        $fragmentos = explode("/", $row['T']);
                    }
                    //var_dump($fragmentos);
                    $dia=strlen($fragmentos[0]);
                    if($dia==2){
                      ///echo "entro al if";
                        $fecha_efectiva=date_create_from_format('d/m/Y', $row['T']);
                        $fecha_efectiva=$fecha_efectiva->format('Y-m-d');
                    }else{
                        $fecha_efectiva=$row['T'];
                    }
					$fecha_emision=date('Y-m-d H:i:s');
                     //echo $fecha_efectiva."<br/>";
                    //echo $fecha_emision;
					//insertar empleado
					//var_dump($row);
					$this->insertEmpleado($row['B'],utf8_decode($row['C']),$row['D'],$row['E'],$row['F'],$row['G'],$row['H'],$row['I'],$row['J'],$row['K'],$row['L'],$row['M'],$row['N'],$row['O'],$row['P'],$row['Q'],$row['R'],$status,$fecha_efectiva);

					//id_empleado
					$idEmpleado=$this->getIdEmpleado($fecha_efectiva, $rfc);

					//insert factura
					$array_facturas=$this->queryFactura($factura, $rfc);
					//var_dump($array_facturas);
					foreach($array_facturas as $array_factura){
						$this->insertFactura($array_factura['B'],$idEmpleado,$array_factura['D'], $array_factura['E'], $array_factura['F'], $array_factura['G'],$array_factura['H'],$array_factura['I'],'3.2','P',$fecha_emision, $array_factura['M'],$array_factura['N'],$this->cantidadLetra($array_factura['Q']), $array_factura['P'], $array_factura['Q'], $array_factura['R'], $array_factura['S'], $array_factura['T'], $array_factura['U'], $array_factura['V'], $array_factura['W'],'egreso',$origen, $array_factura['AD'], $array_factura['AE']);
					}

					//id_Factura
					$id_nFactura=$this->getIdFactura($idEmpleado, $fecha_emision);

					//insert complemento
					$array_complementos=$this->queryComplemento($complemento, $rfc);
					//var_dump($array_complementos);
					foreach($array_complementos as $array_complemento){
						$fecha_pago=date_create_from_format('d/m/Y',$array_complemento['I']);
						$fecha_pago=$fecha_pago->format('Y-m-d');
						$fecha_inicial=date_create_from_format('d/m/Y',$array_complemento['J']);
						$fecha_inicial=$fecha_inicial->format('Y-m-d');
						$fecha_final=date_create_from_format('d/m/Y',$array_complemento['K']);
						$fecha_final=$fecha_final->format('Y-m-d');
						$fecha_laboral=date_create_from_format('d/m/Y',$array_complemento['Q']);
						$fecha_laboral=$fecha_laboral->format('Y-m-d');
						$this->insertComplemento($id_nFactura, '1.1', $array_complemento['D'], $array_complemento['E'], $array_complemento['F'], $array_complemento['G'], $array_complemento['H'], $fecha_pago,$fecha_inicial,$fecha_final, $array_complemento['L'], $array_complemento['M'], $array_complemento['N'], $array_complemento['O'], $array_complemento['P'],$fecha_laboral, $array_complemento['R'], $array_complemento['S'], $array_complemento['T'], $array_complemento['U'], $array_complemento['V'], $array_complemento['W'], $array_complemento['X'], $array_complemento['Y']);
					}

					//insertConceptos
					$array_conceptos=$this->queryConceptos($conceptos, $rfc);
					//var_dump($array_conceptos);
					foreach($array_conceptos as $array_concepto){
						$this->insertConceptos($id_nFactura, $array_concepto['C'], $array_concepto['D'], $array_concepto['E'], $array_concepto['F'], $array_concepto['G'], $array_concepto['H']);
					}

					//insertImpuestos
					$array_impuestos=$this->queryImpuestos($impuestos, $rfc);
					//var_dump($array_impuestos);
					foreach($array_impuestos as $array_impuesto){
						$this->insertImpuestos($id_nFactura, $array_impuesto['C'], $array_impuesto['D'], $array_impuesto['E']);
					}

					//insertDeducciones
					$array_deducciones=$this->queryDeducciones($deducciones, $rfc);
					//var_dump($array_deducciones);
					foreach($array_deducciones as $array_deduccion){
						$this->insertDeducciones($id_nFactura,$array_deduccion['C'],$array_deduccion['D'], $array_deduccion['E'], $array_deduccion['F'], $array_deduccion['G'], $array_deduccion['H']);
					}

					//insertPercepciones
					$array_percepciones=$this->queryPercepciones($percepciones, $rfc);
					//var_dump($array_percepciones);
					foreach($array_percepciones as $array_percepcion){
						$this->insertPercepciones($id_nFactura,$array_percepcion['C'],$array_percepcion['D'],$array_percepcion['E'],$array_percepcion['F'],$array_percepcion['G'],$array_percepcion['H']);
					}
				}
			}

		}
        function validarEmpleado($ArchivoEmpleado){
			$objEmpleados = PHPExcel_IOFactory::load($ArchivoEmpleado);
			$arrayEmpleados=$objEmpleados->getActiveSheet()->toArray(null,true,true,true);
			foreach($arrayEmpleados as $key=>$row){
			  //var_dump($arrayEmpleados);
				if($key>1){
					$razonSocial=$row['C'];//razonsocial
                    $rfc=$row['D'];//RFC
                    $id_nomi_cata=$row['E'];//id_nomi_cata_reg 1-asimilados 2-nomina
                    $status=$row['S'];//status
               if(($row['C']<>NULL)&&($row['D']<>NULL)&&(strlen($rfc)==13)&&(($id_nomi_cata==2)||($id_nomi_cata==9))&&($status<>NULL)){
                    return 0;
                    //echo "traigo datos";
                }else {//datos vienen vacíos
				    return 1;
                  //echo "vengo vacio";
				}
			}
           }
		}
        function validarFactura($ArchivoFacturas){
			$objFacturas = PHPExcel_IOFactory::load($ArchivoFacturas);
			$arrayFacturas=$objFacturas->getActiveSheet()->toArray(null,true,true,true);
			foreach($arrayFacturas as $key=>$row){
			  //var_dump($arrayFacturas);
				if($key>1){
					$id_emisor=$row['B'];
                    $formaPago=$row['E'];
                    $metodoPago=$row['F'];
                    $nFolio=$row['H'];
                    $nSerie=$row['I'];
                    $nMoneda=$row['M'];
                    $nSubtotal=$row['P'];
                    $nTotal=$row['Q']; //sin comas
                    $totalImpuestosRetenidos=$row['R'];
                    $totalImpuestosTrasladados=$row['S'];
                    $nPerTotalGravado=$row['T'];
                    $nPerTotalExcento=$row['U'];
                    $nDeduTotalGravado=$row['V'];
                    $nDeduTotalExcento=$row['W'];
                    $descuento=$row['AD'];
                    $motivoDescuento=$row['AE'];
                    $nRFC=$row['AF']; //RFC LLAVE
                    $numEmi=is_numeric($id_emisor);$vSubtotal=is_numeric($nSubtotal);$vTotal=is_numeric($nTotal);$vtotalImpuestosRetenidos=is_numeric($totalImpuestosRetenidos);$vtotalImpuestosTrasladados=is_numeric($totalImpuestosTrasladados);$vPerTotalGravado=is_numeric($nPerTotalGravado);$vPerTotalExcento=is_numeric($nPerTotalExcento);$vDeduTotalGravado=is_numeric($nDeduTotalGravado);$vDeduTotalExcento=is_numeric($nDeduTotalExcento);  $vDescuento=is_numeric($descuento);
                    $comaSub = strpos($nSubtotal, ',');$comaTot = strpos($nTotal, ','); $comaImpR=strpos($totalImpuestosRetenidos, ',');$comaImpT=strpos($totalImpuestosTrasladados, ',');$comaPerTG=strpos($nPerTotalGravado, ','); $comaPerTE=strpos($nPerTotalExcento, ',');  $comaDedTG=strpos($nDeduTotalGravado, ',');  $comaDedTE=strpos($nDeduTotalExcento, ','); $comaDescuento=strpos($descuento, ',');
                    //VALIDAR QUE LOS DATOS NO VENGAN VACIOS
                    if(($id_emisor<>NULL)&&($numEmi<>FALSE)&&($formaPago<>NULL)&&($metodoPago<>NULL)&&($nFolio<>NULL)&&($nSerie<>NULL)&&($nMoneda<>NULL)&&($nSubtotal<>NULL)&&($vSubtotal<>false)&&($comaSub==false)
              &&($nTotal<>NULL)&&($vTotal<>false)&&($comaTot==false)&&(($totalImpuestosRetenidos<>NULL)||($totalImpuestosRetenidos==0))&&($vtotalImpuestosRetenidos<>false)&&($comaImpR==false)
              &&(($totalImpuestosTrasladados<>NULL)||($totalImpuestosTrasladados==0))&&($vtotalImpuestosTrasladados<>false)&&($comaImpT==false)
              &&(($nPerTotalGravado<>NULL)||($nPerTotalGravado==0))&&($vPerTotalGravado<>false)&&($comaPerTG==false)&&(($nPerTotalExcento<>NULL)||($nPerTotalExcento==0))&&($vPerTotalExcento<>false)&&($comaPerTE==false)
              &&(($nDeduTotalGravado<>NULL)||($nDeduTotalGravado==0))&&($vDeduTotalGravado<>false)&&($comaDedTG==false)&&(($nDeduTotalExcento<>NULL)||($nDeduTotalExcento==0))&&($vDeduTotalExcento<>false)&&($comaDedTE==false)&&(strlen($nRFC)==13)&&($nRFC<>NULL)){
                        return 0;//echo "traigo datos";
                    }else {//datos vienen vacíos 
				        return 1;//echo "vengo vacio";
				    }
			  }
           }
		}
        function validarImpuestos($ArchivoImpuestos){
			$objImpuestos = PHPExcel_IOFactory::load($ArchivoImpuestos);
			$arrayImpuestos=$objImpuestos->getActiveSheet()->toArray(null,true,true,true);
			foreach($arrayImpuestos as $key=>$row){
			  //var_dump($arrayImpuestos);
				if($key>1){
					$tasa=$row['C'];
                    $impuesto=$row['D'];
                    $importe=$row['E'];
                    $rfc=$row['F'];
                    $vtasa=is_numeric($tasa); $comaTasa = strpos($tasa, ',');
                    $vimporte=is_numeric($tasa); $comaimporte = strpos($importe, ',');
                    if((($tasa<>NULL)||($tasa==0))&&($vtasa<>false)&&($comaTasa==false)&&($impuesto<>NULL)&&(($importe<>NULL)||($importe==0))&&($vimporte<>false)&&($comaimporte==false)&&(strlen($rfc)==13)&&($rfc<>NULL)){
                        return 0;//echo "traigo datos";
                    }else {//datos vienen vacíos
				        return 1;//echo "vengo vacio";
				    }
			    }
           }
		}
        function validarComplemento($ArchivoComplemento){
			$objComplemento = PHPExcel_IOFactory::load($ArchivoComplemento);
			$arrayComplemento=$objComplemento->getActiveSheet()->toArray(null,true,true,true);
			foreach($arrayComplemento as $key=>$row){
			  //var_dump($arrayImpuestos);
				if($key>1){
					$curp=$row['F'];
                    $tipoRegimen=$row['G'];
                    $fechaPago=$row['I'];
                    $FechaInicialPago=$row['J'];
                    $FechaFinalPago=$row['K'];
                    $numDias=$row['M'];
                    $fechaIniRelacion=$row['Q'];
                    $periodicidad=$row['V'];
                    $salarioBase=$row['W'];
                    $salarioDiario=$row['Y'];
                    $rfc=$row['Z'];
                    $vnumDias=is_numeric($numDias);
                    $vsalarioDiario=is_numeric($salarioDiario); $comaSalarioDiario = strpos($salarioDiario, ',');
                    $vsalarioBase=is_numeric($salarioBase); $comaSalarioBase = strpos($salarioBase, ',');
                    //  echo "fecha pago".$this->verificaDate($fechaPago)."<br/>";
                    if(($curp<>NULL)&&(strlen($curp)==18)&&(($tipoRegimen==2)||($tipoRegimen==9))&&($periodicidad<>NULL)&&(strlen($rfc)==13)&&($rfc<>NULL)
                    &&(($numDias<>NULL)||($numDias==0))&&($vnumDias<>false)
                   &&(($salarioBase<>NULL)||($salarioBase==0))&&($vsalarioBase<>false)&&($comaSalarioBase==false)
                   &&(($salarioDiario<>NULL)||($salarioDiario==0))&&($vsalarioDiario<>false)&&($comaSalarioDiario==false)
                   &&(($this->verificaDate($fechaPago))<>0) &&($fechaPago<>NULL)&&(($this->verificaDate($FechaInicialPago))<>0)&&($FechaInicialPago<>NULL)&&(($this->verificaDate($FechaFinalPago))<>0)&&($FechaFinalPago<>NULL)
                    &&($fechaIniRelacion<>NULL)
                     ){
                        return 0;//echo "traigo datos";
                    }else {//datos vienen vacíos
				        return 1;//echo "vengo vacio";
				    }
			    }
           }
		}
         function validarConceptos($ArchivoConceptos){
			$objConceptos = PHPExcel_IOFactory::load($ArchivoConceptos);
			$arrayConceptos=$objConceptos->getActiveSheet()->toArray(null,true,true,true);
			foreach($arrayConceptos as $key=>$row){
			  //var_dump($arrayImpuestos);
				if($key>1){
					$cantidad=$row['C'];
                    $descripcion=$row['D'];
                    $um=$row['E'];
                    $puni=$row['F'];
                    $importe=$row['H'];
                    $rfc=$row['I'];
                    $vCantidad=is_numeric($cantidad);
                    $vPuni=is_numeric($puni); $comaPuni = strpos($puni, ',');
                    $vImporte=is_numeric($importe); $comaImporte = strpos($importe, ',');

                    if(($cantidad<>NULL)&&($vCantidad<>false)&&($descripcion<>NULL)&&($um<>NULL)
                    &&(($puni<>NULL)||($puni==0))&&($vPuni<>false)&&($comaPuni==false)
                    &&(($importe<>NULL)||($importe==0))&&($vImporte<>false)&&($comaImporte==false)
                    &&(strlen($rfc)==13)&&($rfc<>NULL)){
                        return 0;//echo "traigo datos";
                    }else {//datos vienen vacíos
				        return 1;//echo "vengo vacio";
				    }
			    }
           }
		}
        function validarDeducciones($ArchivoDeducciones){
			$objDeducciones = PHPExcel_IOFactory::load($ArchivoDeducciones);
			$arrayDeducciones=$objDeducciones->getActiveSheet()->toArray(null,true,true,true);
			foreach($arrayDeducciones as $key=>$row){
			  //var_dump($arrayImpuestos);
				if($key>1){
					$tipoDeduccion=$row['C'];
                    $clave=$row['D'];
                    $concepto=$row['E'];
                    $nImporteGravado=$row['F'];
                    $importeExcento=$row['G'];
                    $importe=$row['H'];
                    $rfc=$row['I'];
                    $vtipoDeduccion=is_numeric($tipoDeduccion);$vClave=is_numeric($clave);$vImporteGravado=is_numeric($nImporteGravado);$vimporteExcento=is_numeric($importeExcento);$vImporte=is_numeric($importe);
                    $comaImporteGr = strpos($vImporteGravado, ','); $comaImporteEx = strpos($importeExcento, ','); $comaImporte = strpos($importe, ',');

                    if((($tipoDeduccion<>NULL)||($tipoDeduccion==0))&&($vtipoDeduccion<>false)
                    &&(($clave<>NULL)||($clave==0))&&($vClave<>false)&&($concepto<>NULL)
                    &&(($nImporteGravado<>NULL)||($nImporteGravado==0))&&($vImporteGravado<>false)&&($comaImporteGr==false)
                    &&(($importeExcento<>NULL)||($importeExcento==0))&&($vimporteExcento<>false)&&($comaImporteEx==false)
                    &&(($importe<>NULL)||($importe==0))&&($vImporte<>false)&&($comaImporte==false)
                    &&(strlen($rfc)==13)&&($rfc<>NULL)){
                        return 0;//echo "traigo datos";
                    }else {//datos vienen vacíos
				        return 1;//echo "vengo vacio";
				    }
			    }
           }
		}
         function validarPercepciones($ArchivoPercepciones){
			$objPercepciones = PHPExcel_IOFactory::load($ArchivoPercepciones);
			$arrayPercepciones=$objPercepciones->getActiveSheet()->toArray(null,true,true,true);
			foreach($arrayPercepciones as $key=>$row){
			  //var_dump($arrayImpuestos);
				if($key>1){
					$tipoDeduccion=$row['C'];
                    $clave=$row['D'];
                    $concepto=$row['E'];
                    $nImporteGravado=$row['F'];
                    $importeExcento=$row['G'];
                    $importe=$row['H'];
                    $rfc=$row['I'];
                    $vtipoDeduccion=is_numeric($tipoDeduccion);$vClave=is_numeric($clave);$vImporteGravado=is_numeric($nImporteGravado);$vimporteExcento=is_numeric($importeExcento);$vImporte=is_numeric($importe);
                    $comaImporteGr = strpos($vImporteGravado, ','); $comaImporteEx = strpos($importeExcento, ','); $comaImporte = strpos($importe, ',');

                    if((($tipoDeduccion<>NULL)||($tipoDeduccion==0))&&($vtipoDeduccion<>false)
                    &&(($clave<>NULL)||($clave==0))&&($vClave<>false)&&($concepto<>NULL)
                    &&(($nImporteGravado<>NULL)||($nImporteGravado==0))&&($vImporteGravado<>false)&&($comaImporteGr==false)
                    &&(($importeExcento<>NULL)||($importeExcento==0))&&($vimporteExcento<>false)&&($comaImporteEx==false)
                    &&(($importe<>NULL)||($importe==0))&&($vImporte<>false)&&($comaImporte==false)
                    &&(strlen($rfc)==13)&&($rfc<>NULL)){
                        return 0;//echo "traigo datos";
                    }else {//datos vienen vacíos
				        return 1;//echo "vengo vacio";
				    }
			    }
           }
		}
		function insertEmpleado($nAsignacion,$nRazonSocial,$nRFC,$id_nomi_cata_reg,$nPais,$nEstado,$nMunicipio,$nColonia,$nCalle,$nNoInterior,$nNoExterior,$nCorreo,$nCodigoPostal,$nTelefono,$nDependencia,$nDireccion,$nPuesto,$nStatus,$nFechaEfectiva){
			$query_duplicado_empleado="select * from nomi_Empleado where nRazonSocial='".$nRazonSocial."' and nAsignacion='".$nAsignacion."' and nRFC='".$nRFC."' and id_nomi_cata_reg='".$id_nomi_cata_reg."' and nPais='".$nPais."' and nEstado='".$nEstado."' and nMunicipio='".$nMunicipio."' and nColonia='".$nColonia."' and nCalle='".$nCalle."' and nNoInterior='".$nNoInterior."' and nNoEXterior='".$nNoExterior."' and nCorreo='".$nCorreo."' and nCodigoPostal='".$nCodigoPostal."' and nTelefono='".$nTelefono."' and nDependencia='".$nDependencia."' and nDireccion='".$nDireccion."' and nPuesto='".$nPuesto."'";
			//echo $query_duplicado_empleado;
			$rs_duplicado_empleado=mysql_query($query_duplicado_empleado);
			if(mysql_num_rows($rs_duplicado_empleado)>0){
				$row=mysql_fetch_assoc($rs_duplicado_empleado);
				$query_update_empleado="update nomi_Empleado set nStatus='A', nFechaEfectiva='".$nFechaEfectiva."' where id_nContribuyente='".$row['id_nContribuyente']."'";
				//echo $query_update_empleado;
				$rs_update_empleado=mysql_query($query_update_empleado);
			}else{
				$query_insert_empleado="insert into nomi_Empleado (nRazonSocial,nAsignacion,nRFC,id_nomi_cata_reg,nPais,nEstado,nMunicipio,nColonia,nCalle,nNoInterior,nNoEXterior,nCorreo,nCodigoPostal,nTelefono,nDependencia,nDireccion,nPuesto,nStatus,nFechaEfectiva)
				values ('".utf8_decode($nRazonSocial)."','".$nAsignacion."','".$nRFC."',".$id_nomi_cata_reg.",'".$nPais."','".$nEstado."','".$nMunicipio."','".utf8_decode($nColonia)."','".$nCalle."','".$nNoInterior."','".$nNoExterior."','".$nCorreo."','".$nCodigoPostal."','".$nTelefono."','".$nDependencia."','".$nDireccion."','".$nPuesto."','".$nStatus."','".$nFechaEfectiva."')";
				//echo $query_insert_empleado;
				$rs_insert_empleado=mysql_query($query_insert_empleado);
			}
			
		}
		function insertComplemento($id_nFactura,$nVersion,$nRegPatro,$nNumEmpleado,$nCurp,$nTipoRegimen,$nNumSegSocial,$nFechaPago,$nFechaInicialPago,$nFechaFinalPago,$nPeriodoPago,$nNumDiasPagados,$nDepto,$nCLABE,$nBanco,$nFechaInicioRel,$nAntiguedad,$nPuesto,$nTipoContrato,$nTipoJornada,$nPeriodiciadadPago,$nSalarioBaseCotApor,$nRiesgoPuesto,$nSalarioDiarioIntegrado){
			$query_insert_complemento="insert into nomi_comNomina (id_nFactura,nVersion,nRegPatro,nNumEmpleado,nCurp,nTipoRegimen,nNumSegSocial,nFechaPago,nFechaInicialPago,nFechaFinalPago,nPeriodoPago,nNumDiasPagados,nDepto,nCLABE,nBanco,nFechaInicioRel,nAntiguedad,nPuesto,nTipoContrato,nTipoJornada,nPeriodiciadadPago,nSalarioBaseCotApor,nRiesgoPuesto,nSalarioDiarioIntegrado)
			values (".$id_nFactura.",".$nVersion.",'".$nRegPatro."','".$nNumEmpleado."','".$nCurp."',".$nTipoRegimen.",'".$nNumSegSocial."','".$nFechaPago."','".$nFechaInicialPago."','".$nFechaFinalPago."','".$nPeriodoPago."','".$nNumDiasPagados."','".$nDepto."','".$nCLABE."','".$nBanco."','".$nFechaInicioRel."','".utf8_decode($nAntiguedad)."','".$nPuesto."','".$nTipoContrato."','".$nTipoJornada."','".$nPeriodiciadadPago."',".$nSalarioBaseCotApor.",'".$nRiesgoPuesto."',".$nSalarioDiarioIntegrado.")";
			//echo $query_insert_complemento;
			$rs_insert_complemento=mysql_query($query_insert_complemento);
		}
		function insertFactura($id_emisor,$id_nContribuyente,$DependenciaEmp,$nFormaPago,$nMetodoPago,$nMetodoDigitos,$nFolio,$nSerie,$nVersion,$nStatus,$nFechaEmision,$nMoneda,$nLugaExpedicion,$nCantidadLetra,$nSubtotal,$nTotal,$totalImpuestosRetenidos,$totalImpuestosTrasladado,$nPerTotalGravado,$nPerTotalExcento,$nDeduTotalGravado,$nDeduTotalExcento,$nTipoComprobante,$origen,$descuento,$motivoDescuento){
            if(strlen($nMetodoDigitos)==4){
                $query_insert_factura="insert into nomi_Facturas (id_emisor,id_nContribuyente,DependenciaEmp,nFormaPago,nMetodoPago,nMetodoDigitos,nFolio,nSerie,nStatus,nVersion,nFechaEmision,nMoneda,nLugaExpedicion,nCantidadLetra,nSubtotal,nTotal,totalImpuestosRetenidos,totalImpuestosTrasladados,nPerTotalGravado,	nPerTotalExcento,nDeduTotalGravado,	nDeduTotalExcento,nTipoComprobante,nOrigenNomina,descuento,motivoDescuento)
			    values ('".$id_emisor."','".$id_nContribuyente."','".$DependenciaEmp."','".$nFormaPago."','".$nMetodoPago."','".$nMetodoDigitos."','".$nFolio."','".$nSerie."','".$nStatus."','".$nVersion."','".$nFechaEmision."','".$nMoneda."','".$nLugaExpedicion."','".$nCantidadLetra."','".$nSubtotal."','".$nTotal."','".$totalImpuestosRetenidos."','".$totalImpuestosTrasladado."','".$nPerTotalGravado."','".$nPerTotalExcento."','".$nDeduTotalGravado."','".$nDeduTotalExcento."','".$nTipoComprobante."','".$origen."','".$descuento."','".$motivoDescuento."')";
			 }else if(strlen($nMetodoDigitos)==1){
                $query_insert_factura="insert into nomi_Facturas (id_emisor,id_nContribuyente,DependenciaEmp,nFormaPago,nMetodoPago,nMetodoDigitos,nFolio,nSerie,nStatus,nVersion,nFechaEmision,nMoneda,nLugaExpedicion,nCantidadLetra,nSubtotal,nTotal,totalImpuestosRetenidos,totalImpuestosTrasladados,nPerTotalGravado,	nPerTotalExcento,nDeduTotalGravado,	nDeduTotalExcento,nTipoComprobante,nOrigenNomina,descuento,motivoDescuento)
			    values ('".$id_emisor."','".$id_nContribuyente."','".$DependenciaEmp."','".$nFormaPago."','".$nMetodoPago."','000".$nMetodoDigitos."','".$nFolio."','".$nSerie."','".$nStatus."','".$nVersion."','".$nFechaEmision."','".$nMoneda."','".$nLugaExpedicion."','".$nCantidadLetra."','".$nSubtotal."','".$nTotal."','".$totalImpuestosRetenidos."','".$totalImpuestosTrasladado."','".$nPerTotalGravado."','".$nPerTotalExcento."','".$nDeduTotalGravado."','".$nDeduTotalExcento."','".$nTipoComprobante."','".$origen."','".$descuento."','".$motivoDescuento."')";

			 } else if(strlen($nMetodoDigitos)==2){
                $query_insert_factura="insert into nomi_Facturas (id_emisor,id_nContribuyente,DependenciaEmp,nFormaPago,nMetodoPago,nMetodoDigitos,nFolio,nSerie,nStatus,nVersion,nFechaEmision,nMoneda,nLugaExpedicion,nCantidadLetra,nSubtotal,nTotal,totalImpuestosRetenidos,totalImpuestosTrasladados,nPerTotalGravado,	nPerTotalExcento,nDeduTotalGravado,	nDeduTotalExcento,nTipoComprobante,nOrigenNomina,descuento,motivoDescuento)
			    values ('".$id_emisor."','".$id_nContribuyente."','".$DependenciaEmp."','".$nFormaPago."','".$nMetodoPago."','00".$nMetodoDigitos."','".$nFolio."','".$nSerie."','".$nStatus."','".$nVersion."','".$nFechaEmision."','".$nMoneda."','".$nLugaExpedicion."','".$nCantidadLetra."','".$nSubtotal."','".$nTotal."','".$totalImpuestosRetenidos."','".$totalImpuestosTrasladado."','".$nPerTotalGravado."','".$nPerTotalExcento."','".$nDeduTotalGravado."','".$nDeduTotalExcento."','".$nTipoComprobante."','".$origen."','".$descuento."','".$motivoDescuento."')";

			 } else if(strlen($nMetodoDigitos)==3){
                $query_insert_factura="insert into nomi_Facturas (id_emisor,id_nContribuyente,DependenciaEmp,nFormaPago,nMetodoPago,nMetodoDigitos,nFolio,nSerie,nStatus,nVersion,nFechaEmision,nMoneda,nLugaExpedicion,nCantidadLetra,nSubtotal,nTotal,totalImpuestosRetenidos,totalImpuestosTrasladados,nPerTotalGravado,	nPerTotalExcento,nDeduTotalGravado,	nDeduTotalExcento,nTipoComprobante,nOrigenNomina,descuento,motivoDescuento)
			    values ('".$id_emisor."','".$id_nContribuyente."','".$DependenciaEmp."','".$nFormaPago."','".$nMetodoPago."','0".$nMetodoDigitos."','".$nFolio."','".$nSerie."','".$nStatus."','".$nVersion."','".$nFechaEmision."','".$nMoneda."','".$nLugaExpedicion."','".$nCantidadLetra."','".$nSubtotal."','".$nTotal."','".$totalImpuestosRetenidos."','".$totalImpuestosTrasladado."','".$nPerTotalGravado."','".$nPerTotalExcento."','".$nDeduTotalGravado."','".$nDeduTotalExcento."','".$nTipoComprobante."','".$origen."','".$descuento."','".$motivoDescuento."')";

			 } else {
                $query_insert_factura="insert into nomi_Facturas (id_emisor,id_nContribuyente,DependenciaEmp,nFormaPago,nMetodoPago,nMetodoDigitos,nFolio,nSerie,nStatus,nVersion,nFechaEmision,nMoneda,nLugaExpedicion,nCantidadLetra,nSubtotal,nTotal,totalImpuestosRetenidos,totalImpuestosTrasladados,nPerTotalGravado,	nPerTotalExcento,nDeduTotalGravado,	nDeduTotalExcento,nTipoComprobante,nOrigenNomina,descuento,motivoDescuento)
			    values ('".$id_emisor."','".$id_nContribuyente."','".$DependenciaEmp."','".$nFormaPago."','".$nMetodoPago."','".$nMetodoDigitos."','".$nFolio."','".$nSerie."','".$nStatus."','".$nVersion."','".$nFechaEmision."','".$nMoneda."','".$nLugaExpedicion."','".$nCantidadLetra."','".$nSubtotal."','".$nTotal."','".$totalImpuestosRetenidos."','".$totalImpuestosTrasladado."','".$nPerTotalGravado."','".$nPerTotalExcento."','".$nDeduTotalGravado."','".$nDeduTotalExcento."','".$nTipoComprobante."','".$origen."','".$descuento."','".$motivoDescuento."')";
			 }
             //echo $query_insert_factura;
		    $rs_insert_factura=mysql_query($query_insert_factura);
		}
		function insertConceptos($id_nFactura,$nCantidad,$nDescripcion,$nUMedida,$nPUnitario,$noIdentificacion,$nImporte){
			$query_insert_conceptos="insert into nomi_Conceptos (id_nFactura,nCantidad,nDescripcion,nUMedida,nPUnitario,noIdentificacion,nImporte)
			values ('".$id_nFactura."','".$nCantidad."','".$nDescripcion."','".$nUMedida."','".$nPUnitario."','".$noIdentificacion."','".$nImporte."')";
			//echo $query_insert_conceptos;
			$rs_insert_conceptos=mysql_query($query_insert_conceptos);
		}
		function insertDeducciones($id_nFactura,$nTipoDeduccion,$nClave,$nConcepto,$nImporteGravado,$nImporteExcento,$nImporte){
		    if(strlen($nTipoDeduccion)==1){
			    $query_insert_deducciones="insert into nomi_Deducciones (id_nFactura,nTipoDeduccion,nClave,nConcepto,nImporteGravado,nImporteExcento,nImporte)
			    values (".$id_nFactura.",'00".$nTipoDeduccion."','00".$nClave."','".$nConcepto."',".$nImporteGravado.",".$nImporteExcento.",".$nImporte.")";
            }else if(strlen($nTipoDeduccion)==2){
                 $query_insert_deducciones="insert into nomi_Deducciones (id_nFactura,nTipoDeduccion,nClave,nConcepto,nImporteGravado,nImporteExcento,nImporte)
			    values (".$id_nFactura.",'0".$nTipoDeduccion."','0".$nClave."','".$nConcepto."',".$nImporteGravado.",".$nImporteExcento.",".$nImporte.")";
            }
			//echo $query_insert_deducciones;
			$rs_insert_deducciones=mysql_query($query_insert_deducciones);
		}
		function insertPercepciones($id_nFactura,$nTipoPercepcion,$nClave,$nConcepto,$nImporteGravado,$nImporteExcento,$nImporte){
            if(strlen($nTipoPercepcion)==1){
                $query_insert_percepciones="insert into nomi_Percepciones (id_nFactura,nTipoPercepcion,nClave,nConcepto,nImporteGravado,nImporteExcento,nImporte)
			    values (".$id_nFactura.",'00".$nTipoPercepcion."','00".$nClave."','".$nConcepto."',".$nImporteGravado.",".$nImporteExcento.",".$nImporte.")";
            } else if(strlen($nTipoPercepcion)==2){
                $query_insert_percepciones="insert into nomi_Percepciones (id_nFactura,nTipoPercepcion,nClave,nConcepto,nImporteGravado,nImporteExcento,nImporte)
			    values (".$id_nFactura.",'0".$nTipoPercepcion."','0".$nClave."','".$nConcepto."',".$nImporteGravado.",".$nImporteExcento.",".$nImporte.")";
            }
			//echo $query_insert_percepciones;
			$rs_insert_percepciones=mysql_query($query_insert_percepciones);
		}
		function insertImpuestos($id_nFactura,$tasa,$impuesto,$importe){
			$query_insert_impuestos="insert into nomi_Impuestos (id_nFactura,tasa,impuesto,importe)
			values (".$id_nFactura.",".$tasa.",'".$impuesto."',".$importe.")";
			//echo $query_insert_impuestos;
			$rs_insert_impuestos=mysql_query($query_insert_impuestos);
		}
		function getIdEmpleado($fecha_efectiva,$rfc){
			$query_idEmpleado="select id_nContribuyente from nomi_Empleado where nRFC='".$rfc."' and nFechaEfectiva='".$fecha_efectiva."'";
			$rs_idEmpleado=mysql_query($query_idEmpleado);
			$array_idEmpleado=mysql_fetch_assoc($rs_idEmpleado);
			//echo $query_idEmpleado;
			//var_dump($array_idEmpleado);
			//echo $query_idEmpleado;
			return $array_idEmpleado['id_nContribuyente'];
		}
		function getIdFactura($idEmpleado,$fecha_emision){
			$query_idFactura="select id_nFactura from nomi_Facturas where id_nContribuyente='".$idEmpleado."' and nFechaEmision='".$fecha_emision."'";
			$rs_idFactura=mysql_query($query_idFactura);
			$array_idFactura=mysql_fetch_assoc($rs_idFactura);
			//echo $query_idFactura;
			return $array_idFactura['id_nFactura'];
		}
		function queryPercepciones($percepciones,$rfc){
			$objPHPExcel = PHPExcel_IOFactory::load($percepciones);
			$objHoja=$objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			$num_rows=$objPHPExcel->getActiveSheet()->getHighestColumn();
			$per=array(); 
			foreach ($objHoja as $iIndice=>$objCelda) {
				if($rfc==$objCelda[$num_rows]){
					$per[]=$objCelda;
				}
			}
			return $per;
		}
		function queryDeducciones($deducciones,$rfc){
			$objPHPExcel = PHPExcel_IOFactory::load($deducciones);
			$objHoja=$objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			$num_rows=$objPHPExcel->getActiveSheet()->getHighestColumn(); 
			$ded=array(); 
			foreach ($objHoja as $iIndice=>$objCelda) {
				if($rfc==$objCelda[$num_rows]){
					$ded[]=$objCelda;
				}
			}
			return $ded;
		}
		function queryConceptos($conceptos,$rfc){
			$objPHPExcel = PHPExcel_IOFactory::load($conceptos);
			$objHoja=$objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			$num_rows=$objPHPExcel->getActiveSheet()->getHighestColumn();
			$con=array(); 
			foreach ($objHoja as $iIndice=>$objCelda) {
				if($rfc==$objCelda[$num_rows]){
					$con[]=$objCelda;
				}
			}
			return $con; 
		}
		function queryComplemento($complemento,$rfc){
			$objPHPExcel = PHPExcel_IOFactory::load($complemento);
			$objHoja=$objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			$num_rows=$objPHPExcel->getActiveSheet()->getHighestColumn();
			$com=array(); 
			foreach ($objHoja as $iIndice=>$objCelda) {
				if($rfc==$objCelda[$num_rows]){
					$com[]=$objCelda;
				}
			}
			return $com; 
		}
		function queryFactura($factura,$rfc){
			$objPHPExcel = PHPExcel_IOFactory::load($factura);
			$objHoja=$objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			$num_rows=$objPHPExcel->getActiveSheet()->getHighestColumn();
			$fac=array(); 
			foreach ($objHoja as $iIndice=>$objCelda) {
				if($rfc==$objCelda[$num_rows]){
					$fac[]=$objCelda;
				}
			}
			return $fac; 
		}

		function queryImpuestos($impuestos,$rfc){
			$objPHPExcel = PHPExcel_IOFactory::load($impuestos);
			$objHoja=$objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			$num_rows=$objPHPExcel->getActiveSheet()->getHighestColumn();
			$imp=array();
			foreach ($objHoja as $iIndice=>$objCelda) {
				if($rfc==$objCelda[$num_rows]){
					$imp[]=$objCelda;
				}
			}
			return $imp;
		}
        function verificaDate($date){
            $dateValida = explode('/',$date);
            $dia=$dateValida[0]; $mes=$dateValida[1]; $anio=$dateValida[2];
			//$valor=checkdate (int $mes ,int $dia ,int $anio );
            //echo   $dia, $mes, $anio;
            if((checkdate($mes,$dia,$anio))==false){
               return 0;// echo "no valida";
            }else{
               return 1;// echo "valida";
            }

		}

			function cantidadLetra($num, $fem = false, $dec = true){
			$arr=explode('.',$num);
			$matuni[2] = "dos";
			$matuni[3] = "tres";
			$matuni[4] = "cuatro";
			$matuni[5] = "cinco";
			$matuni[6] = "seis";
			$matuni[7] = "siete";
			$matuni[8] = "ocho";
			$matuni[9] = "nueve";
			$matuni[10] = "diez";
			$matuni[11] = "once";
			$matuni[12] = "doce";
			$matuni[13] = "trece";
			$matuni[14] = "catorce";
			$matuni[15] = "quince";
			$matuni[16] = "dieciséis";
			$matuni[17] = "diecisiete";
			$matuni[18] = "dieciocho";
			$matuni[19] = "diecinueve";
			$matuni[20] = "veinte";
			$matunisub[2] = "dos";
			$matunisub[3] = "tres";
			$matunisub[4] = "cuatro";
			$matunisub[5] = "quin";
			$matunisub[6] = "seis";
			$matunisub[7] = "sete";
			$matunisub[8] = "ocho";
			$matunisub[9] = "nove";
	
			$matdec[2] = "veint";
			$matdec[3] = "treinta";
			$matdec[4] = "cuarenta";
			$matdec[5] = "cincuenta";
			$matdec[6] = "sesenta";
			$matdec[7] = "setenta";
			$matdec[8] = "ochenta";
			$matdec[9] = "noventa";
			$matsub[3] = 'mill';
			$matsub[5] = 'bill';
			$matsub[7] = 'mill';
			$matsub[9] = 'trill';
			$matsub[11] = 'mill';
			$matsub[13] = 'bill';
			$matsub[15] = 'mill';
			$matmil[4] = 'millones';
			$matmil[6] = 'billones';
			$matmil[7] = 'de billones';
			$matmil[8] = 'millones de billones';
			$matmil[10] = 'trillones';
			$matmil[11] = 'de trillones';
			$matmil[12] = 'millones de trillones';
			$matmil[13] = 'de trillones';
			$matmil[14] = 'billones de trillones';
			$matmil[15] = 'de billones de trillones';
			$matmil[16] = 'millones de billones de trillones';
	
			//Zi hack
			$float = explode('.', $num);
			$num = $float[0];
	
			$num = trim((string)@$num);
			if ($num[0] == '-')
			{
				$neg = 'menos ';
				$num = substr($num, 1);
			}
			else
				$neg = '';
			while ($num[0] == '0')
				$num = substr($num, 1);
			if ($num[0] < '1' or $num[0] > 9)
				$num = '0' . $num;
			$zeros = true;
			$punt = false;
			$ent = '';
			$fra = '';
			for ($c = 0; $c < strlen($num); $c++)
			{
				$n = $num[$c];
				if (!(strpos(".,'''", $n) === false))
				{
					if ($punt)
						break;
					else
					{
						$punt = true;
						continue;
					}
	
				}
				elseif (!(strpos('0123456789', $n) === false))
				{
					if ($punt)
					{
						if ($n != '0')
							$zeros = false;
						$fra .= $n;
					}
					else
	
						$ent .= $n;
				}
				else
	
					break;
	
			}
			$ent = '     ' . $ent;
			if ($dec and $fra and !$zeros)
			{
				$fin = ' coma';
				for ($n = 0; $n < strlen($fra); $n++)
				{
					if (($s = $fra[$n]) == '0')
						$fin .= ' cero';
					elseif ($s == '1')
					$fin .= $fem ? ' una' : ' un';
					else
						$fin .= ' ' . $matuni[$s];
				}
			}
			else
				$fin = '';
			if ((int)$ent === 0)
				return 'Cero ' . $fin;
			$tex = '';
			$sub = 0;
			$mils = 0;
			$neutro = false;
			while (($num = substr($ent, -3)) != '   ')
			{
				$ent = substr($ent, 0, -3);
				if (++$sub < 3 and $fem)
				{
					$matuni[1] = 'una';
					$subcent = 'as';
				}
				else
				{
					$matuni[1] = $neutro ? 'un' : 'uno';
					$subcent = 'os';
				}
				$t = '';
				$n2 = substr($num, 1);
				if ($n2 == '00')
				{
				}
				elseif ($n2 < 21)
				$t = ' ' . $matuni[(int)$n2];
				elseif ($n2 < 30)
				{
					$n3 = $num[2];
					if ($n3 != 0)
						$t = 'i' . $matuni[$n3];
					$n2 = $num[1];
					$t = ' ' . $matdec[$n2] . $t;
				}
				else
				{
					$n3 = $num[2];
					if ($n3 != 0)
						$t = ' y ' . $matuni[$n3];
					$n2 = $num[1];
					$t = ' ' . $matdec[$n2] . $t;
				}
				$n = $num[0];
				if ($n == 1)
				{
					$t = ' ciento' . $t;
				}
				elseif ($n == 5)
				{
					$t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t;
				}
				elseif ($n != 0)
				{
					$t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t;
				}
				if ($sub == 1)
				{
				}
				elseif (!isset($matsub[$sub]))
				{
					if ($num == 1)
					{
						$t = ' mil';
					}
					elseif ($num > 1)
					{
						$t .= ' mil';
					}
				}
				elseif ($num == 1)
				{
					$t .= ' ' . $matsub[$sub] . '?n';
				}
				elseif ($num > 1)
				{
					$t .= ' ' . $matsub[$sub] . 'ones';
				}
				if ($num == '000')
					$mils++;
				elseif ($mils != 0)
				{
					if (isset($matmil[$sub]))
						$t .= ' ' . $matmil[$sub];
					$mils = 0;
				}
				$neutro = true;
				$tex = $t . $tex;
			}
			$tex = $neg . substr($tex, 1) . $fin;
			//Zi hack --> return ucfirst($tex);
			$decimales=(count($arr)==2)?$arr[1]:00;
			return strtoupper($tex)." ".str_pad($decimales,2,0,STR_PAD_RIGHT)."/100 M.N.";
			//return $end_num;
		}
	}

?>
