<?php
	if(!isset($_GET['tabla'])){
		$tabla = "clientes";
	}else{
		$tabla = $_GET['tabla'];
	}
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);			// Establezco el nivel de retorno de errores de PHP
	$mysqli = mysqli_connect("localhost", "crimson", "crimson", "crimson");		// Me conecto a la base de datos
	$query = "
		DELETE FROM ".$_GET['tabla']." WHERE Identificador = ".$_GET['id'].";
	";										// Compruebo si el usuario enviado existe en la base de datos
	$result = mysqli_query($mysqli, $query);					// Ejecuto la petición contra la base de datos
	$aplicaciones = [];								// Creo un array vacio
	while ($row = mysqli_fetch_assoc($result)) {					// en el caso de que exista
		$aplicaciones[] = $row;							// Añado nueva aplicacioń al array
	}
	echo json_encode($aplicaciones);
	
?>
