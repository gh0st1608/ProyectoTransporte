	<?php
		if (isset($con))
		{

	?>


	<!-- Modal -->
	<div class="modal fade" id="datosEncomienda" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar nueva Encomienda</h4>
		  </div>
		  <form class="form-horizontal"  id="registrar_detalle_encomiendas" name="registrar_detalle_encomiendas">
		  <div class="modal-body">						
			 <div class="form-group">
				<div class="col-sm-8">
				 <!--  <input type="text" class="form-control" id="id_encomienda_c" name="id_encomienda_cab" placeholder="Ingresar Producto"  style=" display: none;" required> -->
				</div>

			</div>

			  <div class="form-group">
				<label for="producto" class="col-sm-2 control-label">Producto</label>
				<div class="col-sm-5">
				  <input type="text" class="form-control delteimput" id="producto" name="producto" placeholder="Ingresar Producto" required>
				  <input type="hidden" class=" delteimput" name="id_encomienda" id="id_encomiendas">
				</div>

				<label for="peso" class="col-sm-1 control-label">Peso</label>
				<div class="col-sm-3">
				  <input type="text" class="form-control delteimput" id="peso" name="peso" placeholder="Ingresar peso" required>
				</div>

			</div>

		

			<div class="form-group">
					<label for="descripcion" class="col-sm-2 control-label">Descripción</label>
				<div class="col-sm-9">
				  <input type="text" class="form-control delteimput" id="descripcion" name="descripcion" placeholder="Ingresar Descripción" required>
				</div>
			</div>

			<div class="form-group">
					<label for="cantidad" class="col-sm-2 control-label">Cantidad</label>
				<div class="col-sm-4">
				  <input type="text" class="form-control delteimput solo-numero" id="cantidad" name="cantidad" placeholder="Ingresar Cantidad" required>
				</div>
					
			</div>
	

			<div class="form-group">
				<label for="registro" class="col-sm-2 control-label">Fecha Registro</label>
				<div class="col-sm-4">
				  <input type="date" class="form-control delteimput regis" id="registro" name="registro"  required disabled="true">
				</div>

				<label for="envio" class="col-sm-1 control-label">Fecha Envio</label>
				<div class="col-sm-4">
				  <input type="date" class="form-control delteimput" id="envio" name="envio"  required>
				</div>
			</div>

			<div class="form-group">
				

				<label for="envio" class="col-sm-2 control-label">Precio</label>
				<div class="col-sm-4">
				  <input type="text" class="form-control delteimput" id="precio" name="precio" placeholder="Ingresar Precio" required>
				</div>
			</div>  
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="button" class="btn btn-primary guardardatos" id="guardardatos">Guardar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>