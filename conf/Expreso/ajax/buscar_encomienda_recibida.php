<?php

	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	//Archivo de funciones PHP
	include("../funciones.php");
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
if($action == 'ajax'){
		  $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
         $sTable = "tb_buses,tb_sucursales, tb_encomienda_cab, tb_cliente";
 $sWhere = "";
		 $sWhere.= "where tb_encomienda_cab.id_sucursal_llegada = ".$_SESSION['idsucursal']."  AND
					 tb_encomienda_cab.id_sucursal_partida = tb_sucursales.id_sucursal and tb_encomienda_cab.id_bus = tb_buses.id_bus AND
					 tb_encomienda_cab.id_cliente = tb_cliente.id_cliente";
if ( $_GET['q'] != "" )
		{
			$sWhere.= " and  (tb_cliente.n_documento_identidad like '%$q%' or tb_sucursales.direccion like '%$q%' or tb_encomienda_cab.codigo like '%$q%')";
		}
$sWhere.=" order by tb_encomienda_cab.id_encomienda desc";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table
$query= "SELECT count(*) AS numrows FROM $sTable  $sWhere";

		$count_query = mysqli_query($con,$query);
		
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './encomienda.php';
		//main query to fetch the data
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page"; //print_r($sql);
		$query = mysqli_query($con, $sql);
	if ($numrows>0){

?>
<div class="table-responsive">
			  <table class="table">
				<tr  class="info">
					<th>#</th>
					<th>Codigo</th>
					<th>Conductor</th>
					<th>Documento Identidad</th>
					<th>Nombre Cliente</th>
					<th>Sucursal de Salida</th>
					<th class='text-right'>Acciones</th>
					<th class='text-right'></th>
					
				</tr>
<?php
				while ($row=mysqli_fetch_array($query)){
						
						$codigo=$row['codigo'];
						$nombre_cliente=$row['nombre_cliente'];
						$nombre_sucursal=$row['nombre_sucursal'];
						$direccion = $row['direccion'];
						$fecha_creado = $row['fecha_creado'];
						$id_encomienda=$row['id_encomienda'];
						$nombrebus=$row['placa'];
						$ndocumento = $row['n_documento_identidad'];
						$offset++;
					?>
				<tr>
						<td class="id" style=" display: none;"><?php echo $id_encomienda;?></td>
						<td><?php echo $offset;?></td>
						<td><?php echo $codigo;?></td>
						<td><?php echo $nombrebus;?></td>
						<td ><?php echo $ndocumento;?></td>
						<td><?php echo $nombre_cliente;?></td>
						<td ><?php echo $nombre_sucursal;?></td>						
						<!--td><?php echo $fecha_creado;?></td-->
					<td><span class="pull-right"><span class="pull-right">
					
					<a href="#" class='btn btn-default' title='Mostrar Encomiendas' data-toggle="modal" id="detalle" onclick="detalles(<?php echo $id_encomienda;?>)"data-target="#editarEncomiendadetalle"><i class="glyphicon glyphicon-open-file" disabled="false"></i> </a></span></td>	
					
					</tr>
					<?php
				}
				?>
		<tr>
					<td colspan=7><span class="pull-right">
					<?php
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
			  </table>
			</div>
		<?php
		}
	}
?>		
		