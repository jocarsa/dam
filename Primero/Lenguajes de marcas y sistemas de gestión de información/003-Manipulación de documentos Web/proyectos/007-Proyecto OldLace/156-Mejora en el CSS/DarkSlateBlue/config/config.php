<?php

	$servidor = "db5016890448.hosting-data.io";				// Defino el servidor
	$usuario = "dbu306167";			// Defino el usuario con permiso
	$contrasena = "Lielolilo123$";		// Defino la contraseña de ese usuario
	$base = "dbs13629921";				// Defino la base de datos

	$conexion = new mysqli(
		$servidor, 
		$usuario, 
		$contrasena, 
		$base
	);												// Creo una conexión de tipo MySQL

?>
