<?php
	/*
		Este archivo se llama inmediatamente después del formulario de inicio de sesión y sirve para validar las credenciales enviadas contra la base de datos y si la validación es correcta en ese caso nos reenvía al escritorio 

	*/
	session_start();										// Inicio una sesión PHP
	
	include "config/config.php";								// Cargo los datos de conexión

	$peticion = "
		SELECT * FROM usuarios
		WHERE 
		email = '".$_POST['email']."'
		AND
		contrasena = '".$_POST['contrasena']."'
		";														// Pregunto a la base de datos si hay un usuario y contraseña que coincidan
	$resultado = $conexion->query($peticion);		// LAnzo la petición a la base de datos

	if ($fila = $resultado->fetch_assoc()) {		// Si es cierto que hay al menos un usuario
	  /*echo '
	  	<a href="escritorio.php">
	  		Pulsa y vamos al escritorio
	  	</a>';*/
	  	$_SESSION['login'] = true;
	  	$_SESSION['pagina'] = 0;
	  	echo '<meta http-equiv="refresh" content="0; url=escritorio.php">';												// Permiteme ir al escritorio
	}else{													// En caso contrario
		echo "Intento de acceso incorrecto";		// Dime que el intento es incorrecto
	}

?>

