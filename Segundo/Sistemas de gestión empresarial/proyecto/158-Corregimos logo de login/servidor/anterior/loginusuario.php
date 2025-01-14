<?php

	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);			// Establezco el nivel de retorno de errores de PHP
	$mysqli = mysqli_connect("localhost", "crimson", "crimson", "crimson");		// Me conecto a la base de datos
	$query = "
		SELECT 
		usuario
		FROM usuarios 
		WHERE usuario = '".$_GET['usuario']."' 
		AND contrasena = '".$_GET['contrasena']."'
	";										// Compruebo si el usuario enviado existe en la base de datos
	$result = mysqli_query($mysqli, $query);					// Ejecuto la petición contra la base de datos
	if ($row = mysqli_fetch_assoc($result)) {					// en el caso de que exista
		$row['resultado'] = 'ok';						// Le añado una propiedad resultado y le digo que es ok
	    echo json_encode($row);							// Le añado además todo lo que viene de la base de datos
	}else{										// en caso de que no exista
		echo '{"resultado:":"ko"}'; 						// Devuelvo al cliente un ko
	}
	
?>
