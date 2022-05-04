<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
$session_id= session_id();
	require_once ("../config/db.php");
    require_once ("../config/conexion.php");
	include("../funciones.php");
	if (!empty($_POST['id_cliente']) and !empty($_POST['id_bus']))
	{	
		$codigo=mysqli_real_escape_string($con,(strip_tags($_POST['codigo'],ENT_QUOTES)));
		$Didentidad=mysqli_real_escape_string($con,(strip_tags($_POST['Didentidad'],ENT_QUOTES)));
		$id_cliente=mysqli_real_escape_string($con,(strip_tags($_POST['id_cliente'],ENT_QUOTES)));
		$id_bus=mysqli_real_escape_string($con,(strip_tags($_POST['id_bus'],ENT_QUOTES)));
		$tipdoc=mysqli_real_escape_string($con,(strip_tags($_POST['tipdoc'],ENT_QUOTES)));
		$id_sucu_llegada=mysqli_real_escape_string($con,(strip_tags($_POST['id_sucu_llegada'],ENT_QUOTES)));
		$fecha=date("Y/m/d", strtotime(mysqli_real_escape_string($con,(strip_tags($_POST['fecha'],ENT_QUOTES)))));
		$idsucupartida= $_SESSION['idsucursal'];
		$usuario =$_SESSION['user_id'];
        $consignatario=mysqli_real_escape_string($con,(strip_tags($_POST['consignatario'],ENT_QUOTES)));
        $celular=mysqli_real_escape_string($con,(strip_tags($_POST['celular'],ENT_QUOTES)));
        $dni=mysqli_real_escape_string($con,(strip_tags($_POST['dni'],ENT_QUOTES)));
        $delivery=mysqli_real_escape_string($con,(strip_tags($_POST['delivery'],ENT_QUOTES)));
        $direccion_delivery=mysqli_real_escape_string($con,(strip_tags($_POST['direccion_delivery'],ENT_QUOTES)));
         $conductor=mysqli_real_escape_string($con,(strip_tags($_POST['conductor'],ENT_QUOTES)));
         $encargado=mysqli_real_escape_string($con,(strip_tags($_POST['id_encargado'],ENT_QUOTES)));
         print_r('Entro aqui');


		$subtotalcab=mysqli_real_escape_string($con,(strip_tags($_POST['subtotal'],ENT_QUOTES)));
		$igvcab=mysqli_real_escape_string($con,(strip_tags($_POST['igv'],ENT_QUOTES)));
		$totalcab=mysqli_real_escape_string($con,(strip_tags($_POST['total'],ENT_QUOTES)));
		$preciotexto=mysqli_real_escape_string($con,(strip_tags($_POST['subtotal'],ENT_QUOTES)));

		/*encomienda*/
		$sqlencocab = "INSERT INTO tb_encomienda_cab (id_cliente,id_usuario,id_bus, id_sucursal_partida, id_sucursal_llegada, situacion, id_usuario_creador, fecha_creado, id_usuario_modificador, fecha_modificado, codigo, tipdoc, id_consignatario,celular,dni,delivery,direccion_delivery,conductor,id_encargado) VALUES ($id_cliente,$usuario, $id_bus, $idsucupartida, $id_sucu_llegada, '1', $usuario, '$fecha', $usuario, '$fecha', '$codigo', $tipdoc, '$consignatario','$celular','$dni','$delivery','$direccion_delivery','$conductor','$encargado')";
		$insert_encocab=mysqli_query($con, $sqlencocab);



		$count_encocab   = mysqli_query($con, "SELECT id_encomienda FROM tb_encomienda_cab WHERE codigo = '".$codigo."'");
		$rowencocab= mysqli_fetch_array($count_encocab);
		$id_encomienda = $rowencocab['id_encomienda'];

		$sqlencodet = "UPDATE tb_encomienda_det SET id_encomienda = $id_encomienda WHERE codigo = '".$codigo."'";
		$insert_encodet=mysqli_query($con, $sqlencodet);

		/*-------------------------------------*/


		/*Facturacion*/

		$querysucursal   = mysqli_query($con, "SELECT * FROM tb_sucursales where id_sucursal = $idsucupartida ");
		$fetchsucursal= mysqli_fetch_array($querysucursal);

		$qureryfac   = mysqli_query($con, "SELECT count(*) filas FROM tb_facturacion_cab WHERE id_tipo in (2) and id_sucursal = $idsucupartida and id_tipo_documento= $tipdoc");
		$fetchfac= mysqli_fetch_array($qureryfac);
		$filas = ($fetchfac['filas'] == 0) ? 1 : $fetchfac['filas'] + 1;

		$doct = ($tipdoc==1) ? "01" : "03" ;		
		$serie = ($tipdoc==1) ? $fetchsucursal['serie_factura'] : $fetchsucursal['serie_boleta']  ;

		$ndocumento = $serie."-".str_pad($filas, 8, "0", STR_PAD_LEFT);


		 $subtotalcab = str_replace(",", "", $subtotalcab);
          $igvcab = str_replace(",", "", $igvcab);
           $totalcab = str_replace(",", "", $totalcab);
            $preciotexto = str_replace(",", "", $preciotexto);

		$sqlfac = "INSERT INTO tb_facturacion_cab (id_sucursal, id_tipo_documento, n_documento, id_cliente, valor_total, igv_total, precio_total, id_usuario_creador, fecha_creado , id_usuario_modificador, fecha_modificado, id_moneda, id_bus, precio_texto, fecha_envio, codigo, id_sucursal_llegada, id_tipo) VALUES ('$idsucupartida','$tipdoc','$ndocumento','$id_cliente', '$subtotalcab', '$igvcab', '$totalcab', '$usuario', '$fecha', '1', '$fecha', '1','$id_bus', '$preciotexto', '$fecha', '$codigo', $id_sucu_llegada, 2)";
		$insert_tmp=mysqli_query($con, $sqlfac);

		$count_query   = mysqli_query($con, "SELECT id_facturacion FROM tb_facturacion_cab ORDER BY id_facturacion DESC limit 1");
		$row= mysqli_fetch_array($count_query);
		$idfactura = $row['id_facturacion'];

		$sqldetencomienda=mysqli_query($con, "select * from tb_encomienda_det where tb_encomienda_det.codigo='".$codigo."'");

		$P = "|";

		$nombre_archivo= "20601621241-".$doct."-".$serie."-".str_pad($filas, 8, "0", STR_PAD_LEFT);
		$ruta_servidor = "C:\SFS_v1.3.4.2\sunat_archivos\sfs\DATA\\";

		$ruta_archivo['info'][1]['ruta'] =$ruta_servidor.$nombre_archivo.".det";
		$ruta_archivo['info'][1]['data'] = "";


        while ($row=mysqli_fetch_array($sqldetencomienda))
        {   
            $desc=$row['producto'];
            $cantidad=$row['cantidad'];

            if ($tipdoc == 1) {

                $subtotal = number_format($row['precio'],2,'.','');
                $igv = (($subtotal * 18 ) / 100) * $cantidad;
                $igv = number_format($igv,2,'.','');
                $total = number_format($row['precio'],2,'.','');

                $subtotalparafe=number_format($row['precio'],2,'.','');
                $codigodigito = "1000";
                $textoigv = "IGV";
                $codigoigv = "10";
                $vat = "VAT";
            }else{
                $subtotal = number_format($row['precio'],2,'.','');
                $igv = (($subtotal * 18 ) / 100) * $cantidad;
                $igv = number_format($igv,2,'.','');
                $total = number_format($row['precio'],2,'.','');
                $subtotalparafe=number_format($row['precio'],2,'.','');
                $codigodigito = "9998";
                $textoigv = "INA";
                $codigoigv = "30";
                $vat = "FRE";
            }
			

			$sqldet = "INSERT INTO tb_facturacion_det (id_facturacion, cantidad, id_categoria, id_producto, precio_unitario, igv_total, precio_total, descripccion) VALUES ('$idfactura','$cantidad','1','1', $subtotal, $igv, $total, '$desc')";
            //print_r($sqldet);die();
			$insert_sqldet = mysqli_query($con, $sqldet);


			$ruta_archivo['info'][1]['data'] .=
	            "NIU".$P. //Unidad de medida
	            $row['cantidad'].$P. // Cantidad
	            "cod01".$P. // Codigo Producto 
	            "-".$P. // Codigo Producto Sunat --
	            trim($row['descripcion']).$P. // Descripcion
	            $subtotalparafe.$P. // Valor Unitario (Sin IGV) pero multiplicado por la cantidad
	            $igv.$P. // Sumatorio Tributo  9+16+26
	            $codigodigito.$P. //Codigo Tipo Triburo Catalogo N° 5
	            $igv.$P. // Monto Total IGV por item 
	            $subtotalparafe.$P. // Tributo: Base Imponible IGV por Item
	            $textoigv.$P. // Nombre Tributo Catalogo N° 5
	            $vat.$P. // Codigo Tributo Catalogo N° 5
	            $codigoigv.$P. // Catalogo N° 7 
	            "18".$P. // 
	            "-".$P. // Codigo Tipo ISC Catalogo N° 5 (si no es afecto "-") y valores vacios
	            "".$P. // Monto de ISC por ítem
	            "".$P. // Monto de ISC por ítem
	            "".$P. // Nombre de tributo por item Catalogo N° 5
	            "".$P. // Código de tipo de tributo por Item Catalogo N° 5
	            "".$P. // Tipo de sistema ISC Catalogo N° 8
	            "".$P. // Porcentaje de ISC por Item (normalmente 15.00)
	            "-".$P. // Codigo Tipo Otros Catalogo N° 5 (si no es afecto "-") y valores vacios
	            "".$P. // Monto de tributo OTRO por iItem
	            "".$P. // Base Imponible de tributo OTRO por Item
	            "".$P. // Nombre de tributo OTRO por item Catalogo N° 5
	            "".$P. // Código de tipo de tributo OTRO por Item Catalogo N° 5
	            "".$P. // Porcentaje de tributo OTRO por Item (normalmente 15.00)

                "-".$P. // ICBPER
                "".$P. // ICBPER
                "".$P. // ICBPER
                "".$P. // ICBPER
                "".$P. // ICBPER
                "".$P. // ICBPER
	            $totalcab.$P. // Precio unitario (incluye IGV-ISC-OTROS)
	            $subtotalparafe.$P.//number_format($total,2,'.','').$P. // Precio unitario por item * Cantidad (sin igv)
	            "0.00".$P."\n"; //Valor REFERENCIAL unitario (gratuitos)

		}

		
		
		/*-------------------------------------*/


		

        $querycliente   = mysqli_query($con, "SELECT * FROM tb_cliente where id_cliente = $id_cliente ");
		$fetchcliente= mysqli_fetch_array($querycliente);

        $ruta_archivo['info'][0]['ruta'] =$ruta_servidor.$nombre_archivo.".cab";
        $ruta_archivo['info'][0]['data'] = 
            "0101".$P. //tipo operacion Catalogo N° 51
            date("Y-m-d").$P. //Fecha de emision
            date("H:m:s").$P. //Hora de emision
            "-".$P. //Fecha de vencimiento (no obligatorio "-")
            $fetchsucursal['cod_direccion_fiscal'].$P. //codigo de domicilioFiscal
            $fetchcliente['id_tipo_documento_identidad'].$P. //Tipo documento Identidad Catalogo N° 6
            $fetchcliente['n_documento_identidad'].$P. // Numero de documento
            $fetchcliente['nombre_cliente'].$P. // Nombre de usuario
            "PEN".$P. // Tipo moneda Catalogo N° 2  
            $igvcab.$P. //Sumatoria de tributo
            $subtotalcab.$P. // Total Valor Venta (total sin igv)
            $totalcab.$P. //TOTAL (incluye IGV) 
            "0.00".$P. // Total descuentos
            "0".$P. // Sumatoria otros Cargos
            "0".$P. // Total Anticipos
            $totalcab.$P. //TOTAL - descuento + Otros cargos - Anticipos
            "2.1".$P. // Version UBL
            "2.0".$P; // Customization

$resultado = str_replace(",", "", $totalcab);

        $ruta_archivo['info'][2]['ruta'] =$ruta_servidor.$nombre_archivo.".ley";
        $ruta_archivo['info'][2]['data'] = 
            "1000".$P. //Código de leyenda
            numtoletras(number_format($resultado,2,'.','')).$P; //Descripcion de leyenda

        if ($tipdoc == 1) {
            $ruta_archivo['info'][3]['ruta'] =$ruta_servidor.$nombre_archivo.".tri";
            $ruta_archivo['info'][3]['data'] =
            "1000".$P. // Identificador de Tributo Catalogo N° 5
            "IGV".$P. // Nombre de tributo Catalogo N° 5
            "VAT".$P. // Codigo de Tributo Catalogo N°5
            $subtotalcab.$P. // Base Inponible
            $igvcab.$P;// Monto Tributo por Item;
        }else{
            $ruta_archivo['info'][3]['ruta'] =$ruta_servidor.$nombre_archivo.".tri";
            $ruta_archivo['info'][3]['data'] =
            "9998".$P. // Identificador de Tributo Catalogo N° 5
            "INA".$P. // Nombre de tributo Catalogo N° 5
            "FRE".$P. // Codigo de Tributo Catalogo N°5
            $subtotalcab.$P. // Base Inponible
            "0".$P;// Monto Tributo por Item;
        }
            
      

        foreach ($ruta_archivo['info'] as $key => $value) {
            if($archivo = fopen($value['ruta'] , "w+")) //a
            {   
                fwrite($archivo,"");
                if(fwrite($archivo, $value['data']))
                {
                    $respo = true;
                }
                else
                {
                    $respo =false;
                    break;
                }
                fclose($archivo);
            }  
        }


		if ($respo){
			echo $id_encomienda."-El documento fue creada correctamente";
		} else{
			echo "0-Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
		}

	}




function numtoletras($xcifra)
    {
        $xarray = array(0 => "Cero",
            1 => "UN", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE",
            "DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE",
            "VEINTI", 30 => "TREINTA", 40 => "CUARENTA", 50 => "CINCUENTA", 60 => "SESENTA", 70 => "SETENTA", 80 => "OCHENTA", 90 => "NOVENTA",
            100 => "CIENTO", 200 => "DOSCIENTOS", 300 => "TRESCIENTOS", 400 => "CUATROCIENTOS", 500 => "QUINIENTOS", 600 => "SEISCIENTOS", 700 => "SETECIENTOS", 800 => "OCHOCIENTOS", 900 => "NOVECIENTOS"
        );
        $xcifra = trim($xcifra);
        $xlength = strlen($xcifra);
        $xpos_punto = strpos($xcifra, ".");
        $xaux_int = $xcifra;
        $xdecimales = "00";
        if (!($xpos_punto === false)) {
            if ($xpos_punto == 0) {
                $xcifra = "0" . $xcifra;
                $xpos_punto = strpos($xcifra, ".");
            }
            $xaux_int = substr($xcifra, 0, $xpos_punto); // obtengo el entero de la cifra a covertir
            $xdecimales = substr($xcifra . "00", $xpos_punto + 1, 2); // obtengo los valores decimales
        }
        $XAUX = str_pad($xaux_int, 18, " ", STR_PAD_LEFT); // ajusto la longitud de la cifra, para que sea divisible por centenas de miles (grupos de 6)
        $xcadena = "";
        for ($xz = 0; $xz < 3; $xz++) {
            $xaux = substr($XAUX, $xz * 6, 6);
            $xi = 0;
            $xlimite = 6; // inicializo el contador de centenas xi y establezco el límite a 6 dígitos en la parte entera
            $xexit = true; // bandera para controlar el ciclo del While
            while ($xexit) {
                if ($xi == $xlimite) { // si ya llegó al límite máximo de enteros
                    break; // termina el ciclo
                }
                $x3digitos = ($xlimite - $xi) * -1; // comienzo con los tres primeros digitos de la cifra, comenzando por la izquierda
                $xaux = substr($xaux, $x3digitos, abs($x3digitos)); // obtengo la centena (los tres dígitos)
                for ($xy = 1; $xy < 4; $xy++) { // ciclo para revisar centenas, decenas y unidades, en ese orden
                    switch ($xy) {
                        case 1: // checa las centenas
                            if (substr($xaux, 0, 3) < 100) { // si el grupo de tres dígitos es menor a una centena ( < 99) no hace nada y pasa a revisar las decenas
                                
                            } else {
                                $key = (int) substr($xaux, 0, 3);
                                if (TRUE === array_key_exists($key, $xarray)){  // busco si la centena es número redondo (100, 200, 300, 400, etc..)
                                    $xseek = $xarray[$key];
                                    $xsub = subfijo($xaux); // devuelve el subfijo correspondiente (Millón, Millones, Mil o nada)
                                    if (substr($xaux, 0, 3) == 100)
                                        $xcadena = " " . $xcadena . " CIEN " . $xsub;
                                    else
                                        $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                    $xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades
                                }
                                else { // entra aquí si la centena no fue numero redondo (101, 253, 120, 980, etc.)
                                    $key = (int) substr($xaux, 0, 1) * 100;
                                    $xseek = $xarray[$key]; // toma el primer caracter de la centena y lo multiplica por cien y lo busca en el arreglo (para que busque 100,200,300, etc)
                                    $xcadena = " " . $xcadena . " " . $xseek;
                                } // ENDIF ($xseek)
                            } // ENDIF (substr($xaux, 0, 3) < 100)
                            break;
                        case 2: // checa las decenas (con la misma lógica que las centenas)
                            if (substr($xaux, 1, 2) < 10) {
                                
                            } else {
                                $key = (int) substr($xaux, 1, 2);
                                if (TRUE === array_key_exists($key, $xarray)) {
                                    $xseek = $xarray[$key];
                                    $xsub = subfijo($xaux);
                                    if (substr($xaux, 1, 2) == 20)
                                        $xcadena = " " . $xcadena . " VEINTE " . $xsub;
                                    else
                                        $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                    $xy = 3;
                                }
                                else {
                                    $key = (int) substr($xaux, 1, 1) * 10;
                                    $xseek = $xarray[$key];
                                    if (20 == substr($xaux, 1, 1) * 10)
                                        $xcadena = " " . $xcadena . " " . $xseek;
                                    else
                                        $xcadena = " " . $xcadena . " " . $xseek . " Y ";
                                } // ENDIF ($xseek)
                            } // ENDIF (substr($xaux, 1, 2) < 10)
                            break;
                        case 3: // checa las unidades
                            if (substr($xaux, 2, 1) < 1) { // si la unidad es cero, ya no hace nada
                                
                            } else {
                                $key = (int) substr($xaux, 2, 1);
                                $xseek = $xarray[$key]; // obtengo directamente el valor de la unidad (del uno al nueve)
                                $xsub = subfijo($xaux);
                                $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                            } // ENDIF (substr($xaux, 2, 1) < 1)
                            break;
                    } // END SWITCH
                } // END FOR
                $xi = $xi + 3;
            } // ENDDO
            if (substr(trim($xcadena), -5, 5) == "ILLON") // si la cadena obtenida termina en MILLON o BILLON, entonces le agrega al final la conjuncion DE
                $xcadena.= " DE";
            if (substr(trim($xcadena), -7, 7) == "ILLONES") // si la cadena obtenida en MILLONES o BILLONES, entoncea le agrega al final la conjuncion DE
                $xcadena.= " DE";
            // ----------- esta línea la puedes cambiar de acuerdo a tus necesidades o a tu país -------
            if (trim($xaux) != "") {
                switch ($xz) {
                    case 0:
                        if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                            $xcadena.= "UN BILLON ";
                        else
                            $xcadena.= " BILLONES ";
                        break;
                    case 1:
                        if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                            $xcadena.= "UN MILLON ";
                        else
                            $xcadena.= " MILLONES ";
                        break;
                    case 2:
                        if ($xcifra < 1) {
                            $xcadena = "CERO CON $xdecimales/100 SOLES";
                        }
                        if ($xcifra >= 1 && $xcifra < 2) {
                            $xcadena = "UNO CON $xdecimales/100 SOLES";
                        }
                        if ($xcifra >= 2) {
                            $xcadena.= "CON $xdecimales/100 SOLES"; //
                        }
                        break;
                } // endswitch ($xz)
            } // ENDIF (trim($xaux) != "")
            // ------------------      en este caso, para México se usa esta leyenda     ----------------
            $xcadena = str_replace("VEINTI ", "VEINTI", $xcadena); // quito el espacio para el VEINTI, para que quede: VEINTICUATRO, VEINTIUN, VEINTIDOS, etc
            $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
            $xcadena = str_replace("UN UN", "UN", $xcadena); // quito la duplicidad
            $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
            $xcadena = str_replace("BILLON DE MILLONES", "BILLON DE", $xcadena); // corrigo la leyenda
            $xcadena = str_replace("BILLONES DE MILLONES", "BILLONES DE", $xcadena); // corrigo la leyenda
            $xcadena = str_replace("DE UN", "UN", $xcadena); // corrigo la leyenda
        } // ENDFOR ($xz)
        return trim($xcadena);
    }

    function subfijo($xx)
    { // esta función regresa un subfijo para la cifra
        $xx = trim($xx);
        $xstrlen = strlen($xx);
        if ($xstrlen == 1 || $xstrlen == 2 || $xstrlen == 3)
            $xsub = "";
        //
        if ($xstrlen == 4 || $xstrlen == 5 || $xstrlen == 6)
            $xsub = "MIL";
        //
        return $xsub;
    }