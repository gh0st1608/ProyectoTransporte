<?php
include('is_logged.php');
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
        $id_pago=mysqli_real_escape_string($con,(strip_tags($_POST['id_pago'],ENT_QUOTES)));
        if(isset($_POST['direccion_delivery'])){
            $direccion_delivery = $_POST['direccion_delivery'];
        }else{
            $direccion_delivery = "";
        }
        //$conductor=mysqli_real_escape_string($con,(strip_tags($_POST['conductor'],ENT_QUOTES)));
        $encargado=mysqli_real_escape_string($con,(strip_tags($_POST['id_encargado'],ENT_QUOTES)));

		$subtotalcab=mysqli_real_escape_string($con,(strip_tags($_POST['subtotal'],ENT_QUOTES)));
		$igvcab=mysqli_real_escape_string($con,(strip_tags($_POST['igv'],ENT_QUOTES)));
		$totalcab=mysqli_real_escape_string($con,(strip_tags($_POST['total'],ENT_QUOTES)));
		$preciotexto=mysqli_real_escape_string($con,(strip_tags($_POST['subtotal'],ENT_QUOTES)));

		/*encomienda*/
		$sqlencocab = "INSERT INTO tb_encomienda_cab (id_cliente,id_usuario,id_bus, id_sucursal_partida, id_sucursal_llegada,id_envio, situacion, id_usuario_creador, fecha_creado, id_usuario_modificador, fecha_modificado, codigo, tipdoc, id_consignatario,celular,dni,delivery,direccion_delivery,conductor,id_encargado,id_pago) VALUES ($id_cliente,$usuario, $id_bus, $idsucupartida, $id_sucu_llegada,'0','1', $usuario, '$fecha', $usuario, '$fecha', '$codigo', $tipdoc, '$consignatario','$celular','$dni','$delivery','$direccion_delivery','conductor','$encargado','$id_pago')";
		$insert_encocab=mysqli_query($con, $sqlencocab);

        if ($insert_encocab){
            $messages[] = "Encomienda ha sido ingresado satisfactoriamente.";
        } else{
            $errors []= "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
        }

        if (isset($errors)){
            foreach ($errors as $error) {
                    echo $error;
                }
            }
        if (isset($messages)){
            foreach ($messages as $message) {
                        echo $message;
                }
        }

        
		$count_encocab   = mysqli_query($con, "SELECT id_encomienda FROM tb_encomienda_cab WHERE codigo = '".$codigo."'");
		$rowencocab= mysqli_fetch_array($count_encocab);
		$id_encomienda = $rowencocab['id_encomienda'];

        $sqlencodet = "UPDATE tb_encomienda_det SET id_encomienda = $id_encomienda WHERE codigo = '".$codigo."'";
		$insert_encodet=mysqli_query($con, $sqlencodet);


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


        if ($insert_tmp){
            $messages[] = "Factura ha sido ingresado satisfactoriamente.";
        } else{
            $errors []= "Lo siento algo ha salido mal en factura intenta nuevamente.".mysqli_error($con);
        }

        if (isset($errors)){
            foreach ($errors as $error) {
                    echo $error;
                }
            }
        if (isset($messages)){
            foreach ($messages as $message) {
                        echo $message;
                }
        }
        
		$count_query   = mysqli_query($con, "SELECT id_facturacion FROM tb_facturacion_cab ORDER BY id_facturacion DESC limit 1");
		$row= mysqli_fetch_array($count_query);
		$idfactura = $row['id_facturacion'];

        //print_r($sqldet);die();

		$sqldetencomienda=mysqli_query($con, "select * from tb_encomienda_det where tb_encomienda_det.codigo='".$codigo."'");

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
            $insert_sqldet = mysqli_query($con, $sqldet); 
		}	
	  



        $respo = true;
        if ($respo){
			echo $id_encomienda."-El documento fue creada correctamente";
		} else{
			echo "0-Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
	    }
}