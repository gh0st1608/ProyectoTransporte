	<?php
		if (isset($con))
		{

	?>


	<!-- Modal -->
	<div class="modal fade" id="editarEncomienda" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar Encomienda</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="editar_encomienda" name="editar_encomienda">
			<div id="resultados_ajax2"></div>
			 <div class="form-group">
				<div class="col-sm-9">
					<input type="text" type="hidden"  class="form-control" name="mod_id_encomienda" id="id_encomienda" style=" display: none;">
				</div>
			  </div>

			  <div class="form-group">
				<label for="nombre" class="col-sm-2 control-label">Cliente</label>
					<div class="col-sm-9">
						<input type="text" class="form-control " id="mod_cliente" placeholder="Ingrese Cliente" required>
						<input id="modif_cliente" name="mod_cliente" type='hidden'>
					</div>
			</div>

			<div class="form-group">
				<label for="nombre" class="col-sm-2 control-label">Bus</label>
					<div class="col-sm-9">
							<input type="text" class="form-control " id="mod_bus" placeholder="Ingrese Placa" required>
							<input id="modif_bus" name="mod_bus" type='hidden'>

				</div>
			</div>



			<div class="form-group">
				<label for="nombre" class="col-sm-2 control-label">Origen</label>
					<div class="col-sm-9">
						<select class="form-control" id="mod_sucursal_partida" name="mod_sucursal_partida" disabled="true" required>
							<option value="" selected>Selecciona Sucursal</option>
										<?php 
											$sql="select id_sucursal,nombre_sucursal from tb_sucursales where id_sucursal='".$_SESSION['idsucursal']."'";
											$query=mysqli_query($con,$sql);
											while($rw=mysqli_fetch_array($query)){
												$id_sucursal=$rw['id_sucursal'];
												$nombre=$rw['nombre_sucursal'];
												?>
												
												<option selected value="<?php echo $id_sucursal;?>"><?php echo ($nombre);?></option>
												<?php
											}
										?>

						</select>

				</div>
			</div>

			<div class="form-group">
				<label for="nombre" class="col-sm-2 control-label">Destino</label>
					<div class="col-sm-9">
						<input type="text" class="form-control " id="sucursal_llegada" placeholder="Ingrese Destino" required>
						<input id="sucursal" name="mod_sucursal_llegada" type='hidden'>

				</div>
			</div>
	
			<!--  <div class="form-group">
				<label for="estado" class="col-sm-2 control-label">Situación</label>
				<div class="col-sm-6">
				 <select class="form-control" id="mod_estado" name="mod_estado" required>
					<option value="" selected>Selecciona Situación</option>
					<option value="1">Activo</option>
					<option value="0">Inactivo</option>
				  </select>
				</div>
			  </div>	--> 
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="actualizar_datos">Actualizar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>