<?php
//include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
$session_id= session_id();

    /* Connect To Database
   /* require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
    require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
    //Archivo de funciones PHP
    include("../funciones.php");
    //session_start();

    if (!empty($_POST['id_cliente']) and !empty($_POST['id_bus']) and !empty($_POST['n_documento']))
    {   
        //$fecha = date("Y-m-d H:i:s");

        $sucursal=mysqli_real_escape_string($con,(strip_tags($_SESSION['idsucursal'],ENT_QUOTES)));
        $ndocumento=mysqli_real_escape_string($con,(strip_tags($_POST['n_documento'],ENT_QUOTES)));
        $cliente=mysqli_real_escape_string($con,(strip_tags($_POST['id_cliente'],ENT_QUOTES)));
        $usuario=mysqli_real_escape_string($con,(strip_tags($_SESSION['user_id'],ENT_QUOTES)));
        $tipdoc=mysqli_real_escape_string($con,(strip_tags($_POST['id_tipo_documento'],ENT_QUOTES)));
        $subtotal=mysqli_real_escape_string($con,(strip_tags($_POST['subtotal'],ENT_QUOTES)));
        $igv=mysqli_real_escape_string($con,(strip_tags($_POST['igv'],ENT_QUOTES)));
        $total=mysqli_real_escape_string($con,(strip_tags($_POST['total'],ENT_QUOTES)));
        $id_bus=mysqli_real_escape_string($con,(strip_tags($_POST['id_bus'],ENT_QUOTES)));
        $desc=mysqli_real_escape_string($con,(strip_tags($_POST['desc'],ENT_QUOTES)));
        $preciotexto=number_format(mysqli_real_escape_string($con,(strip_tags($_POST['preciotexto'],ENT_QUOTES))), 2, '.', ' ');
        $fecha=date("Y/m/d H:i:s", strtotime(mysqli_real_escape_string($con,(strip_tags($_POST['fecha'],ENT_QUOTES)))));
        $asiento=mysqli_real_escape_string($con,(strip_tags($_POST['asiento'],ENT_QUOTES)));
        $piso=mysqli_real_escape_string($con,(strip_tags($_POST['piso'],ENT_QUOTES)));
        $fenvio=date("Y/m/d H:i:s", strtotime(mysqli_real_escape_string($con,(strip_tags($_POST['fenvio'],ENT_QUOTES)))));
        $sucursales=mysqli_real_escape_string($con,(strip_tags($_POST['id_sucu_llegada'],ENT_QUOTES)));
        //$consignatario=mysqli_real_escape_string($con,(strip_tags($_POST['consignatario'],ENT_QUOTES)));
        //$id_pasajero=mysqli_real_escape_string($con,(strip_tags($_POST['id_pasajero'],ENT_QUOTES)));

        if (empty($_POST['id_pasajero'])) {
            $id_pasajero = 0;
        }
        else {
            $id_pasajero=mysqli_real_escape_string($con,(strip_tags($_POST['id_pasajero'],ENT_QUOTES)));
        }

        /*$tipdoc=intval($_SESSION['id_tipo_documento']);
        $subtotal=intval($_SESSION['subtotal']);
        $igv=intval($_SESSION['igv']);
        $total=intval($_SESSION['total']);

        //print_r($tipdoc);die();
        try {
            // Iniciar transaccion
            mysqli_autocommit($con, FALSE);

            // insertando en la cabecera de facturacion
            $sql = "INSERT INTO tb_facturacion_cab (id_sucursal, id_tipo_documento, n_documento, id_cliente, valor_total, igv_total, precio_total, id_usuario_creador, fecha_creado , id_usuario_modificador, fecha_modificado, id_moneda, id_bus, precio_texto, fecha_envio, id_sucursal_llegada, id_tipo, id_pasajero) VALUES ('$sucursal','$tipdoc','$ndocumento','$cliente', $subtotal, $igv, $total, '$usuario', '$fecha', '1', '$fecha', '1','$id_bus', $preciotexto, '$fenvio', '$sucursales', 1, '$id_pasajero')";

            if (mysqli_query($con,$sql)) {
                $idfactura = mysqli_insert_id($con);

                // insertando en la cabecera de facturacion
                $sqldet = "INSERT INTO tb_facturacion_det (id_facturacion, cantidad, id_categoria, id_producto, precio_unitario, igv_total, precio_total, descripccion) VALUES ('$idfactura','1','1','1', $subtotal, $igv, $total, '$desc')";

                if (mysqli_query($con, $sqldet)){
                    
                    // obtener el id_buses_det 
                    $count_queryasiento = mysqli_query($con, "SELECT id_buses_det FROM tb_buses_det where id_bus = $id_bus and piso = $piso and asiento =$asiento");
                    $rowasiento = mysqli_fetch_array($count_queryasiento, MYSQLI_ASSOC);
                    $idbusdet = $rowasiento['id_buses_det'];

                    // insertar en control de asientos
                    $sqlasiento = "INSERT INTO tb_control_asientos (id_bus, id_bus_det, estado, estado_general, fecha) VALUES ('$id_bus','$idbusdet','2','1', '$fenvio')";          
                    if (mysqli_query($con, $sqlasiento)) {
                        
                        /*Facturacion electronica
                        $P = "|";

                        $querysucursal = mysqli_query($con, "SELECT * FROM tb_sucursales where id_sucursal = $sucursal ");
                        $fetchsucursal = mysqli_fetch_array($querysucursal, MYSQLI_ASSOC);

                        $qureryfac = mysqli_query($con, "SELECT count(*) filas FROM tb_facturacion_cab WHERE id_tipo in (3,1) and id_sucursal = $sucursal and id_tipo_documento= $tipdoc");
                        $fetchfac = mysqli_fetch_array($qureryfac, MYSQLI_ASSOC);
                        $filas = ($fetchfac['filas'] == 0) ? 1 : $fetchfac['filas'];

                        $doct = ($tipdoc==1) ? "01" : "03" ;        
                        $serie = ($tipdoc==1) ? $fetchsucursal['serie_factura_viaje'] : $fetchsucursal['serie_boleta_viaje']  ;


                        $nombre_archivo= "20601621241-".$doct."-".$serie."-".str_pad($filas, 8, "0", STR_PAD_LEFT);
                        $ruta_servidor = "C:\SFS_v1.3.4.2\sunat_archivos\sfs\DATA\\";

                        $ruta_archivo['info'][1]['ruta'] =$ruta_servidor.$nombre_archivo.".det";
                        $ruta_archivo['info'][1]['data'] =
                            "ZZ".$P. //Unidad de medida
                            "1".$P. // Cantidad
                            "cod01".$P. // Codigo Producto 
                            "-".$P. // Codigo Producto Sunat --
                            "Piso # ".$piso." Asiento # ".$asiento." ".$P. // Descripcion
                            $preciotexto.$P. // Valor Unitario (Sin IGV) pero multiplicado por la cantidad
                            "0.00".$P. // Sumatorio Tributo  9+16+26
                            "9997".$P. //Codigo Tipo Triburo Catalogo N° 5
                            "0.00".$P. // Monto Total IGV por item 
                            $preciotexto.$P. // Tributo: Base Imponible IGV por Item
                            "EXO".$P. // Nombre Tributo Catalogo N° 5
                            "VAT".$P. // Codigo Tributo Catalogo N° 5
                            "20".$P. // Catalogo N° 7 
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
                            $preciotexto.$P. // Precio unitario (incluye IGV-ISC-OTROS)
                            $preciotexto.$P.//number_format($total,2,'.','').$P. // Precio unitario por item * Cantidad (sin igv)
                            "0.00".$P; //Valor REFERENCIAL unitario (gratuitos)

                        $querycliente = mysqli_query($con, "SELECT * FROM tb_cliente where id_cliente = $cliente ");
                        $fetchcliente = mysqli_fetch_array($querycliente, MYSQLI_ASSOC);

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
                            "0.00".$P. //Sumatoria de tributo
                            $preciotexto.$P. // Total Valor Venta (total sin igv)
                            $preciotexto.$P. //TOTAL (incluye IGV) 
                            "0.00".$P. // Total descuentos
                            "0".$P. // Sumatoria otros Cargos
                            "0".$P. // Total Anticipos
                            $preciotexto.$P. //TOTAL - descuento + Otros cargos - Anticipos
                            "2.1".$P. // Version UBL
                            "2.0".$P; // Customization


                        $ruta_archivo['info'][2]['ruta'] = $ruta_servidor.$nombre_archivo.".ley";
                        $ruta_archivo['info'][2]['data'] = "1000".$P. /*Código de leyenda numtoletras(number_format($preciotexto ,2,'.','')).$P; //Descripcion de leyenda
                            
                        $ruta_archivo['info'][3]['ruta'] = $ruta_servidor.$nombre_archivo.".tri";
                        $ruta_archivo['info'][3]['data'] =
                            "9997".$P. // Identificador de Tributo Catalogo N° 5
                            "EXO".$P. // Nombre de tributo Catalogo N° 5
                            "VAT".$P. // Codigo de Tributo Catalogo N°5
                            $preciotexto.$P. // Base Inponible
                            "0".$P;// Monto Tributo por Item;

                        foreach ($ruta_archivo['info'] as $key => $value) {
                            if($archivo = fopen($value['ruta'] , "w+")) {
                                fwrite($archivo,"");
                                if(fwrite($archivo, $value['data'])) {
                                    $respo = true;
                                } else {
                                    $respo =false;
                                    break;
                                }
                                fclose($archivo);
                            }  
                        }

                        if ($respo){
                            mysqli_commit($con);
                            echo $idfactura."-El documento fue creada correctamente";
                        } else{
                            echo "A-Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
                        }
                    }
                }
            }
        } catch (Exception $e) {
            mysqli_rollback($con);
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
    //
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
*/
