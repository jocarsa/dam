<?php

// Este archivo inserta los campos que vienen del formulario
var_dump($_POST);
echo "<br>";
var_dump($_FILES);
echo "<br>";
include "../utilidades/error.php";                           // Incluyo los mensajes de error
include "../config/config.php";                          // Traigo la conexión a la base de datos

$peticion = "
INSERT INTO 
".$_GET['tabla']." 
VALUES("; 

// Recorre las claves de `$_POST` y maneja los valores
foreach (array_keys($_POST) as $clave) {
    if ($clave == "Identificador") {
        $peticion .= "NULL,";
    } else {
        $peticion .= "'".$conexion->real_escape_string($_POST[$clave])."',";
    }
}

// Recorre las claves de `$_FILES` para manejar archivos
foreach ($_FILES as $clave => $archivo) {
    var_dump($archivo);
    if ($archivo['error'] !== UPLOAD_ERR_OK) {
        echo "Error en la subida del archivo. Código de error: " . $archivo['error'];
        continue;
    }

    // Procesa el archivo y guárdalo en la carpeta "static"
    $uploadDir = "../../static/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true); // Crea la carpeta si no existe
    }

    $fileTmpName = $archivo['tmp_name'];
    $fileName = basename($archivo['name']);
    $targetPath = $uploadDir . $fileName;

    if (move_uploaded_file($fileTmpName, $targetPath)) {
        // Guarda solo el nombre del archivo en la base de datos
        $peticion .= "'".$conexion->real_escape_string($fileName)."',";
    } else {
        echo "Error al mover el archivo al directorio de destino.";
    }
}

// Elimina la última coma
$peticion = substr($peticion, 0, -1);
$peticion .= ")";

// Ejecuta la consulta
echo "Consulta SQL: ".$peticion."<br>"; // Para depuración
$resultado = $conexion->query($peticion);

if (!$resultado) {
    echo "Error en la inserción: " . $conexion->error;
} else {
    echo "Inserción realizada con éxito.";
}

?>
<meta http-equiv="refresh" content="5; url=../escritorio.php">

