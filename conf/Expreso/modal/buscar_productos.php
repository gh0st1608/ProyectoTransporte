	<?php
if (isset($con)) {
    ?>
			<!-- Modal -->
			<div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Buscar productos</h4>
				  </div>
				  <div class="modal-body">
				  	 <form class="form-horizontal" method="post" id="registrar_detalle_encomienda" >
				  	 	<!--div class="form-group">
							<label for="producto" class="col-sm-2 control-label"> Producto</label>
							<div class="col-sm-4">
							  <input type="text" class="form-control delteimputs" id="producto" name="producto" placeholder="Ingresar Producto" required>
							</div>

							<label for="peso" class="col-sm-1 control-label"> Peso</label>
							<div class="col-sm-3">
							  <input type="text" class="form-control delteimputs" id="peso" name="peso" placeholder="Ingresar peso" required>
							</div>
							<label for="peso" style="text-align: left;" class="col-sm-1 control-label"> Kilo</label>

						</div-->
						<div class="form-group">
							<label for="envio" class="col-sm-2 control-label"> Precio</label>
							<div class="col-sm-4">
							  <input type="text" class="form-control delteimputs" id="precio" name="precio" placeholder="Ingresar Precio" required>
							</div>
							<label for="cantidad" class="col-sm-1 control-label"> Cantidad</label>
								<div class="col-sm-4">
								  <input type="text" class="form-control delteimputs" id="cantidad" name="cantidad" placeholder="Ingresar Cantidad" required>
								</div>
						</div>
						<div class="form-group">
							<label for="descripcion" class="col-sm-2 control-label"> Descripción</label>
								<div class="col-sm-9">
								  <textarea  type="text" class="form-control delteimputs" id="descripcion" name="descripcion" required> </textarea>
								</div>

						</div>
				  	 </form>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					<button type="button" class="btn btn-primary" id="guardar_datos_encomienda">Guardar datos</button>
				  </div>
				</div>
			  </div>
			</div>
	<?php
}
?>