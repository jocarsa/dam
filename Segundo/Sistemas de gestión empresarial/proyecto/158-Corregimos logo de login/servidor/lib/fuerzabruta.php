<?php
	ini_set('display_errors', 1);																								// Activo errores
	ini_set('display_startup_errors', 1);																				// Activo errores de inicio
	error_reporting(E_ALL);	
	
		$servidor = "localhost";																			// Le doy los datos de acceso a la base de datos
		  $usuario = "crimson";																		// 
		  $contrasena = "crimson";																	// 
		  $basededatos = "crimson";																// 
	  
		  $conexion = mysqli_connect(
					$servidor, 
					$usuario, 
					$contrasena, 
					$basededatos
				);	
			
				$query = "
					SELECT 
					COUNT(ip) AS numero 
					FROM registros
					WHERE 
					ip = '".$_SERVER['REMOTE_ADDR']."'
					AND epoch > UNIX_TIMESTAMP()-60;
				";											// Formateo una consulta SQL para ver qué campos tienen restricciones
					//echo $query;
			$resultado = mysqli_query($conexion , $query);	
			
			
			while ($fila = mysqli_fetch_assoc($resultado)) {										// Recupero los datos del servidor
					if($fila['numero'] > 100){
					$query = "INSERT INTO registros VALUES
				
			(
				NULL,
				'".$_SERVER['REQUEST_TIME']."',
				'".$_SERVER['REMOTE_ADDR']."',
				'".$_SERVER['HTTP_USER_AGENT']."',
				'".$_SERVER['REQUEST_URI']."',
				'BLOQUEO FUERZA BRUTA'
				
			)
			
												;";											// Formateo una consulta SQL para ver qué campos tienen restricciones
				
			$result = mysqli_query($conexion , $query);
						die('{"error":"te has pasado de bruto"}');
					}																			// Hago un push encubierto a las restricciones
				}	
				
?>
