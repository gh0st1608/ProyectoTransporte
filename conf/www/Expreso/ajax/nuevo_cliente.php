<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['nombre'])) {
           $errors[] = "Nombre vacío";
        } else if (!empty($_POST['nombre'])){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		$nombre=mysqli_real_escape_string($con,(strip_tags($_POST["nombre"],ENT_QUOTES)));
		$telefono=mysqli_real_escape_string($con,(strip_tags($_POST["telefono"],ENT_QUOTES)));
		$email=mysqli_real_escape_string($con,(strip_tags($_POST["email"],ENT_QUOTES)));
		$direccion=mysqli_real_escape_string($con,(strip_tags($_POST["direccion"],ENT_QUOTES)));
		$documento=mysqli_real_escape_string($con,(strip_tags($_POST["dni"],ENT_QUOTES)));
		$tipPersona=mysqli_real_escape_string($con,(strip_tags($_POST["tipPersona"],ENT_QUOTES)));
		$edad=mysqli_real_escape_string($con,(strip_tags($_POST["edad"],ENT_QUOTES)));
		$docIdentidad=intval($_POST['docIdentidad']);
		// $date_added=date("Y-m-d H:i:s");

		$usu = $_SESSION['user_id'];
		$fec = date('Y-m-d');

		/*$sql="INSERT INTO tb_cliente (id_tipo_persona,nombre_cliente, id_tipo_documento_identidad,n_documento_identidad,direccion,correo, telefono,estado,id_usuario_creador ,fecha_creado, fecha_modificado, edad) VALUES ('$tipPersona','$nombre','$docIdentidad','$documento','$direccion','$email','$telefono','1',$usu,'$fec','$fec','$edad')";*/
		$sql="INSERT INTO tb_cliente (id_usuario,id_tipo_persona,nombre_cliente, id_tipo_documento_identidad,n_documento_identidad,direccion,correo, telefono,estado,id_usuario_creador ,fecha_creado, fecha_modificado, edad) VALUES ($usu,'$tipPersona','$nombre','$docIdentidad','$documento','$direccion','$email','$telefono','1',$usu,'$fec','$fec','$edad')";
		$query_new_insert = mysqli_query($con,$sql);
			if ($query_new_insert){
				$messages[] = "Cliente ha sido ingresado satisfactoriamente.";
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