<?php

	//include "lib/sanear.php";
	//sanear($_REQUEST);
	$json = file_get_contents('php://input');                   								// Recojo los datos que vienen en json desde la petición del cliente
   $datos = json_decode($json, true);
	//sanear($datos);
	
	include "lib/fuerzabruta.php";
	include "lib/codificador.php";
	ini_set('display_errors', 1);																								// Activo errores
	ini_set('display_startup_errors', 1);																				// Activo errores de inicio
	error_reporting(E_ALL);																											// 

	include "ConexionDB.php";	
	include "ConectaMongo.php";																									// incluyo el archivo en el cual se encuentra la clase

	$conexion = new conexionDB();
	$conexionmongo = new ConectaMongo();
																								// Creo una nueva instancia de la clase
	if(isset($_GET['o'])){
		switch($_GET['o']){
			case "compruebatoken":
			//echo $_GET['token'];
			if(is_numeric(base64_decode($_GET['token']))){
				if(
					(abs(base64_decode($_GET['token']) - date('U')) < 3600)
				){
					echo '{"resultado":"ok"}';
				}else{
					echo '{"resultado":"ko"}';
				}
				}else{
					echo '{"resultado":"ko"}';	
				}
				break;
			case "listadoaplicacionesusuario":
				echo $conexion->listadoAplicacionesUsuario($_GET['usuario']);																						// Llamo a un metodo
				break;
			case "listatablas":
				echo $conexion->listadoTablas();																						// Llamo a un metodo
				break;
			case "listatablasaplicacion":
				echo $conexion->listadoTablasAplicacion($_GET['aplicacion']);																						// Llamo a un metodo
				break;
			case "estadisticastablas":
				echo $conexion->contarFilasTablas();																						// Llamo a un metodo
				break;
			case "listacolecciones":
				echo $conexionmongo->listarColecciones();																						// Llamo a un metodo
				break;
			case "listadocumentos":
				echo $conexionmongo->listar($_GET['coleccion']);																						// Llamo a un metodo
				break;
			case "eliminadocumento":
				 if (isset($_GET['coleccion']) && isset($_GET['id'])) {
					  echo $conexionmongo->eliminar($_GET['coleccion'], $_GET['id']); // Call the class method
				 } else {
					  echo json_encode(["error" => "Parámetros 'coleccion' e 'id' son requeridos."]);
				 }
				 break;
			case "informe":
				$misdatos = $conexion->obtenRegistro($_GET['tabla'],$_GET['id']); // Obtiene los datos de la tabla
				 $misdatos = json_decode($misdatos, true); // Decodifica el JSON en un array asociativo

				 if (!is_array($misdatos)) {
					  echo json_encode(["error" => "Datos no válidos recibidos de seleccionaTabla."]);
					  break;
				 }
				/*
				 $codificador = new JVCodifica(); // Instancia la clase de codificación/descodificación

				 foreach ($misdatos as &$fila) { // Itera sobre cada fila de los datos
					  foreach ($fila as $clave => &$valor) { // Itera sobre cada clave-valor de la fila
						   if ($clave != "Identificador" && !empty($valor)) { // Exceptúa la clave "Identificador" y valores vacíos
						       $valor = $codificador->descodifica($valor); // Descodifica el valor
						   }
					  }
				 }
				*/
				 echo json_encode($misdatos, JSON_PRETTY_PRINT);
				break;
			case "tabla":
				 $misdatos = $conexion->seleccionaTabla($_GET['tabla']); // Obtiene los datos de la tabla
				 $misdatos = json_decode($misdatos, true); // Decodifica el JSON en un array asociativo

				 if (!is_array($misdatos)) {
					  echo json_encode(["error" => "Datos no válidos recibidos de seleccionaTabla."]);
					  break;
				 }
				/*
				 $codificador = new JVCodifica(); // Instancia la clase de codificación/descodificación

				 foreach ($misdatos as &$fila) { // Itera sobre cada fila de los datos
					  foreach ($fila as $clave => &$valor) { // Itera sobre cada clave-valor de la fila
						   if ($clave != "Identificador" && !empty($valor)) { // Exceptúa la clave "Identificador" y valores vacíos
						       $valor = $codificador->descodifica($valor); // Descodifica el valor
						   }
					  }
				 }
				*/
				 echo json_encode($misdatos, JSON_PRETTY_PRINT); // Devuelve los datos descodificados como JSON
				 break;
			case "columnastabla":
				echo $conexion->columnasTabla($_GET['tabla']);																						// Llamo a un metodo
				break;
			case "eliminar":
				echo $conexion->eliminaTabla($_GET['tabla'],$_GET['id']);																						// Llamo a un metodo
				break;
			case "buscar":
				$json = file_get_contents('php://input');                   								// Recojo los datos que vienen en json desde la petición del cliente
        		$datos = json_decode($json, true);																					// Me aseguro que ese json tenga una forma que PHP pueda entender
				echo $conexion->buscar($_GET['tabla'],$datos);																						// Llamo a un metodo
				break;
			case "actualizar":
				$json = file_get_contents('php://input');                   								// Recojo los datos que vienen en json desde la petición del cliente
        		$datos = json_decode($json, true);																					// Me aseguro que ese json tenga una forma que PHP pueda entender
				echo $conexion->actualizar($datos);																						// Llamo a un metodo
				break;
			case "buscarSimilar":
				$json = file_get_contents('php://input');                   								// Recojo los datos que vienen en json desde la petición del cliente
        		$datos = json_decode($json, true);																					// Me aseguro que ese json tenga una forma que PHP pueda entender
				echo $conexion->buscarSimilar($_GET['tabla'],$datos);																						// Llamo a un metodo
				break;
			case "insertar":
				$json = file_get_contents('php://input');                   								// Recojo los datos que vienen en json desde la petición del cliente
        		var_dump($json);
        		$datos = json_decode($json, true);
        		var_dump($datos);																					// Me aseguro que ese json tenga una forma que PHP pueda entender
        		/*
				$codificador = new JVCodifica();
				foreach($datos as $clave=>$valor){
					if($clave != "Identificador"){
						$datos[$clave] = $codificador->codifica($valor);
					}
				}
				*/
				echo $conexion->insertaTabla($_GET['tabla'],$datos);																						// Llamo a un metodo
				break;
		}
	}
	
	include "lib/registros.php";
	
?>
