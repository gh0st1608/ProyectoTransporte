<?php

	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	//Archivo de funciones PHP
	include("../funciones.php");
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$id_encomienda=intval($_GET['id']);
		$query=mysqli_query($con, "select * from tb_encomienda_det where id_encomienda='".$id_encomienda."'");
		$count=mysqli_num_rows($query);
		if ($count==0){
			if ($delete1=mysqli_query($con,"DELETE FROM tb_encomienda_cab WHERE id_encomienda='".$id_encomienda."'")){
			?>Datos eliminados exitosamente.<?php 
		}else {
			?>
			Lo siento algo ha salido mal intenta nuevamente.
			<?php
			
		}
			
		} else {
			?>
			No se puede eliminar la encomienda con datos
			<?php
		}
	}



	if($action == 'ajax'){
		$usu = $_SESSION['user_id'];
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
         //$sTable = "tb_buses,tb_cliente,tb_encomienda_cab,tb_sucursales";
         $sTable = " tb_encomienda_cab tb1 INNER JOIN tb_buses tb2 ON (tb1.id_bus = tb2.id_bus) INNER JOIN tb_cliente tb3 ON (tb1.id_cliente = tb3.id_cliente) INNER JOIN tb_sucursales tb4 ON (tb1.id_sucursal_llegada = tb4.id_sucursal) INNER JOIN tb_usuarios tb5 ON (tb1.id_usuario = tb5.id_usuario) ";

         $sWhere = "";
		 /*$sWhere.= " where tb_encomienda_cab.id_sucursal_partida = ".$_SESSION['idsucursal']." and tb_encomienda_cab.id_bus = tb_buses.id_bus 			AND tb_encomienda_cab.id_cliente = tb_cliente.id_cliente   AND tb_encomienda_cab.id_sucursal_llegada = tb_sucursales.id_sucursal ";*/
		 if ($usu != 1){
			$sWhere.=" WHERE tb1.id_usuario='".$_SESSION['user_id'] ."'";
		}
		 
		/*if ( $_GET['q'] != "" )
		{
			$sWhere.= " and  (tb_cliente.n_documento_identidad like '%$q%' or tb_buses.placa like '%$q%' or tb_encomienda_cab.codigo like '%$q%')";
		}*/
		//$sWhere.=" order by tb_encomienda_cab.id_encomienda desc";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/

		//$query= "SELECT count(*) AS numrows FROM $sTable  $sWhere ";
		//$query= "SELECT count(*) AS numrows FROM $sTable  $sWhere order by tb_encomienda_cab.id_encomienda desc ";
		//print_r($query);
		//$count_query = mysqli_query($con,$query);
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable $sWhere order by id_encomienda desc");
		
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './encomienda.php';
		//main query to fetch the data
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		//print_r($sql);
		$query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			// $simbolo_moneda=get_row('perfil','moneda', 'id_perfil', 1);
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="info">
					<th>#</th>
					<th>Codigo</th>
					<th>Registrado por</th>
					<th>Documento Identidad</th>
					<th>Cliente</th>
					<th>Destino</th>
					<th class='text-right'>Acciones</th>

					
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
					 //echo "<pre>"; print_r($row); echo "</pre>"; 
						$codigo=$row['codigo'];
						$nombre_usuario=$row['nombre_usuario'];
						$id_encomienda=$row['id_encomienda'];
						$ndocumento = $row['n_documento_identidad'];
						//$id_bus = $row['id_bus'];
						$id_llegada = $row['id_sucursal_llegada'];
						$id_cliente = $row['id_cliente'];
						$id_partida = $row['id_sucursal_partida'];
						$nombrebus=$row['placa'];
						$cliente=$row['nombre_cliente'];
						$nombre_sucursal=$row['nombre_sucursal'];
						$situacion=$row['situacion'];
						$conductor=$row['conductor'];
						if ($situacion==1){$estado="Activo";}
						else {$estado="Inactivo";}
						$offset++;
						// $date_added= date('d/m/Y', strtotime($row['fecha_creado']));
						// $precio_producto=$row['precio'];
					?>
					<input type="hidden" value="<?php echo $id_encomienda;?>" id="id_encomienda<?php echo $id_encomienda;?>">
					<input type="hidden" value="<?php echo $nombre_usuario;?>" id="nombre_usuario<?php echo $id_encomienda;?>">
					<input type="hidden" value="<?php echo $id_bus;?>" id="id_bus<?php echo $id_encomienda;?>">
					<input type="hidden" value="<?php echo $id_llegada;?>" id="id_llegada<?php echo $id_encomienda;?>">
					<input type="hidden" value="<?php echo $id_cliente;?>" id="id_cliente<?php echo $id_encomienda;?>">
					<input type="hidden" value="<?php echo $id_partida;?>" id="id_partida<?php echo $id_encomienda;?>">
					<input type="hidden" value="<?php echo $situacion;?>" id="estado<?php echo $id_encomienda;?>">
					<tr>
						<td style="display: none;" id="id_encomienda"><?php echo $id_encomienda;?></td>
						<td><?php echo $offset; ?></td>
						<td ><?php echo $codigo;?></td>
						<td><?php echo $nombre_usuario; ?></td>
						<td ><?php echo $ndocumento;?></td>
						<td ><?php echo $cliente;?></td>
						<td><?php echo $nombre_sucursal;?></td>
						<!--td> <?php echo $simbolo_moneda;?><span class='pull-right'><?php echo $estado; ?></span></td-->
					<td ><span class="pull-right">
					<a href="ver_encomienda.php?id_encomienda=<?php echo $id_encomienda;?>" class='btn btn-default' title='Ver Encomienda' ><i class="glyphicon glyphicon-eye-open"></i></a>
					 <a href="ticket.php?id_encomienda=<?php echo $id_encomienda;?>" class='btn btn-default' title='Imprimir Ticket' ><i class="glyphicon glyphicon-print"></i></a>				
					 
						
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