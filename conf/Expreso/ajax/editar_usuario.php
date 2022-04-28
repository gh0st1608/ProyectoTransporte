<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
// checking for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
    require_once("../libraries/password_compatibility_library.php");
}		
		if (empty($_POST['nombre_usuario2'])){
			$errors[] = "Nombres vacíos";
		} elseif (empty($_POST['usuario2'])) {
            $errors[] = "Nombre de usuario vacío";
        }
         elseif (empty($_POST['mod_tipodoc'])) {
            $errors[] = "Nombre de Sucursal vacío";
        }
          elseif (strlen($_POST['usuario2']) > 64 || strlen($_POST['usuario2']) < 2) {
            $errors[] = "Nombre de usuario no puede ser inferior a 2 o más de 64 caracteres";
        } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['usuario2'])) {
            $errors[] = "Nombre de usuario no encaja en el esquema de nombre: Sólo aZ y los números están permitidos , de 2 a 64 caracteres";
        } elseif (
			!empty($_POST['usuario2'])&&
			!empty($_POST['nombre_usuario2'])&& 
			!empty($_POST['mod_tipodoc'])&& 
			 strlen($_POST['usuario2']) <= 64 &&
			 strlen($_POST['usuario2']) >= 2
            && preg_match('/^[a-z\d]{2,64}$/i', $_POST['usuario2'])
          )
         {
            require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
			require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
			
				// escaping, additionally removing everything that could be (html/javascript-) code
                $nombre_usuario = mysqli_real_escape_string($con,(strip_tags($_POST["nombre_usuario2"],ENT_QUOTES)));
				$usuario = mysqli_real_escape_string($con,(strip_tags($_POST["usuario2"],ENT_QUOTES)));
				//la id sucursal esta como int en la tabala usuario
				$usuario_sucursal = mysqli_real_escape_string($con,(strip_tags($_POST["mod_tipodoc"],ENT_QUOTES)));
				$usuario_id=intval($_POST['mod_id']);
					
               
					// write new user's data into database
                   $sql = "UPDATE tb_usuarios SET nombre_usuario='".$nombre_usuario."', id_sucursales='".$usuario_sucursal."', usuario='".$usuario."' WHERE id_usuario='".$usuario_id."'";

                    $query_update = mysqli_query($con,$sql);

                    // if user has been added successfully
                    if ($query_update) {
                        $messages[] = "La cuenta ha sido modificada con éxito.";
                    } else {
                        $errors[] = "Lo sentimos , el registro falló. Por favor, regrese y vuelva a intentarlo.";
                    }
                
            
        } else {
            $errors[] = "Un error desconocido ocurrió.";
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