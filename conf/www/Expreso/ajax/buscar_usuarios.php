<?php

	 
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$id_usuario=intval($_GET['id']);
		$query=mysqli_query($con, "select * from tb_usuarios where id_usuario='".$id_usuario."'");
		$rw_user=mysqli_fetch_array($query);
		$count=$rw_user['id_usuario'];
		if ($id_usuario!=1){
			if ($delete1=mysqli_query($con,"DELETE FROM tb_usuarios WHERE id_usuario='".$id_usuario."'")){
			?>Datos eliminados exitosamente.<?php 
		}else {
			?>
			Lo siento algo ha salido mal intenta nuevamente.
			<?php
			
		}
			
		} else {
			?>
			No se puede borrar el usuario administrador.
			<?php
		}
		
		
		
	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 $aColumns = array('nombre_usuario', 'usuario');//Columnas de busqueda
		 $sTable = "tb_usuarios";
		 $sWhere = "";
		if ( $_GET['q'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		$sWhere.=" order by id_usuario desc";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './usuarios.php';
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
					<th>Nombres</th>
					<th>Usuario</th>
					<th><span class="pull-right">Acciones</span></th>
					
				</tr>
				<?php

				while ($row=mysqli_fetch_array($query)){
						$id_usuario=$row['id_usuario'];
						$nombre_usuario=$row['nombre_usuario'];
						$usuario=$row['usuario'];
						$id_sucursales=$row['id_sucursales'];
						$offset++;
						$cbx = "<option value='0'>--Selecciona Sucursal--</option>";
								
							$newsql="select id_sucursal,nombre_sucursal from tb_sucursales order by id_sucursal";
							$newquery=mysqli_query($con,$newsql);
						 	while($rw=mysqli_fetch_array($newquery)){
								$id_tipo_documento=$rw['id_sucursal'];
								$nombre=$rw['nombre_sucursal'];
								$select = ($id_tipo_documento == $id_sucursales) ? "selected" : "";			
								$cbx .=	"<option ".$select." value='". $id_tipo_documento."'>". $nombre."</option>";
						
							}
						
					?>

					<input type="hidden" value="<?php echo $row['nombre_usuario'];?>" id="nombres<?php echo $id_usuario;?>">
					<input type="hidden" value="<?php echo $usuario;?>" id="usuario<?php echo $id_usuario;?>">
					<input type="hidden" value="<?php echo $cbx;?>" id="combobox<?php echo $id_usuario;?>">
				
					<tr>
						<td><?php echo $offset; ?></td>
						<td><?php echo $nombre_usuario; ?></td>
						<td ><?php echo $usuario; ?></td>
						
					<td ><span class="pull-right">
					<a href="#" class='btn btn-default' title='Editar usuario' onclick="obtener_datos('<?php echo $id_usuario;?>');" data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-edit"></i></a> 

					<a href="#" class='btn btn-default' title='Cambiar contraseña' onclick="get_user_id('<?php echo $id_usuario;?>');" data-toggle="modal" data-target="#myModal3"><i class="glyphicon glyphicon-cog"></i></a>

					<!--a href="#" class='btn btn-default' title='Borrar usuario' onclick="eliminar('<?php echo $id_usuario; ?>')"><i class="glyphicon glyphicon-trash"></i> </a--></span></td>
						
					</tr>
					<?php
				}
				?>
				<tr>
					<td colspan=9><span class="pull-right">
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