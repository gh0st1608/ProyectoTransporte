<?php
require __DIR__ . '/ajax/ticket/autoload.php'; //Nota: si renombraste la carpeta a algo diferente de "ticket" cambia el nombre en esta línea
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
date_default_timezone_set("America/Lima");

   


	if (isset($_GET['id_encomienda']))
	{
		$id_encomienda=intval($_GET['id_encomienda']);
  		$campos ="tb_encomienda_cab.codigo, tb_buses.placa, tb_cliente.n_documento_identidad, tb_cliente.nombre_cliente, tb_cliente.telefono, tb_cliente.direccion, tb_encomienda_cab.tipdoc, tb_sucursales.nombre_sucursal, tb_encomienda_cab.fecha_creado, tb_encomienda_cab.id_consignatario,tb_encomienda_cab.celular,tb_encomienda_cab.dni,tb_encomienda_cab.id_encomienda,tb_encomienda_cab.conductor,tb_encomienda_cab.delivery,tb_encomienda_cab.direccion_delivery,encargado.nombre";

        //agregar la tabla encargado.nombre

    
		$sql_enco=mysqli_query($con,"select $campos from tb_encomienda_cab,encargado,tb_buses, tb_cliente , tb_sucursales where tb_buses.id_bus =  tb_encomienda_cab.id_bus and encargado.id_encargado = tb_encomienda_cab.id_encargado and tb_encomienda_cab.id_cliente = tb_cliente.id_cliente and tb_encomienda_cab.id_sucursal_llegada = tb_sucursales.id_sucursal and tb_encomienda_cab.id_encomienda='".$id_encomienda."'");
		//agregar la tabla encargado
        
        $countenco=mysqli_num_rows($sql_enco);
       // print_r ($countenco);
		if ($countenco == 1)
		{		
				$rw_encomienda=mysqli_fetch_array($sql_enco);
                $id_encomienda = $rw_encomienda['id_encomienda'];
                $codigo = $rw_encomienda['codigo'];
				$nombre_cliente=$rw_encomienda['nombre_cliente'];
				$n_documento=$rw_encomienda['n_documento_identidad'];
                $celular_remitente = $rw_encomienda['telefono'];

				$fecha=date("d/m/Y h:i:s a", strtotime($rw_encomienda['fecha_creado']));				
				$documento = ($rw_encomienda['tipdoc'] == "3") ? "Boleta Venta Electronica" : "Factura Electronica";
				


				$consignatario = $rw_encomienda['id_consignatario'];
				$celular_consignatario = $rw_encomienda['celular'];
				$dni = $rw_encomienda['dni'];
                $sucursal = $rw_encomienda['nombre_sucursal'];
                $conductor = $rw_encomienda['conductor'];
                $delivery = $rw_encomienda['delivery'];
                $direccion_delivery = $rw_encomienda['direccion_delivery'];

			    

                $encargado = $rw_encomienda['nombre'];

				$sqlfact = mysqli_query($con,"select * from tb_facturacion_cab where codigo='".$codigo."'");
				$rw_factura=mysqli_fetch_array($sqlfact);
                
				$subt = $rw_factura['valor_total'];
				$igvf = $rw_factura['igv_total'];
				$pre = $rw_factura['precio_total'];
				$id_facturacion = $rw_factura['id_facturacion'];
				$docidentidad = ($rw_factura['id_tipo_documento'] == "3") ? "DNI" : "RUC";


                $sqldetencomienda = mysqli_query($con,"select * from tb_encomienda_det where codigo='".$codigo."'");
                $rw_encomiendadet=mysqli_fetch_array($sqldetencomienda);

               $precio_delivery = $rw_encomiendadet['precio_delivery'];
              
                
				/*$count_queryasientoss   = mysqli_query($con, "SELECT tb_cliente.n_documento_identidad, tb_cliente.nombre_cliente FROM tb_encomienda_cab,tb_cliente where tb_encomienda_cab.id_consignatario = tb_cliente.id_cliente and tb_encomienda_cab.id_encomienda='".$id_encomienda."'");
	    		$rowasientoss= mysqli_fetch_array($count_queryasientoss);
	     		$n_documento_identidad = $rowasientoss['n_documento_identidad'];
	     		$nombre_consignatario = $rowasientoss['nombre_cliente'];*/
 				
		}	
	
	} 
	







?>
<html>

<head>
    <script type='text/javascript'>
    window.onload = function() {
        self.print();
    }
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/ticket.css">
    <link rel="icon" href="img/expreso.jpg">

    <title>Ticket</title>
</head>

<body>
    <div class="ticket" align="center">

        <h1 class="centered">EXPRESO LIMA
            <br><strong>Dirección: </strong> Av. Alfredo Mendiola 4050 PERU -LIMA
            <br><strong>Fecha: </strong><?php $time = time(); echo date("d-m-Y (H:i:s)", $time);?>
            <br><strong>Ticket: Nª  </strong><?php echo $id_encomienda;?>
        </h1>
        </h1>
        <p>
             <strong>Código:</strong> <?php echo $codigo;?>
        </p>
        <p>
            <strong>Remitente:</strong> <?php echo $nombre_cliente;?>
            <br><strong>DNI: </strong> <?php echo $n_documento;?>
            <br><strong>Celular: </strong> <?php echo $celular_remitente;?>
        </p>
        <p>
            <strong>Destinatario :</strong> <?php echo $consignatario;?>
            <br><strong>DNI: </strong> <?php echo $dni;?>
            <br><strong>Celular: </strong> <?php echo $celular_consignatario;?>
        </p>

        <p>
            <strong>Encargado:</strong> <?php echo $encargado;?>
            <br><strong>Destino: </strong> <?php echo $sucursal;?>
            <br><strong>Entrega: </strong> <?php echo $delivery;?>
            <br><strong>Dirección: </strong> <?php echo $direccion_delivery;?>
            <br><strong>Conductor: </strong> <?php echo $conductor;?>
        </p>


        <table>
            <thead>
                <tr>
                    <th class="quantity both_border">Cant.</th>
                    <th class="description both_border">Descripción</th>
                    <th class="price both_border">Total</th>
                </tr>
            </thead>
            <tbody>

                <?php 	
                $sqltabledet=mysqli_query($con, "select * from tb_facturacion_det where id_facturacion ='".$id_facturacion."'");
                //print_r($id_facturacion."wsdadasda");
                $hash = 0 ;
                while ($rows=mysqli_fetch_array($sqltabledet)){  $hash++; ?>
                <tr class="precios">
                
                    <td class="text-center" align="center"><?php echo $rows['cantidad']; ?></td>
                    <td class="desc" align="center"><?php echo $rows['descripccion']; ?></td>
                    <!--<td class="text-right valor"><?php echo $rows['precio_unitario']; ?></td>-->
                    <td class="text-right preciototal" align="right"><?php echo $rows['precio_total']; ?></td>
                </tr>
                <?php } ?>	
                <tr>
                    <td align="center">SubTotal:</td>
                    <td align="center">&nbsp;</td>
                    <td align="right"><?php echo $subt;?></td>
                </tr>
                <tr>
                    <td align="center">IGV:</td>
                    <td align="center">&nbsp;</td>
                    <td align="right"><?php echo $igvf;?></td>
                </tr>
                <?php   
                $sqltabladet=mysqli_query($con, "select * from tb_encomienda_det where id_encomienda ='".$id_encomienda."'");
                ?>


                 <tr>
                    <td align="center">Delivery:</td>
                    <td align="center">&nbsp;</td>
                    <td align="right"><?php echo $precio_delivery;?></td>
                </tr>
<?php ?>  
                <tr>
                    <td align="center">IMPORTE TOTAL:</td>
                    <td align="center">&nbsp;</td>
                    <td align="right"><?php echo $pre;?></td>
                </tr>
            </tbody>
        </table>