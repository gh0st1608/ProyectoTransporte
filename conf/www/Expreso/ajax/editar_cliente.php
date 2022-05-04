<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
	
/*$tipo=$_POST['tipo']; 

if (empty($_POST['mod_tipodoc'])) {
	$doc = '0';
}else{
	$doc = $_POST['mod_tipodoc'];
}
switch($tipo){ 
    case 1: 
        $tipo='1';
        break; 
    case 2: 
        $tipo='2';
        break; 
    case 3: 
        echo ""; 
        break; 
} */


	if (empty($_POST['mod_id'])) {
           $errors[] = "ID vacío";
        }else if (empty($_POST['mod_nombre'])) {
           $errors[] = "Nombre vacío";
        //}  else if ($_POST['mod_estado']==""){
		//	$errors[] = "Selecciona el estado del cliente";
		}  else if (
			!empty($_POST['mod_id']) &&
			!empty($_POST['mod_nombre']) 
			//$_POST['mod_estado']!="" 
		){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		$nombre=mysqli_real_escape_string($con,(strip_tags($_POST["mod_nombre"],ENT_QUOTES)));
		$telefono=mysqli_real_escape_string($con,(strip_tags($_POST["mod_telefono"],ENT_QUOTES)));
		$email=mysqli_real_escape_string($con,(strip_tags($_POST["mod_email"],ENT_QUOTES)));
		$direccion=mysqli_real_escape_string($con,(strip_tags($_POST["mod_direccion"],ENT_QUOTES)));
		$docIdentidad=mysqli_real_escape_string($con,(strip_tags($_POST['docIdentidad'],ENT_QUOTES)));
		$mod_dni=mysqli_real_escape_string($con,(strip_tags($_POST["mod_dni"],ENT_QUOTES)));
		$tipPersona=mysqli_real_escape_string($con,(strip_tags($_POST["tipPersona"],ENT_QUOTES)));
		$edad=mysqli_real_escape_string($con,(strip_tags($_POST["mod_edad"],ENT_QUOTES)));
		
		//$estado=intval($_POST['mod_estado']);
		
		$id_cliente=intval($_POST['mod_id']);

		$usu = $_SESSION['user_id'];
		$fec = date('Y-m-d');

		$sql="UPDATE tb_cliente SET nombre_cliente='".$nombre."',id_tipo_persona='".$tipPersona."',id_tipo_documento_identidad='".$docIdentidad."',n_documento_identidad='".$mod_dni."',telefono='".$telefono."', correo='".$email."', direccion='".$direccion."', estado='1' , id_usuario_modificado='".$usu."', fecha_modificado='".$fec."', edad='".$edad."' WHERE id_cliente='".$id_cliente."'";
		$query_update = mysqli_query($con,$sql);
			if ($query_update){
				$messages[] = "Cliente ha sido actualizado satisfactoriamente.";
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