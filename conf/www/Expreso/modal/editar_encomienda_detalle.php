<?php
		if (isset($con))
		{

	?>


	<!-- Modal -->
	<div class="modal fade" id="editarEncomiendadetalle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Datos de la Encomienda</h4>
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
					<div class="col-sm-12 detalles" >
						

					</div>
			</div>

		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>