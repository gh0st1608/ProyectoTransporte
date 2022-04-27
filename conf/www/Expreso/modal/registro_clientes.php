	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="nuevoClientemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar nuevo cliente</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_cliente" name="guardar_cliente">
			<div id="resultados_ajax"></div>

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
								$acti= ($contador==1) ? " active" : "";
								?>
	                    <label class="btn btn-default <?php echo 'persona'.$contador. $acti;?> " data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
	                      <input type="radio" id="<?php echo 'persona'.$contador;?>" name="estado" value="<?php echo $id_tipo_persona;?>"><?php echo ($nombre);?> 
	                    </label>
	                  
								<?php
							}
						?>
</div>
	              </div>
			 </div>

			  <div class="form-group">
				<label for="nombre" class="col-sm-3 control-label" id="modnombre">Nombre</label>
				<div class="col-sm-9">
				  <input type="text" class="form-control delete" id="nombre" name="nombre"  maxlength="100"  maxlength="255" required>
				</div>
			  </div>

			 

				<!--div class="form-group">
				<label for="estado" class="col-sm-2 control-label">Tipo Documento</label>
				<div class="col-sm-4 doc" id="">
				 <select class="form-control hidden" id="tipodoc" name="tipodoc" required>
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

				
				</div-->

			<div class="form-group">
				<label for="dni" class="col-sm-3 control-label" id="moddni">DNI</label>
				<div class="col-sm-9">
				  <input type="text" class="form-control delete" id="dni" name="dni" required  maxlength="11" >
				  <input type="hidden" class="form-control delete" value="1" id="id_tipo_documento_identidad" name="id_tipo_documento_identidad"  >
					</div>
			</div>


			<div class="form-group">
				<label for="telefono" class="col-sm-3 control-label">Teléfono</label>
				<div class="col-sm-9">
				  <input type="text" class="form-control delete" id="telefono"  maxlength="9" name="telefono"  maxlength="9">
				</div> 
			</div>

			<div class="form-group">
				<label for="email" class="col-sm-3 control-label">Correo</label>
				<div class="col-sm-9">
					<input type="email" class="form-control delete" id="email" name="email"  maxlength="255" >
				</div>
			</div>
			<div class="form-group">
				<label for="edad" class="col-sm-3 control-label">Edad</label>
				<div class="col-sm-9">
					<input type="number" class="form-control delete" id="edad" name="edad"  maxlength="255" >
				</div>
			</div>
			  
			<div class="form-group">
				<label for="direccion" class="col-sm-3 control-label">Dirección</label>
				<div class="col-sm-9">
					<input type="text" class="form-control delete" id="direccion" name="direccion" maxlength="255" >
				</div>
			</div>
			  
			<!--div class="form-group">
				<label for="estado" class="col-sm-2 control-label">Estado</label>
				<div class="col-sm-9">
				 <select class="form-control hidden" id="estado" name="estado" required>
					<option value="" >-- Selecciona estado --</option>
					<option value="1" selected>Activo</option>
					<option value="0">Inactivo</option>
				  </select>
				</div>
			</div-->
			 
			 
			 
			
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