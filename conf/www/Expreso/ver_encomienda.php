<?php
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }
	$active_encomienda="active";
	$active_productos="";
	$active_clientes="";
	$active_usuarios="";	
	$title="Ver Encomienda | Expreso Lima E.I.R.L";
	
	
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	if (isset($_GET['id_encomienda']))
	{
		$id_encomienda=intval($_GET['id_encomienda']);
		$campos ="tb_encomienda_cab.codigo, tb_buses.placa,tb_cliente.n_documento_identidad, tb_cliente.nombre_cliente, tb_cliente.direccion, tb_encomienda_cab.tipdoc, tb_sucursales.nombre_sucursal, tb_encomienda_cab.fecha_creado, tb_encomienda_cab.id_consignatario,tb_encomienda_cab.celular,tb_encomienda_cab.dni,tb_encomienda_cab.delivery,tb_encomienda_cab.direccion_delivery,tb_encomienda_cab.id_pago,tb_pago.pago";

		$sql_enco=mysqli_query($con,"select $campos from tb_encomienda_cab, tb_buses, tb_cliente , tb_sucursales, tb_pago where tb_buses.id_bus =  tb_encomienda_cab.id_bus and tb_encomienda_cab.id_cliente = tb_cliente.id_cliente and tb_encomienda_cab.id_sucursal_llegada = tb_sucursales.id_sucursal and tb_encomienda_cab.id_encomienda='".$id_encomienda."' and tb_encomienda_cab.id_pago = tb_pago.id_pago");
		$countenco=mysqli_num_rows($sql_enco);

		if ($countenco == 1)
		{		
				$rw_encomienda=mysqli_fetch_array($sql_enco);
				$placa=$rw_encomienda['placa'];
				$nombre_cliente=$rw_encomienda['nombre_cliente'];
				$n_documento=$rw_encomienda['n_documento_identidad'];
				//$direccion_cliente=$rw_encomienda['direccion'];
				$fecha=date("d/m/Y h:i:s a", strtotime($rw_encomienda['fecha_creado']));				
				$documento = ($rw_encomienda['tipdoc'] == "3") ? "Boleta Venta Electronica" : "Factura Electronica";
				$codigo = $rw_encomienda['codigo'];
				$cosignatario = $rw_encomienda['id_consignatario'];
				$cel = $rw_encomienda['celular'];
				$dni = $rw_encomienda['dni'];
				//$conductor = $rw_encomienda['conductor'];
				$sucursal = $rw_encomienda['nombre_sucursal'];
				$delivery = $rw_encomienda['delivery'];
				$direccion_delivery = $rw_encomienda['direccion_delivery'];
				$id_pago = $rw_encomienda['id_pago'];
				$pago = $rw_encomienda['pago'];
			

				$sqlfact = mysqli_query($con,"select * from tb_facturacion_cab where codigo='".$codigo."'");
				$rw_factura=mysqli_fetch_array($sqlfact);
				$subt = $rw_factura['valor_total'];
				$igvf = $rw_factura['igv_total'];
				$pre = $rw_factura['precio_total'];
				$id_facturacion = $rw_factura['id_facturacion'];
				$docidentidad = ($rw_factura['id_tipo_documento'] == "3") ? "DNI" : "RUC";


				/*$count_queryasientoss   = mysqli_query($con, "SELECT tb_cliente.n_documento_identidad, tb_cliente.nombre_cliente FROM tb_encomienda_cab,tb_cliente where tb_encomienda_cab.id_consignatario = tb_cliente.id_cliente and tb_encomienda_cab.id_encomienda='".$id_encomienda."'");
	    		$rowasientoss= mysqli_fetch_array($count_queryasientoss);
	     		$n_documento_identidad = $rowasientoss['n_documento_identidad'];
	     		$nombre_consignatario = $rowasientoss['nombre_cliente'];*/
 				
		}	
		else
		{
			header("location: encomienda.php");
			exit;
		}
	} 
	else 
	{
		header("location: encomienda.php");
		exit;
	}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include("head.php");?>
  </head>
  <link rel="icon"  href="img/expreso.jpg">
  <body>
	<?php
	include("navbar.php");
	?>  
    <div class="container">
	<div class="panel panel-info">
		<div class="panel-heading">
			<div class="btn-group pull-right">
			<a class="btn btn-info" href="encomienda.php"><span class="glyphicon glyphicon-arrow-left" ></span> Regresar</a>
		</div>
			<h4><i class='glyphicon glyphicon-edit'></i> Ver Encomienda</h4>
		</div>
		<div class="panel-body">
<form class="form-horizontal" role="form" id="datos_factura">
	<div class="form-group row">
		<label for="n_documento" class="col-md-1 control-label">Codigo</label>
	<div class="col-md-2">
		<input style="width: 120px;" type="text" readonly class="form-control input-sm" id="n_documento" required value="<?php echo $codigo;?>">	
	</div>
<label for="nombre_cliente" class="col-md-1 control-label">Cliente</label>
 <div class="col-md-2">
 	<input style="width: 120px;" type="text" readonly class="form-control input-sm" id="nombre_cliente" placeholder="Selecciona un cliente" required value="<?php echo $nombre_cliente;?>">
<input id="id_cliente" name="id_cliente" type='hidden' value="<?php echo $id_cliente;?>">
 </div>
 <label for="tel1" class="col-md-1 control-label"><?php echo $docidentidad; ?> </label>
 <div class="col-md-2">
	<input style="width: 120px;" type="text" class="form-control input-sm" id="tel1" placeholder="Teléfono" value="<?php echo $n_documento;?>" readonly>
</div>
</div>
<div class="form-group row">
	<?php if ($docidentidad == "DNI") { ?>
		 <label for="id_consignatario" class="col-md-1 control-label">Destinatario</label>
		 <div class="col-md-2">
			<input style="width: 120px;" type="text" readonly class="form-control input-sm" id="id_consignatario" value="<?php echo $cosignatario; ?>">	
</div>	<?php } ?> 
		<label for="dni" class="col-md-1 control-label">DNI</label>
		<div class="col-md-2">
		<input style="width: 120px;" type="text" readonly class="form-control input-sm" id="dni" value="<?php echo $dni; ?>">	
		</div>
		<label for="celular" class="col-md-1 control-label">Celular</label>
		<div class="col-md-2">
			 <input style="width: 120px;" type="text" readonly class="form-control input-sm" id="celular" value="<?php echo $cel; ?>">
		</div>
</div>
<div class="form-group row">
	<label for="delivery" class="col-md-1 control-label">Entrega</label>
		<div class="col-md-2">
			<input style="width: 120px;" type="text" class="form-control input-sm" id="delivery" placeholder="Entrega" readonly  value="<?php echo $delivery;?>">
		</div>	
<label for="direccion_delivery" class="col-md-1 control-label">Dirección</label>
<div class="col-md-2">
	<input style="width: 120px;" type="text" class="form-control input-sm" id="direccion_delivery" placeholder="Dirección" readonly  value="<?php echo $direccion_delivery;?>">
</div>
 <label for="email" class="col-md-1 control-label">Destino</label>
 <div class="col-md-2">
 	<input style="width: 120px;" type="text" class="form-control input-sm" id="sucursal_llegada" value="<?php echo $sucursal;?>" readonly>
 </div>
</div>
<div class="form-group row">
			<label for="pago" class="col-md-1 control-label">Pago</label>
			<div class="col-md-2">
				<input style="width: 120px;" type="text" class="form-control input-sm" name="id_pago"id="id_pago" placeholder="Pago" readonly  value="<?php echo $pago;?>">
			</div>
	<!--<label  for="conductor" class="col-md-1 control-label">Conductor</label>
 	<div class="col-md-2">
 	<input style="width: 120px;" type="text" readonly class="form-control input-sm" id="conductor" value="<?php echo  $conductor;?>" name="conductor">
	</div>-->

			<div class="clearfix"></div>
			<div class="editar_factura" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->	
			<div id="resultados" class='col-md-12' style="margin-top:10px">
			
			<table class="table" id="tabledetalle">
			<tbody>
				<tr>
					<th class="text-center">#</th>
					<th class="text-center">Cantidad</th>
					<th>Descripción</th>
					<th class="text-right">Precio Unitario</th>
					<th class="text-right">Precio Total</th>
					<th></th>
				</tr>
				<?php 	

			$sqltabledet=mysqli_query($con, "select * from tb_facturacion_det where id_facturacion ='".$id_facturacion."'");
			//print_r($id_facturacion."wsdadasda");
			$hash = 0 ;
				while ($rows=mysqli_fetch_array($sqltabledet)){  $hash++; ?>
						<tr class="precios">
							<td class="text-center"><?php echo $hash; ?></td>
							<td class="text-center"><?php echo $rows['cantidad']; ?></td>
							<td class="desc"><?php echo $rows['descripccion']; ?></td>
							<td class="text-right valor"><?php echo $rows['precio_unitario']; ?></td>
							<td class="text-right preciototal"><?php echo $rows['precio_total']; ?></td>
							<td class="text-center"></td>
						</tr>
				<?php } ?>	
				<tr class="subtotal">
					<td class="text-right" colspan="4">SUBTOTAL S/.</td>
					<td class="text-right valor"><?php echo $subt; ?></td>
					<td></td>
				</tr>
				<tr class="igv">
					<td class="text-right" colspan="4">IGV (18)% S/.</td>
					<td class="text-right valor"><?php echo $igvf; ?></td>
					<td class="text-center"></td>
				</tr>
				<tr class="total">
					<td class="text-right" colspan="4">TOTAL S/.</td>
					<td class="text-right valor"><?php echo $pre; ?></td>
					<td></td>
				</tr>
			</tbody>
		</table>
		</div><!-- Carga los datos ajax -->			
			
		</div>
	</div>		
		 
	</div>
	<hr>
	<?php
	include("footer.php");
	?>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

  </body>
</html>