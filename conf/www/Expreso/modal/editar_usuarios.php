	<?php
		if (isset($con))
		{
	?>
	
	<!-- Modal -->
	<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar usuario</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="editar_usuario" name="editar_usuario">
			<div id="resultados_ajax2"></div>
				

			  <div class="form-group">
				<label for="nombre_usuario2" class="col-sm-3 control-label">Nombres</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="nombre_usuario2" name="nombre_usuario2" placeholder="Nombres" required>
				  <input type="hidden" id="mod_id" name="mod_id" pattern="[a-zA-Z]{2,64}" title="Edite el Nombre del usuario (sólo letras y números) maxlength="255" required">
				</div>
			  </div>
			  <div class="form-group">
				<label for="usuario2" class="col-sm-3 control-label">Usuario</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="usuario2" name="usuario2" placeholder="Usuario" pattern="[a-zA-Z0-9]{2,64}" title="Edite el Nombre de usuario (sólo letras y números)" maxlength="255" required>
				</div>
			  </div>	 
			
			  	<div class="form-group">
				<label for="usuario_sucursal2" class="col-sm-3 control-label">Sucursal</label>
				<div class="col-sm-8">
				   <select class="form-control" id="usuario_sucursales2" name="mod_tipodoc" required>
				   
				  </select>
				</div>
			  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="actualizar_datos">Actualizar datos</button>
		  </div>
		  </form>
		   </div>
		</div>
	  </div>
	</div>

	<?php
		}
	?>