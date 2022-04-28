<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['mod_cliente'])) {
           $errors[] = "seleccione cliente";
        }else if (empty($_POST['mod_bus'])) {
           $errors[] = "Seleccione bus";
        }else if (empty($_POST['mod_sucursal_llegada'])) {
           $errors[] = "Seleccione sucursal llegada";
		} else if (
			!empty($_POST['mod_cliente']) &&
			!empty($_POST['mod_bus']) &&
			!empty($_POST['mod_sucursal_llegada']) &&
			$_POST['mod_estado']!=""){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		$cliente=mysqli_real_escape_string($con,(strip_tags($_POST["mod_cliente"],ENT_QUOTES)));
		$bus=mysqli_real_escape_string($con,(strip_tags($_POST["mod_bus"],ENT_QUOTES)));
		$llegada=mysqli_real_escape_string($con,(strip_tags($_POST["mod_sucursal_llegada"],ENT_QUOTES)));
		$estado=intval($_POST['mod_estado']);
		$usu = $_SESSION['user_id'];
		$id_encomienda =$_POST["mod_id_encomienda"];
		$fec = date('Y-m-d');
		$sucursal_partida = $_SESSION['idsucursal'];

		$sql="UPDATE tb_encomienda_cab SET id_cliente='".$cliente."',id_bus='".$bus."',id_sucursal_partida='".$sucursal_partida."',id_sucursal_llegada='".$llegada."',situacion='".$estado."', id_usuario_modificador='".$usu."', fecha_modificado='".$fec."' WHERE id_encomienda='".$id_encomienda."'";
		$query_update = mysqli_query($con,$sql);
			if ($query_update){
				$messages[] = "El registro ha sido actualizado satisfactoriamente.";
			} else{
				$errors []= "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
			}
		} else {
			$errors []= "Error desconocido.";
		}
		
		if (isset($errors)){
			
						foreach ($errors as $error) {
								echo $error;
							}
						
			}
			if (isset($messages)){
				
							foreach ($messages as $message) {
									echo $message;
								}
			}

?>