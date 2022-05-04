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
		if (empty($_POST['nombre_usuario'])){
			$errors[] = "Nombres vacíos"; 
		} elseif (empty($_POST['usuario'])) {
            $errors[] = "Nombre de usuario vacío";
        } elseif (empty($_POST['usuario_sucursal'])) {
            $errors[] = "Nombre de sucursal vacío";
        } elseif (empty($_POST['usuario_password_nueva']) || empty($_POST['usuario_password_repetir'])){
            $errors[] = "Contraseña vacía";
        } elseif ($_POST['usuario_password_nueva'] !== $_POST['usuario_password_repetir']) {
            $errors[] = "la contraseña y la repetición de la contraseña no son lo mismo";
        } elseif (strlen($_POST['usuario_password_nueva']) < 6) {
            $errors[] = "La contraseña debe tener como mínimo 6 caracteres";
        } elseif (strlen($_POST['usuario']) > 64 || strlen($_POST['usuario']) < 2) {
            $errors[] = "Nombre de usuario no puede ser inferior a 2 o más de 64 caracteres";
        } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['usuario'])) {
            $errors[] = "Nombre de usuario no encaja en el esquema de nombre: Sólo aZ y los números están permitidos , de 2 a 64 caracteres";
        } elseif (
			!empty($_POST['usuario'])
			&& !empty($_POST['nombre_usuario'])
            && !empty($_POST['usuario_sucursal'])
            && strlen($_POST['usuario']) <= 64
            && strlen($_POST['usuario']) >= 2
            && preg_match('/^[a-z\d]{2,64}$/i', $_POST['usuario'])
            && !empty($_POST['usuario_password_nueva'])
            && !empty($_POST['usuario_password_repetir'])
            && ($_POST['usuario_password_nueva'] === $_POST['usuario_password_repetir'])
        ) {
            require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
			require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
			
				// escaping, additionally removing everything that could be (html/javascript-) code
                $nombre_usuario = mysqli_real_escape_string($con,(strip_tags($_POST["nombre_usuario"],ENT_QUOTES)));
				$usuario = mysqli_real_escape_string($con,(strip_tags($_POST["usuario"],ENT_QUOTES)));
                $usuario_sucursal=mysqli_real_escape_string($con,(strip_tags($_POST["usuario_sucursal"],ENT_QUOTES)));
				$user_password = $_POST['usuario_password_nueva'];
                // crypt the user's password with PHP 5.5's password_hash() function, results in a 60 character
                // hash string. the PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using
                // PHP 5.3/5.4, by the password hashing compatibility library
				$password = password_hash($user_password, PASSWORD_DEFAULT);
				
                // check if user or email address already exists
                $sql = "SELECT * FROM tb_usuarios WHERE usuario = '" . $usuario . "' OR nombre_usuario = '" . $nombre_usuario . "';";
                $query_check_usuario = mysqli_query($con,$sql);
				$query_check_user=mysqli_num_rows($query_check_usuario);
                if ($query_check_user == 1) {
                    $errors[] = "Lo sentimos , el nombre de usuario ó la dirección de correo electrónico ya está en uso.";
                } else {
					// write new user's data into database
                    $sql = "INSERT INTO tb_usuarios (nombre_usuario, usuario, password, id_sucursales)
                            VALUES('".$nombre_usuario."','" . $usuario . "', '" . $password . "','".$usuario_sucursal."');";
                    $query_new_user_insert = mysqli_query($con,$sql);
                    //print_r($sql);

                    // if user has been added successfully
                    if ($query_new_user_insert) {
                        $messages[] = "La cuenta ha sido creada con éxito.";
                    } else {
                        $errors[] = "Lo sentimos , el registro falló. Por favor, regrese y vuelva a intentarlo.";
                    }
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