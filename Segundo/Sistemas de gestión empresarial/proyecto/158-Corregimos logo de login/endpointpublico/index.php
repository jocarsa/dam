<?php
// Set headers to allow cross-origin requests
header("Access-Control-Allow-Origin: *"); // Allow requests from any origin
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Specify allowed HTTP methods
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Specify allowed headers
?>

<?php

ini_set('display_errors', 1);																								// Activo errores
	ini_set('display_startup_errors', 1);																				// Activo errores de inicio
	error_reporting(E_ALL);	
	
$mysqli = mysqli_connect("localhost", "crimsonleer", "crimsonleer", "crimson");

$peticion = "SELECT * FROM productos";

$resultado = mysqli_query($mysqli, $peticion);

$json = [];
while ($fila = mysqli_fetch_assoc($resultado)) {
    $json[] = $fila;
}
$json = json_encode($json, JSON_PRETTY_PRINT);
echo $json;

?>
