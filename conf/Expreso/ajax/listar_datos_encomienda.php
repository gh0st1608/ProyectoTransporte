<?php

	 
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	//Archivo de funciones PHP
	include("../funciones.php");
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';


	$id_encomienda=intval($_GET['id']);
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         // $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
         $sTable = "tb_encomienda_cab ,tb_encomienda_det,tb_cliente";

         $sWhere = "";
		 $sWhere.= "where tb_cliente.id_cliente = tb_encomienda_cab.id_cliente and 
					tb_encomienda_det.id_encomienda ='".$id_encomienda."' and tb_encomienda_cab.id_encomienda ='".$id_encomienda."'";
		// if ( $_GET['q'] != "" )
		// {
			// $sWhere.= " and  (tb_cliente.nombre_cliente like '%$q%' or tb_encomienda_det.producto like '%$q%')";
		// }
		$sWhere.=" order by tb_encomienda_cab.id_encomienda desc";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/

		$query= "SELECT count(*) AS numrows FROM $sTable  $sWhere";
		//print_r($query);
		$count_query = mysqli_query($con,$query);
		
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './encomienda.php';
		//main query to fetch the data
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			// $simbolo_moneda=get_row('perfil','moneda', 'id_perfil', 1);
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="info">
					
					<th>Producto</th>
					<th>Peso</th>
					<th class='text-right'>Cantidad</th>
					<th class='text-right'>Precio</th>
					
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
						$id_encomienda=$row['id_encomienda'];
						$nombre_cliente=$row['nombre_cliente'];
						$producto = $row['producto'];
						$peso = $row['peso'];
						$cantidad = $row['cantidad'];
						$precio = $row['precio'];
						$precio_delivery = $row['precio_delivery'];

						// $date_added= date('d/m/Y', strtotime($row['fecha_creado']));
						// $precio_producto=$row['precio'];
					?>
					<input type="hidden" value="<?php echo $id_encomienda;?>" id="id_encomienda<?php echo $id_encomienda;?>">
					<tr>
						
						<td><?php echo $producto;?></td>
						<td><?php echo $peso;?></td>
						<td class='text-right' ><?php echo $cantidad;?></td>	
						<td class='text-right' ><?php echo "S/.". $precio;?></td>	
					<!-- <td ><span class="pull-right"><span class="pull-right">
					<a href="#" class='btn btn-default' title='Agregar Detalles' onclick="obtener_datos('<?php echo $id_encomienda;?>');" data-toggle="modal" data-target="#datosEncomienda"><i class="glyphicon glyphicon-save-file"></i></a> 

					<a href="#" class='btn btn-default' title='Agregar Detalles' onclick="obtener_datos('<?php echo $id_encomienda;?>');" data-toggle="modal" data-target="#listarencomienda"><i class="glyphicon glyphicon-folder-open"></i></a> 

					<a href="#" class='btn btn-default' title='Editar Encomienda' onclick="obtener_datos('<?php echo $id_encomienda;?>');" data-toggle="modal" data-target="#editarEncomienda"><i class="glyphicon glyphicon-edit"></i></a> 
					
					<a href="#" class='btn btn-default' title='Borrar producto' onclick="eliminar('<?php echo $id_encomienda; ?>')"><i class="glyphicon glyphicon-trash"></i> </a></span></td> -->
						
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