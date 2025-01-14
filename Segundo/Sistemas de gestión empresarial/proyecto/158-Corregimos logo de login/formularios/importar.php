<?php
	
	
	
	$archivo = 'docs/'.$_GET['folder'].'/'.$_GET['file'].'';
	$datos = file_get_contents($archivo);
	$coleccion = json_decode($datos, true);
	var_dump($coleccion);
	echo "<hr>";
	$archivo = 'forms/'.str_replace("/","",$_GET['folder']).'.json';
	$datos = file_get_contents($archivo);
	$formulario = json_decode($datos, true);
	var_dump($formulario);
	echo "<hr>";
	$campos = [];
	$valores = [];
	foreach($coleccion as $clave=>$valor){
		echo $clave." - ".$valor."<br>";
		foreach($formulario as $entidad){
			if($entidad['nombre'] == $clave){
				echo "Existe<br>";
				$tabla = $entidad['tabla'];
				$campo = $entidad['campo'];
				echo "Voy a insertar el $clave en la tabla $tabla y en la columna $campo<br>";
				$campos[] = $campo;
				$valores[] = $valor;
				$tabla = $tabla;
			}
		}
	}
	$conexion = mysqli_connect(
		"localhost", 
		"crimson", 
		"crimson", 
		"crimson"
		);
		$valores_con_comillas = array_map(function($valor) {
			 return "'$valor'";
		}, $valores);
	$peticion =  "INSERT INTO $tabla (".implode(",", $campos).") VALUES (".implode(",", $valores_con_comillas).");";
	echo $peticion;
	mysqli_query($conexion, $peticion);
 ?>
