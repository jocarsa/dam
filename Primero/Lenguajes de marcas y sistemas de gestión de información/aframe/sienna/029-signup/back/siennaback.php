<?php
/*
	Archivo principal del backend de la aplicación
	Dispone de un router para acoger las llamadas desde el front
	Se encarga de gestionar el contenido de la base de datos
*/


// Creación de tablas en el caso de que no existan

$db = new SQLite3('sienna.db');
// Creo la tabla terreno
$sql = "CREATE TABLE IF NOT EXISTS terreno (
    usuario TEXT,
    x TEXT,
    y TEXT,
    z TEXT,
    mat TEXT
)";

$db->exec($sql);

// Creo la tabla de usuarios
$sql = "CREATE TABLE IF NOT EXISTS usuarios (
    usuario TEXT,
    contrasena TEXT
)";
$db->exec($sql);

$router = $_GET['router'];

switch($router){
	case "actualiza":
		$rawData = file_get_contents("php://input");
		$data = json_decode($rawData, true);
		$usuario = $data['usuario'] ?? null;
		$terreno = $data['terreno'] ?? null;
		
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
		
		break;
	case "login":
		$rawData = file_get_contents("php://input");
		$data = json_decode($rawData, true);
		$usuario = $data['usuario'] ?? null;
		$contrasena = $data['contrasena'] ?? null;
		$sql = "
			SELECT * FROM usuarios 
			WHERE usuario = '".$usuario."' 
			AND contrasena = '".$contrasena."'
		";
		$result = $db->query($sql);
		if ($row = $result->fetchArray(SQLITE3_ASSOC)) {
			 echo '{"resultado":"ok"}';
		}else{
			echo '{"resultado":"ko"}';
		}
		break;
	case "cargaterreno":
		$usuario = $_GET['usuario'];
		$sql = "
			SELECT * FROM terreno 
			WHERE usuario = '".$usuario."' 
		";
		$memoria = [];
		$result = $db->query($sql);
		while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
			 $memoria[] = $row;
		}
		echo json_encode($memoria);

		break;
	case "signup":
		$rawData = file_get_contents("php://input");
		$data = json_decode($rawData, true);
		$usuario = $data['usuario'] ?? null;
		$contrasena = $data['contrasena'] ?? null;
		$sql = "
			INSERT INTO usuarios
			VALUES ('".$usuario."','".$contrasena."'); 
		";
		$db->query($sql);
		echo '{"respuesta":"ok"}';
}


$db->close();

?>
