<?php

$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);
$usuario = $data['usuario'] ?? null;
$terreno = $data['terreno'] ?? null;

 

$db = new SQLite3('sienna.db');

$sql = "CREATE TABLE IF NOT EXISTS terreno (
    usuario TEXT,
    x TEXT,
    y TEXT,
    z TEXT,
    mat TEXT
)";

if ($db->exec($sql)) {
    echo "Tabla 'terreno' creada o ya existía.";
} else {
    echo "Error al crear la tabla: " . $db->lastErrorMsg();
}

$sql = "DELETE FROM terreno WHERE usuario = '".$usuario."'";
	$db->exec($sql);

foreach($terreno as $valor){
	$sql = "INSERT INTO terreno VALUES(
	'".$usuario."',
	'".$valor['x']."',
	'".$valor['y']."',
	'".$valor['z']."',
	'".$valor['mat']."')";
	$db->exec($sql);
}

$db->close();

?>
{"respuesta":"ok"}
