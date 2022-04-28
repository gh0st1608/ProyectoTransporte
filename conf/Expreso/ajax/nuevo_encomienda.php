<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['id_cliente'])) {
           $errors[] = "Seleccione cliente";
		} else if ($_POST['sucursal_llegada']==""){
			$errors[] = "Seleccione sucursal llegada";
		} else if (
			!empty($_POST['id_cliente']) &&
			!empty($_POST['id_bus']) &&
			!empty($_POST['sucursal_llegada'])
			
		){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		$cliente=mysqli_real_escape_string($con,(strip_tags($_POST["id_cliente"],ENT_QUOTES)));
		$bus=mysqli_real_escape_string($con,(strip_tags($_POST["bus"],ENT_QUOTES)));
		$sucursal_llegada=mysqli_real_escape_string($con,(strip_tags($_POST["sucursal_llegada"],ENT_QUOTES)));
		$estado= "1";
		// $date_added=date("Y-m-d H:i:s");
		$usua = $_SESSION['user_id'];
		$usu = $_SESSION['user_id'];

		$fec = date('Y-m-d');
		$sucursal_partida = $_SESSION['idsucursal'];
		$celular = $_POST['celular'];
		$dni = $_POST['dni'];
		$delivery = $_POST['delivery'];
		
		$direccion_delivery = $_POST['direccion_delivery'];
		$conductor = $_POST['conductor'];
		$encargado = $_POST['id_encargado'];
		print_r($dni);
		print_r($sucursal_partida);

		$sql="INSERT INTO tb_encomienda_cab(id_cliente,id_usuario,id_bus,id_sucursal_partida,id_sucursal_llegada,situacion,id_usuario_creador,fecha_creado,celular,dni,delivery,direccion_delivery,conductor,id_encargado) VALUES ('$cliente',$usua,'$bus','$sucursal_partida','$sucursal_llegada',$estado,$usu,'$fec','$celular','$dni','$delivery','$direccion_delivery','$conductor','$encargado')";
//print_r($sql);

		$query_new_insert = mysqli_query($con,$sql);
			if ($query_new_insert){
				$messages[] = "Su registro ha sido ingresado satisfactoriamente.";
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