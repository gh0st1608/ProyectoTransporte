<?php
	 
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }

	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	$active_facturas="";
	$active_productos="";
	$active_clientes="";
	$active_usuarios="active";	
	$title="Usuario | Expreso Lima E.I.R.L";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
	<?php include("head.php");?>
  </head>
  <link rel="icon" type="text/css" href="img/envio_encomiendas.jpg">
  <body>
 	<?php
	include("navbar.php");
	?> 
    <div class="container">
		<div class="panel panel-info">
		<div class="panel-heading">
		    <div class="btn-group pull-right">
				<button type='button' class="btn btn-info" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-plus" ></span> Nuevo Usuario</button>
<a  href="productividad.php" class="btn btn-info" style="margin-left: 11px;"><span class="glyphicon glyphicon-plus" ></span>Reporte Productividad de Venta</a>
			</div>
			<h4><i class='glyphicon glyphicon-search'></i> Buscar Usuarios</h4>
		</div>			
			<div class="panel-body">
			<?php
			include("modal/registro_usuarios.php");
			include("modal/editar_usuarios.php");
			include("modal/cambiar_password.php");
			?>
			<form class="form-horizontal" role="form" id="datos_cotizacion">
				
						<div class="form-group row">
							<label for="q" class="col-md-2 control-label">Nombre o Usuario:</label>
							<div class="col-md-5">
								<input type="text" class="form-control" id="q" placeholder="Nombre o Usuario" onkeyup='load(1);' pattern="[^'\x22]+" title="Busqueda por Nombre o USUARIO"  maxlength="255">
							</div>
							
							
							
							<div class="col-md-3">
								<button type="button" class="btn btn-default" onclick='load(1);'>
									<span class="glyphicon glyphicon-search" ></span> Buscar</button>
								<span id="loader"  maxlength="255"></span>
							</div>
							
						</div>
				
				
				
			</form>
				<div id="resultados"></div><!-- Carga los datos ajax -->
				<div class='outer_div'></div><!-- Carga los datos ajax -->
						
			</div>
		</div>

	</div>
	<hr>
	<?php
	include("footer.php");
	?>
	<script type="text/javascript" src="js/usuarios.js"></script>

	
	


  </body>
</html>
<script>
$( "#guardar_usuario" ).submit(function( event ) {
  $('#guardar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/nuevo_usuario.php",
			data: parametros,
			 beforeSend: function(objeto){
				//$("#resultados_ajax").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			//$("#resultados_ajax").html(datos);
			if (datos =="La cuenta ha sido creada con éxito.") {
				$('#myModal').modal('hide');
				$('.delete').val("");
				document.getElementById("usuario_sucursal").options[0].selected = true;load(1);
				load(1);
			}
			
			
			nom = (datos =="La cuenta ha sido creada con éxito.") ? "success" : "error";
			Swal(
			  'Mensaje',
			  datos,
			  nom
			)
			$('#guardar_datos').attr("disabled", false);
			
		  }
	});
  event.preventDefault();
})

$( "#editar_usuario" ).submit(function( event ) {
  $('#actualizar_datos2').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_usuario.php",
			data: parametros,
			 beforeSend: function(objeto){
				//$("#resultados_ajax2").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			//$("#resultados_ajax2").html(datos);
			$('#myModal2').modal('hide');
			nom = (datos =="La cuenta ha sido modificada con éxito.") ? "success" : "error";
			Swal(
			  'Mensaje',
			  datos,
			  nom
			)
			$('#actualizar_datos2').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

$( "#editar_password" ).submit(function( event ) {
  $('#actualizar_datos3').attr("disabled", true);
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_password.php",
			data: parametros,
			 beforeSend: function(objeto){
				//$("#resultados_ajax3").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			//$("#resultados_ajax3").html(datos);
			if (datos =="contraseña ha sido modificada con éxito.") {
				$('#myModal3').modal('hide');
				load(1);
				$('.delete').val("");
			}
			nom = (datos =="contraseña ha sido modificada con éxito.") ? "success" : "error";
			Swal(
			  'Mensaje',
			  datos,
			  nom
			)
			$('#actualizar_datos3').attr("disabled", false);
			
		  }
	});
  event.preventDefault();
})
	function get_user_id(id){
		$("#user_id_mod").val(id);
	}

	function obtener_datos(id){
			var nombres = $("#nombres"+id).val();
			var usuario = $("#usuario"+id).val();
			var cbx = $("#combobox"+id).val();

			
			$("#mod_id").val(id);
			$("#nombre_usuario2").val(nombres);
			$("#usuario2").val(usuario);
			$("#usuario_sucursales2").html(cbx);


			
			
		}
</script>