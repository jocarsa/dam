<?php
	$datosenviados = $_POST;
	$archivo = 'forms/'.$_POST['formulario'].'.json';
	$datos = file_get_contents($archivo);
	$coleccion = json_decode($datos, true);
	
	foreach($coleccion as $clave=>$valor){
		echo "Límite minimo en el json:".$valor['min']."<br>";
		echo  "Dato enviado desde el formulario:".$datosenviados[$coleccion[$clave]["nombre"]]."<br>";
		
		if(strlen($datosenviados[$coleccion[$clave]["nombre"]]) > $valor['min']){
			echo "es ok<br>";
		}else{
			die("Intento de ataque detectado");
		}
		echo "<hr>";
	}
	mkdir('docs/'.$_POST['formulario'],0777);
	file_put_contents(
		"docs/".$_POST['formulario']."/".date('U').".json",
		 json_encode($_POST, JSON_PRETTY_PRINT)
	 );
?>
