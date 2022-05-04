	<?php
		if (isset($con))
		{

	?>


	<!-- Modal -->
	<div class="modal fade" id="nuevoEncomienda" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar nueva Encomienda</h4>
		  </div>
		  <div class="modal-body">

		<form class="form-horizontal" method="post" id="guardar_encomienda" name="guardar_encomienda">
		


			<div class="form-group">
				<label for="id_cliente" class="col-sm-2 control-label">Documento Cliente</label>
				<div class="col-sm-4">
					<input type="text" class="form-control delteimputs " id="nombre_cliente" placeholder="Ingrese Cliente" required>
					<input id="id_cliente" type='hidden' class=" delteimputs" name="id_cliente">	
				</div>

				<label for="id_cliente" class="col-sm-1 control-label">Cliente</label>
					<div class="col-sm-4">
					<input type="text" class="form-control delteimputs " id="Didentidad" placeholder="" readonly="">
					<input id="id_cliente" type='hidden' class=" delteimputs">	
				</div>
			
				
			</div>

			<div class="form-group">

				<label for="nombre" class="col-sm-2 control-label">Bus</label>
					<div class="col-sm-4">
						<input type="text" class="form-control delteimputs " id="bus" placeholder="Ingrese Placa" required>
						<input id="id_bus" name="bus" type='hidden' class=" delteimputs">	
					</div>


				<label for="nombre" class="col-sm-1 control-label">Sucursal Partida</label>
					<div class="col-sm-4">
						<?php 
							$count_query   = mysqli_query($con, "select id_sucursal,nombre_sucursal from tb_sucursales where id_sucursal='".$_SESSION['idsucursal']."'");
							$row= mysqli_fetch_array($count_query);
							$numrows = $row['nombre_sucursal'];
						 ?>
						<input type="text" class="form-control delteimputs " value="<?php echo $numrows ?>" id="sucursal_partida" placeholder="" readonly="">
				</div>
			
			</div>
					
					

				
			



			<div class="form-group">
				
				
				<label for="sucursal_destino" class="col-sm-2 control-label">Sucursal Destino</label>
					<div class="col-sm-4">
						<input type="text" class="form-control delteimputs " id="sucursal_destino" placeholder="Ingrese Sucursal Destino" required>
						<input id="sucursales" name="sucursal_llegada" type='hidden' class=" delteimputs">
					</div>
			</div>	 
			
		
			 <div class="form-group">
				<!--div class="col-sm-8">
				  <input type="text" class="form-control" id="id_encomienda_c" name="id_encomienda_cab" placeholder="Ingresar Producto"  style=" display: none;" required>
				</div-->

			</div>
			 </form>
			 <form class="form-horizontal" method="post" id="registrar_detalle_encomienda" >

			  <div class="form-group">
				<label for="producto" class="col-sm-2 control-label"> Producto</label>
				<div class="col-sm-4">
				  <input type="text" class="form-control delteimputs" id="producto" name="producto" placeholder="Ingresar Producto" required>
				</div>

				<label for="peso" class="col-sm-1 control-label"> Peso</label>
				<div class="col-sm-3">
				  <input type="text" class="form-control delteimputs" id="peso" name="peso" placeholder="Ingresar peso" required>
				</div>

			</div>

		

			<div class="form-group">
				<label for="descripcion" class="col-sm-2 control-label"> Desc.</label>
					<div class="col-sm-4">
					  <input type="text" class="form-control delteimputs" id="descripcion" name="descripcion" placeholder="Ingresar Descripción" required>
					</div>

				<label for="cantidad" class="col-sm-1 control-label"> Cantidad</label>
					<div class="col-sm-4">
					  <input type="text" class="form-control delteimputs" id="cantidad" name="cantidad" placeholder="Ingresar Cantidad" required>
					</div>
			</div>
	
			<div class="form-group">
				<label for="registro" class="col-sm-2 control-label"> Fecha Registro</label>
				<div class="col-sm-4">
				  <input type="date" class="form-control delteimputs" id="registro" name="registro"  disabled="true" required >
				</div>

				<label for="envio" class="col-sm-1 control-label"> Fecha Envio</label>
				<div class="col-sm-4">
				  <input type="date" class="form-control delteimputs" id="envio" name="envio"  required>
				</div>
			</div>

			<div class="form-group">
				

				<label for="envio" class="col-sm-2 control-label"> Precio</label>
				<div class="col-sm-4">
				  <input type="text" class="form-control delteimputs" id="precio" name="precio" placeholder="Ingresar Precio" required>
				</div>
			</div>  
			
		
		 
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="button" class="btn btn-primary" id="guardar_datos">Guardar datos</button>
		  </div>
		   </form>
		</div>
	  </div>
	</div>
	</div>
	<?php
		}
	?>

<script>
		
</script>