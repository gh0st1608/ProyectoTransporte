	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar nuevo usuario</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_usuario" name="guardar_usuario">
			<div id="resultados_ajax"></div>
					  <div class="form-group">
				<label for="nombre_usuario" class="col-sm-3 control-label">Nombre Completo</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control delete" id="nombre_usuario" name="nombre_usuario" placeholder="Nombres" required  title="Nombre Completo ( sólo letras )" required  maxlength="255">
				</div>
			  </div>
			  <div class="form-group">
				<label for="usuario" class="col-sm-3 control-label">Usuario</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control delete" id="usuario" name="usuario" placeholder="Usuario" pattern="[a-zA-Z0-9]{2,64}" title="Nombre de usuario ( sólo letras y números)"  maxlength="255" required>
				</div>
			  </div>
			  <div class="form-group">
				<label for="usuario_password_nueva" class="col-sm-3 control-label">Contraseña</label>
				<div class="col-sm-8">
				  <input type="password" class="form-control delete" id="usuario_password_nueva" name="usuario_password_nueva" placeholder="Contraseña" title="Debe contener al menos un número y una letra mayúscula y minúscula, y al menos 6 o más caracteres"  maxlength="255" required>
				  <!--pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}"-->
				</div>
			  </div>
			  <div class="form-group">
				<label for="usuario_password_repetir" class="col-sm-3 control-label">Repite contraseña</label>
				<div class="col-sm-8">
				  <input type="password" class="form-control delete" id="usuario_password_repetir" name="usuario_password_repetir" placeholder="Repite contraseña" title="Repita la Contraseña"  maxlength="255" required>
				</div>
			  </div>

			  <div class="form-group">
				<label for="usuario_sucursal" class="col-sm-3 control-label">Sucursal</label>
				<div class="col-sm-8">
				<select class="form-control" id="usuario_sucursal" name="usuario_sucursal" required>
				   	<option value="" selected>-- Selecciona Sucursal --</option>
					<?php 
											$sql="select id_sucursal,nombre_sucursal from tb_sucursales order by id_sucursal";
											$query=mysqli_query($con,$sql);
											while($rw=mysqli_fetch_array($query)){
												$id_sucursal=$rw['id_sucursal'];
												$nombre=$rw['nombre_sucursal'];
												?>
												
												<option value="<?php echo $id_sucursal;?>"><?php echo ($nombre);?></option>
												<?php
											}
										?>
				  </select>
				</div>
			  </div>
			 
			  

			 
			 
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="guardar_datos">Guardar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>

	<?php
		}
	?>