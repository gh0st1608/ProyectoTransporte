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
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar cliente</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="editar_cliente" name="editar_cliente">
			<div id="resultados_ajax2"></div>

			 <div class="form-group">
			 	<label  class="col-sm-2 control-label"></label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<div docIdentidad="" tipPersona="" class="btn-group updatedata" data-toggle="buttons">
					<?php 
						$sql="select id_tipo_persona,nombre_tipo_persona from tb_tipo_personas order by id_tipo_persona";
							$query=mysqli_query($con,$sql);
							$contador= 0;
							while($rw=mysqli_fetch_array($query)){
								$contador++;
								$id_tipo_persona=$rw['id_tipo_persona'];
								$nombre=$rw['nombre_tipo_persona'];
								?>
	                    <label class="btn btn-default <?php echo 'persona'.$contador;?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
	                      <input type="radio" id="<?php echo 'persona'.$contador;?>" name="tipo" value="<?php echo $id_tipo_persona;  ?>" ><?php echo ($nombre);?> 
	                    </label>
	                  
								<?php
							}
						?>
						</div>
	              </div>
			 </div>


			  <div class="form-group">
				<label for="mod_nombre" class="col-sm-3 control-label" id="modnombres">Nombre</label>
				<div class="col-sm-9">
				  <input type="text" class="form-control" id="mod_nombre" name="mod_nombre"  required maxlength="255">
					<input type="hidden" name="mod_id" id="mod_id">
				</div>
			  </div>
			 
			   <div class="form-group">
				<label for="dni" class="col-sm-3 control-label" id="mod_dni">DNI</label>
				<div class="col-sm-9">
				  <input type="text" class="form-control" id="moddnis" name="mod_dni" required maxlength="11">
				</div>
			  </div>

			   <div class="form-group">
				<label for="mod_telefono" class="col-sm-3 control-label">Teléfono</label>
				<div class="col-sm-9">
				  <input type="text" class="form-control" id="mod_telefono" name="mod_telefono" maxlength="9">
				</div>
			  </div>

				<!--div class="form-group">
				<label for="estado" class="col-sm-2 control-label">Tipo Documento</label>
				<div class="col-sm-4">
				 <select class="form-control" id="mod_tipodocs" name="mod_tipodoc" required>
					<option value="0" selected>--Selecciona Documento--</option>
					<?php 
										$sql="select id_tipo_documento_identidad,nombre_tipo_documento_identidad from tb_codumento_indentidad order by id_tipo_documento_identidad";
											$query=mysqli_query($con,$sql);
											while($rw=mysqli_fetch_array($query)){
												$id_tipo_documento=$rw['id_tipo_documento_identidad'];
												$nombre=$rw['nombre_tipo_documento_identidad'];
												?>
												
												<option value="<?php echo $id_tipo_documento;?>"><?php echo ($nombre);?></option>
												<?php
											}
										?>
				  </select>
				</div>

				<label for="dni" class="col-sm-1 control-label" id="mod_dni">DNI</label>
				<div class="col-sm-4">
				  <input type="text" class="form-control" id="moddnis" name="mod_dni" required maxlength="11">
				</div>

				</div-->



			  
			  <div class="form-group">
				<label for="mod_email" class="col-sm-3 control-label">Correo</label>
				<div class="col-sm-9">
				 <input type="email" class="form-control" id="mod_email" name="mod_email" maxlength="255">
				</div>
			  </div>

			  <div class="form-group">
				<label for="mod_edad" class="col-sm-3 control-label">Edad</label>
				<div class="col-sm-9">
					<input type="number" class="form-control delete" id="mod_edad" name="mod_edad"  maxlength="255" >
				</div>
			</div>

			  <div class="form-group">
				<label for="mod_direccion" class="col-sm-3 control-label">Dirección</label>
				<div class="col-sm-9">
				  <textarea class="form-control" id="mod_direccion" name="mod_direccion" maxlength="255"></textarea>
				</div>
			  </div>
			  
			  <!--div class="form-group">
				<label for="mod_estado" class="col-sm-2 control-label">Estado</label>
				<div class="col-sm-9">
				 <select class="form-control" id="mod_estado" name="mod_estado" required>
					<option value="">-- Selecciona estado --</option>
					<option value="1" selected>Activo</option>
					<option value="0">Inactivo</option>
				  </select>
				</div>
			  </div-->
			 
			 
			 
			
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