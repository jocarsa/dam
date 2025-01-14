<?php
		$mysqli = mysqli_connect(
		"localhost", 
		"crimson", 
		"crimson", 
		"crimson");																								// Me conecto a la base de datos
		
    
    
    $json = file_get_contents('php://input');									// Atrapo lo que viene de formulario
    
    $data = json_decode($json, true);													// Lo decodifico como json
    
    foreach($data as $clave=>$valor){													// Para cada una de las claves del objeto
    	if($clave == 'tabla'){																	// Siempre que no sea el identificador
        $tabla = $valor;																				// Lo encadeno con la petición SQL
        }
    }
    $peticion = "INSERT INTO ".$tabla." VALUES(NULL,";					// Comienzo a formatear la peticion
    
    foreach($data as $clave=>$valor){													// Para cada una de las claves del objeto
    	if($clave != "Identificador" && $clave != 'tabla'){													// Siempre que no sea el identificador
        $peticion .= "'".$valor."',";													// Lo encadeno con la petición SQL
        }
    }
    $peticion = substr($peticion, 0, -1);											// Le quito la última coma
    
    $peticion .= ");";																				// Le encadeno el último paréntesis
    echo $peticion;																						// Lanzo la petición por pantalla
    $result = mysqli_query($mysqli, $peticion);								// Ejecuto la petición contra la base de datos
?>

