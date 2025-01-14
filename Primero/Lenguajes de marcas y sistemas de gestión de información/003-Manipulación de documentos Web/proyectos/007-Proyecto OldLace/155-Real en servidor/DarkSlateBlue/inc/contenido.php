<?php

// Este archivo carga el contenido interno de la tabla

//include "utilidades/error.php";                           // Incluyo los mensajes de error
include "config/config.php";                          // Traigo la conexión a la base de datos

$peticion = "
	SELECT * 
	FROM ".$_GET['tabla']." 
	LIMIT 10  
	OFFSET ".($_SESSION['pagina']*10)." 
	";															// Selecciono todo de una tabla dinámica
$resultado = $conexion->query($peticion);			// Ejecuto la petición contra la base de datos

while ($fila = $resultado->fetch_assoc()) {		// Para cada resultado obtenido
	$identificador = "";									// Creo una variable llamada identificador
	echo "<tr>";											// Comienzo una fila de tabla
	foreach($fila as $clave=>$valor){				// Para cada uno de los campos
		if($clave == "Identificador"){				// Si la clave es Identificador
			$identificador = $valor;					// A la variable identificador le pongo valor
		}
		if(!str_contains($clave,"imagen")){						// Si el campo es menor que 300 caracteres
  			if(str_contains($clave,"_")){
  				$explotado = explode("_",$clave);
  				$tabla = $explotado[0];
  				$columna = $explotado[1];
  				////////////// SUBCONSULTA ///////////
	  			$peticion2 = "
	  				SELECT ".$columna." 
	  				FROM ".$tabla." 
	  				WHERE Identificador = ".$valor.";";
	  			$resultado2 = $conexion->query($peticion2);
	  			while ($fila2 = $resultado2->fetch_assoc()) {
	  				echo "<td>".$fila2[$columna]."</td>";
	  			}
	  			////////////// SUBCONSULTA ///////////
  			
  			
  			}else{
  				echo "<td
	  				tabla='".$_GET['tabla']."'
	  				columna = '".$clave."'
	  				identificador = '".$identificador."'
	  			>".$valor."</td>";				// Pongo el valor en una columna
  			}
  			
  		}else{												// En caso contrario
  		if($valor == ""){
  		echo "<td>
  			<img src='./img/placeholder.jpg'>
  			</td>";	
  		}else{
  			echo "<td>
  			<img src='../static/".$valor."'>
  			</td>";											// Cargo los datos como imagen y no como texto
  		}
  			
  		}
  	}
  	echo "
	<td>
		<a href='crud/eliminar.php?tabla=".$_GET['tabla']."&Identificador=".$identificador."'>
			<button class='eliminar'>
				X
			</button>
		</a>
	</td>";													// Creo un boton de eliminar con los datos correcto
  echo "</tr>";											// Cierro la fila html
}


$conexion->close();										// Cierro la conexión de base de datos
?>

