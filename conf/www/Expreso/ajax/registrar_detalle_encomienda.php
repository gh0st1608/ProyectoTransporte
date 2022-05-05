<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
	//print_r($_POST);
	if (empty($_POST['producto'])) {
			$errors[] = "Ingrese producto";
		}else if ($_POST['peso']==""){
			$errors[] = "Ingrese peso";
		}else if (empty($_POST['descripcion'])) {
			$errors[] = "Ingrese Descripcion";
		}else if (empty($_POST['cantidad'])) {
			$errors[] = "Ingrese Cantidad";
		}else if (empty($_POST['precio'])) {
			$errors[] = "Ingrese precio";	
		}else if (empty($_POST['envio'])){
			$errors[] = "Seleccione Fecha";
		}else if (empty($_POST['precio_delivery'])){
			$errors[] = "Seleccione Precio Delivery";
		}
		else if (
			!empty($_POST['producto']) &&
			!empty($_POST['peso']) &&
			!empty($_POST['descripcion']) &&
			!empty($_POST['precio']) &&
			!empty($_POST['envio']) &&
			!empty($_POST['precio_delivery'])
		)
		{
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		// $id_encomienda_cab = $_POST['id_encomienda_cab'];
		$producto=mysqli_real_escape_string($con,(strip_tags($_POST["producto"],ENT_QUOTES)));
		$peso=mysqli_real_escape_string($con,(strip_tags($_POST["peso"],ENT_QUOTES)));
		$descripcion=mysqli_real_escape_string($con,(strip_tags($_POST["descripcion"],ENT_QUOTES)));
		$cantidad=mysqli_real_escape_string($con,(strip_tags($_POST["cantidad"],ENT_QUOTES)));
		$precio=mysqli_real_escape_string($con,(strip_tags($_POST["precio"],ENT_QUOTES)));
		$id_encomienda=(isset($_POST["id_encomienda"])) ? mysqli_real_escape_string($con,(strip_tags($_POST["id_encomienda"],ENT_QUOTES))) : "0";
		$envio=mysqli_real_escape_string($con,(strip_tags($_POST["envio"],ENT_QUOTES)));
		$precio_delivery=mysqli_real_escape_string($con,(strip_tags($_POST["precio_delivery"],ENT_QUOTES)));
		$id_pago=mysqli_real_escape_string($con,(strip_tags($_POST["id_pago"],ENT_QUOTES))); //agregado pedrito
		$date_added=date("Y-m-d H:i:s");
		// $placa=intval($_POST['placa']);

		$query ="SELECT id_encomienda FROM tb_encomienda_cab ORDER by id_encomienda DESC LIMIT 1";
		$count_query  = mysqli_query($con, $query);
		$row= mysqli_fetch_array($count_query);
		//print_r($row);

		$querycab   = mysqli_query($con, "SELECT * FROM tb_encomienda_cab ORDER BY id_encomienda desc LIMIT 1");
		$rows= mysqli_fetch_array($querycab);
		$idcabs = $rows['id_encomienda'];

		$idcab = ($id_encomienda == 0) ? $idcabs : $id_encomienda;

		$sql="INSERT INTO tb_encomienda_det(id_encomienda, producto,peso,descripcion,cantidad,precio,estado_detalle,fecha_registro,fecha_envio,precio_delivery) VALUES ('$idcab','$producto','$peso','$descripcion','$cantidad','$precio','0','$date_added','$envio','$precio_delivery')";
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