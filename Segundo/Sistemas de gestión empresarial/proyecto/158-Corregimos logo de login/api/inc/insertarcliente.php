<?php
	
	$peticion = "
            SELECT 
               *
               FROM clavesapi
               WHERE clave = '".$_POST['clave']."'
        ";
        $resultado = mysqli_query($mysqli, $peticion);
        if ($fila = mysqli_fetch_assoc($resultado)) {
        	echo "Acceso correcto, vamos con la inserción";
        }else{
        	die("Error de acceso");
        }
		 if($_SERVER['SERVER_ADDR'] == "192.168.1.210"){
		 
		 }else{
		 	die("Error de IP no admitida");
		 }
			 	// Aqui ponemos la logica de insertar cliente
			 		if(isset($_POST['nombre']) && isset($_POST['apellidos'])){
			 			$peticion = "
				      INSERT INTO 
				      clientes 
				      (nombre,apellidos) 
				      VALUES 
				      (
						   '".$_POST['nombre']."',
						   '".$_POST['apellidos']."'
				      );
				  ";
				  $resultado = mysqli_query($mysqli, $peticion);
			 		}else{
			 			echo "error en la peticion";
			 		}
?>
