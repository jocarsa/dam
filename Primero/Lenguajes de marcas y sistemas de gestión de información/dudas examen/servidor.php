<?php

include "muerte.php";

$servername = "localhost";
$username = "ataque";
$password = "ataque";
$database = "ataque";

$conexion = mysqli_connect($servername, $username, $password, $database);

// Recibir los datos de la solicitud POST
$datos_json = file_get_contents("php://input");
// Decodificar los datos JSON
$datos = json_decode($datos_json, true);

muerte();

// Mostrar los datos con var_dump
foreach($datos as $dato){
	$sql = $dato;
	$result = mysqli_query($conexion, $sql);
	echo "voy a ejecutar: ".$dato."<br>";
}
?>

