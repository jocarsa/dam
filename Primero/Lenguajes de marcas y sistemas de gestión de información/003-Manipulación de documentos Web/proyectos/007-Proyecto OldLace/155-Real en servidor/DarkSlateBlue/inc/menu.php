<?php

/* 
	Este archivo carga las entradas del menu de la izquierda
	Este archivo genera elementos de lista que tienen un hipervinculo	
*/

//include "utilidades/error.php";                           // Incluyo los mensajes de error
include "config/config.php";                          // Traigo la conexión a la base de datos

$peticion = "SHOW TABLES in ".$base;			// Quiero todas las tablas de la base de datos
//echo $peticion;
$resultado = $conexion->query($peticion);				// Ejecuto la petición contra la base de datos

while ($fila = $resultado->fetch_assoc()) {			// Para cada uno de los resultados
	echo "
		<li>
			<a href='?tabla=".$fila['Tables_in_'.$base]."'>
				".$fila['Tables_in_'.$base]."
			</a>
		</li>
	";																// Pongo un elemento nuevo del menu
}
