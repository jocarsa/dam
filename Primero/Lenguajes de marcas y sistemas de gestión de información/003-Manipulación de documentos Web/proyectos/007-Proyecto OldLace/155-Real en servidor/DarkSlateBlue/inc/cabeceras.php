<?php

	// Este archivo carga las cabeceras de la tabla

	//include "utilidades/error.php";                           // Incluyo los mensajes de error
	include "config/config.php";                          // Traigo la conexión a la base de datos

	$peticion = "SHOW COLUMNS FROM ".$_GET['tabla'];	// Quiero todas las columnas de una tabla
	$resultado = $conexion->query($peticion);				// Ejecuto la consulta contra la base de datos

	while ($fila = $resultado->fetch_assoc()) {			// Para cada resultado obtenido
	  echo "<td>".$fila['Field']."</td>";					// Creo una columna de la tabla
	}
	echo "
	<td>
		
	</td>"; 
	$conexion->close();											// Cierro la base de datos
?>

