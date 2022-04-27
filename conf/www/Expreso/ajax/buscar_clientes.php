<?php

	 
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$id_cliente=intval($_GET['id']);
		$query=mysqli_query($con, "select * from tb_facturacion_cab where id_cliente='".$id_cliente."'");
		$count=mysqli_num_rows($query);
		if ($count==1){
			if ($delete1=mysqli_query($con,"DELETE FROM tb_cliente WHERE id_cliente='".$id_cliente."'")){
			?>Datos eliminados exitosamente.<?php 
		}else {
			?>Lo siento algo ha salido mal intenta nuevamente.<?php
			
		}
			
		} else {
			?>No se pudo eliminar éste  cliente.<?php
		}
		
		
		
	}
	if($action == 'ajax'){
		$usu = $_SESSION['user_id'];
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 $aColumns = array('nombre_cliente','n_documento_identidad');//Columnas de busqueda
		 //$sTable = "tb_cliente";
		 $sTable = "tb_cliente tb1 INNER JOIN tb_usuarios tb2 ON (tb1.id_usuario=tb2.id_usuario)";
		 //$sTable = "tb_cliente, tb_usuarios";

		 $sWhere = "";
		/*if ( $_GET['q'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}*/
		//$sWhere.=" order by id_cliente desc";

		//$sWhere.=" Where id_usuario='".$_SESSION['user_id'] ."'  order by id_cliente desc";

		/*if ($usu=1){
			$sWhere.=" order by id_cliente desc";
		}
		else{
			$sWhere.=" Where id_usuario='".$_SESSION['user_id'] ."'  order by id_cliente desc";
		}*/

		if ($usu != 1){
			$sWhere.=" WHERE tb1.id_usuario='".$_SESSION['user_id'] ."'";
		}


		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		//$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		//$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable Where tb1.id_usuario='".$_SESSION['user_id'] ."'  order by tb1.id_cliente desc");
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable $sWhere order by id_cliente desc");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './clientes.php';
		//main query to fetch the data
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="info">
					<th>#</th>
					<th>Nombre</th>
					<th>Registrado por</th>
					<th>N° Documento</th>
					<th>Teléfono</th>
					<th>Dirección</th>
					
					<!--th>Agregado</th-->
					<th class='text-right'>Acciones</th>
					
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
						$id_cliente=$row['id_cliente'];
						$nombre_cliente=$row['nombre_cliente'];
						$nombre_usuario=$row['nombre_usuario'];
						$telefono_cliente=$row['telefono'];
						$Documento=$row['n_documento_identidad'];
						$direccion_cliente=$row['direccion'];
						$n_dni=$row['n_documento_identidad'];
						$tipo_doc=$row['id_tipo_documento_identidad'];
						$id_persona = $row['id_tipo_persona'];
						$status_cliente=$row['estado'];
						$email_cliente=$row['correo'];
						$edad=$row['edad'];
						if ($status_cliente==1){$estado="Activo";}
						else {$estado="Inactivo";}
						$date_added= date('d/m/Y', strtotime($row['fecha_creado']));
						$offset++;
						
					?>
					<input type="hidden" value="<?php echo $nombre_cliente;?>" id="nombre_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $nombre_usuario;?>" id="nombre_usuario<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $telefono_cliente;?>" id="telefono_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $email_cliente;?>" id="email_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $direccion_cliente;?>" id="direccion_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $status_cliente;?>" id="status_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $n_dni;?>" id="n_dni<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $tipo_doc;?>" id="tipo_doc<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $id_persona;?>" id="id_persona<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $edad;?>" id="edad<?php echo $id_cliente;?>">
					
					<tr>
						<td><?php echo $offset; ?></td>
		
						<td><?php echo $nombre_cliente; ?></td>
						<td><?php echo $nombre_usuario; ?></td>
						<td><?php echo $Documento;?></td>
						<td ><?php echo $telefono_cliente; ?></td>
						<td><?php echo $direccion_cliente;?></td>
						
						<!--td><?php echo $date_added;?></td-->
						
					<td ><span class="pull-right">
					<a href="#" class='btn btn-default' title='Editar cliente' id="edita_cliente" onclick="obtener_datos('<?php echo $id_cliente;?>');" data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-edit"></i></a> 
						<!--<a href="#" class='btn btn-default' title='Borrar cliente' onclick="eliminar('<?php echo $id_cliente; ?>')"><i class="glyphicon glyphicon-trash"></i> </a>--></span></td>
						
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