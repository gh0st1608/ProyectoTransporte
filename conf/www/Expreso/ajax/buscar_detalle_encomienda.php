<?php

	 
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	//Archivo de funciones PHP
	include("../funciones.php");
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';

	$id_encomienda=intval($_POST['id']);
	
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         // $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
         $sTable = "tb_encomienda_cab, tb_encomienda_det";

         $sWhere = "";
		 $sWhere.= " where tb_encomienda_det.id_encomienda='".$id_encomienda."' and tb_encomienda_cab.id_encomienda='".$id_encomienda."'" ;
		
		$sWhere.=" order by tb_encomienda_det.id_encomienda desc";
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
					<th>Descripción</th>
					<th class='text-right'>Cantidad</th>
					<th class='text-right'>Estado</th>
					

					
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
						$producto=$row['producto'];
						$peso=$row['peso'];
						$descripcion = $row['descripcion'];
						$cantidad = $row['cantidad'];
						$id_encomienda_det= $row['id_encomienda_det'];
						$estado_detalle = $row['estado_detalle'];
						// $estado = ($estado_detalle == 0) ? "checked" : "";
						
					?>
					
					<tr>
						<td class="id_detalle" style=" display: none;"><?php echo $id_encomienda_det;?></td>
						<td><?php echo $producto;?></td>
						<td><?php echo $peso;?></td>
						<td><?php echo $descripcion;?></td>
						<td class='text-right'><?php echo $cantidad;?></td>
					
					<td class='text-right enable'><input type="checkbox"  id="verificar" <?php if ($estado_detalle == 1 ) {
						echo "checked" ." ". "disabled";} ?> name="vehicle" value="Car"> Verificado<br></td>

					
						
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


	if ($action=='modificar') {
		$situcaion='1';
		$id_encomienda_det = intval($_POST['id']);

		$sql = "UPDATE tb_encomienda_det SET estado_detalle ='".$situcaion."' where id_encomienda_det='".$id_encomienda_det."'";
		//print_r($sql);
		$query_update = mysqli_query($con,$sql);
			if ($query_update){
				$messages[] = "Ha sido actualizado satisfactoriamente.";
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
	}
?>