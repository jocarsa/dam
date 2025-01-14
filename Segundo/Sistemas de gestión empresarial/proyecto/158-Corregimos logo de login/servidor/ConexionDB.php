<?php
	
	class conexionDB{																													// Creo una nueva clase
		
			private $servidor;																										// creo una serie de propiedades privadas
			private $usuario;																											// 
			private $contrasena;																									// 
			private $basededatos;																									// 
			private $conexion;																										// 
			
			public function __construct() {																				// Creo un constructor
				  $this->servidor = "localhost";																			// Le doy los datos de acceso a la base de datos
				  $this->usuario = "crimson";																		// 
				  $this->contrasena = "crimson";																	// 
				  $this->basededatos = "crimson";																// 
				  
				  $this->conexion = mysqli_connect(
							$this->servidor, 
							$this->usuario, 
							$this->contrasena, 
							$this->basededatos
						);																															// Establezco una conexión con la base de datos
			 }
			public function buscar($tabla,$datos){
				$peticion = "SELECT * FROM ".$tabla." WHERE ";
				foreach($datos as $clave=>$valor){
					$peticion .= $clave."='".$valor."' AND "; 
				}
				$peticion .= " 1;";
				//echo $peticion;
				
				
				$resultado = mysqli_query($this->conexion , $peticion);
				$retorno = [];
				while ($fila = mysqli_fetch_assoc($resultado)) {										// Recupero los datos del servidor
					$fila['token'] = base64_encode(date('U'));
					//$fila['token'] = rand();
					$retorno[] = $fila;																			// Hago un push encubierto a las restricciones
					
				}
				
				
				$json = json_encode($retorno, JSON_PRETTY_PRINT);							// Lo codifico como json
				return $json;	
			}
			
			public function buscarSimilar($tabla,$datos){
				$peticion = "SELECT * FROM ".$tabla." WHERE ";
				foreach($datos as $clave=>$valor){
					$peticion .= $clave." LIKE '%".$valor."%' AND "; 
				}
				$peticion .= " 1;";
				//echo $peticion;
				
				
				$resultado = mysqli_query($this->conexion , $peticion);
				$retorno = [];
				while ($fila = mysqli_fetch_assoc($resultado)) {										// Recupero los datos del servidor
					$retorno[] = $fila;																			// Hago un push encubierto a las restricciones
				}
				$json = json_encode($retorno, JSON_PRETTY_PRINT);							// Lo codifico como json
				return $json;	
			}
			
			public function seleccionaTabla($tabla){													// Creo un metodo de seleccion
				$query = "SELECT 
											*
									FROM 
											information_schema.key_column_usage
									WHERE 
											table_name = '".$tabla."'
											AND
											REFERENCED_TABLE_NAME IS NOT NULL
											;";											// Formateo una consulta SQL para ver qué campos tienen restricciones
				
				$result = mysqli_query($this->conexion , $query);								// Ejecuto la consulta contra la base de datos	
				$restricciones = [];																						// Creo un array vacio para guardar las restricciones
				while ($row = mysqli_fetch_assoc($result)) {										// Recupero los datos del servidor
					$restricciones[] = $row;																			// Hago un push encubierto a las restricciones
				}
				
				//var_dump($restricciones);																				// Las debugeo en pantalla
				
				$query = "SELECT * FROM ".$tabla.";";														// Creo la petición dinámica
				$result = mysqli_query($this->conexion , $query);								// Ejecuto la peticion
				$resultado = [];																								// Creo un array vacio
				while ($row = mysqli_fetch_assoc($result)) {										// PAra cada uno de los registros
						
						//$resultado[] = $row;																			// Los añado al array
						$fila = [];																									// Creo el conjunto de datos para cada fila
						foreach($row as $clave=>$valor){														// PAra cada una de las columnas
							$identificador = 1;
							$pasas = true;																						// En principio asumimos que no hay restriccion
							foreach($restricciones as $restriccion){									// Para cada una de las restricciones
								if($clave == "Identificador"){
									$identificador = $valor;
								}
								if($clave == $restriccion["COLUMN_NAME"]){							// En el caso de que se detecte que esta columna forma parte de las restricciones
									
									$query2 = "
										SELECT * 
										FROM ".$restriccion["REFERENCED_TABLE_NAME"]."
										WHERE Identificador = ".$identificador."
									;";
									$result2 = mysqli_query($this->conexion , $query2);
									$cadena = "";
									while ($row2 = mysqli_fetch_assoc($result2)) {
										foreach($row2 as $campo){
											$cadena .= $campo."-";
										}
									}
									
									$fila[$clave] = $cadena;															// En la celda devolvemos un string tontorron
									$pasas = false;																				// Cambiamos el estado de la variable a falso
								}
							}
						if($pasas == true){																					// en el caso de que la variable siga siendo verdadera
							$fila[$clave] = $valor;																		// En ese caso el valor de la variable es el valor real de la tabla
						}
						}
						$resultado[] = $fila;		
				}
				$json = json_encode($resultado, JSON_PRETTY_PRINT);							// Lo codifico como json
				return $json;																										// Devuelvo el json
			}
			
			public function listadoTablas(){
				$query = "
					SELECT 
							table_name AS 'Tables_in_".$this->basededatos."', 
							table_comment AS 'Comentario'
					FROM 
							information_schema.tables
					WHERE 
							table_schema = '".$this->basededatos."';
				";																				// Creo la petición dinámica
				//echo $query;
				$result = mysqli_query($this->conexion , $query);								// Ejecuto la peticion
				$resultado = [];																								// Creo un array vacio
				while ($row = mysqli_fetch_assoc($result)) {										// PAra cada uno de los registros
						//$resultado[] = $row;																			// Los añado al array
						$fila = [];
						foreach($row as $clave=>$valor){
							$fila[$clave] = $valor;
						}
						$resultado[] = $fila;
				}
				$json = json_encode($resultado, JSON_PRETTY_PRINT);							// Lo codifico como json
				return $json;																										// Devuelvo el json
			}
			
			public function listadoTablasAplicacion($aplicacion){
				$query = "
				
				SELECT 
					 ist.table_name AS 'Tables_in_".$this->basededatos."',
					 ist.table_comment AS 'Comentario',
					 ta.tabla AS 'Tabla_de_Aplicación'
				FROM 
					 information_schema.tables AS ist
				LEFT JOIN 
					 tablasaplicaciones AS ta
				ON 
					 ist.table_name = ta.tabla
				LEFT JOIN 
					 aplicaciones AS ap
				ON 
					 ta.aplicaciones_nombre = ap.Identificador
				WHERE 
					 ist.table_schema = '".$this->basededatos."'
					 AND ap.nombre = '".$aplicacion."';
				";																				// Creo la petición dinámica
				//echo $query;
				$result = mysqli_query($this->conexion , $query);								// Ejecuto la peticion
				$resultado = [];																								// Creo un array vacio
				while ($row = mysqli_fetch_assoc($result)) {										// PAra cada uno de los registros
						//$resultado[] = $row;																			// Los añado al array
						$fila = [];
						foreach($row as $clave=>$valor){
							$fila[$clave] = $valor;
						}
						$resultado[] = $fila;
				}
				$json = json_encode($resultado, JSON_PRETTY_PRINT);							// Lo codifico como json
				return $json;																										// Devuelvo el json
			}
			
			public function listadoAplicacionesUsuario($usuario){
				$query = "
				
				SELECT 

				aplicaciones.nombre

				FROM usuarios

				LEFT JOIN departamentos
				ON usuarios.departamentos_nombre = departamentos.Identificador

				LEFT JOIN departamentosaplicaciones
				ON departamentosaplicaciones.departamentos_nombre = departamentos.Identificador

				LEFT JOIN aplicaciones
				ON departamentosaplicaciones.aplicaciones_nombre = aplicaciones.Identificador

				WHERE usuarios.usuario = '".$usuario."'

				";																				// Creo la petición dinámica
				//echo $query;
				$result = mysqli_query($this->conexion , $query);								// Ejecuto la peticion
				$resultado = [];																								// Creo un array vacio
				while ($row = mysqli_fetch_assoc($result)) {										// PAra cada uno de los registros
						//$resultado[] = $row;																			// Los añado al array
						$fila = [];
						foreach($row as $clave=>$valor){
							$fila[$clave] = $valor;
						}
						$resultado[] = $fila;
				}
				$json = json_encode($resultado, JSON_PRETTY_PRINT);							// Lo codifico como json
				return $json;																										// Devuelvo el json
			}
			
			public function columnasTabla($tabla){
				$query = "SHOW COLUMNS FROM ".$tabla.";";																				// Creo la petición dinámica
				$result = mysqli_query($this->conexion , $query);								// Ejecuto la peticion
				$resultado = [];																								// Creo un array vacio
				while ($row = mysqli_fetch_assoc($result)) {										// PAra cada uno de los registros
						//$resultado[] = $row;																			// Los añado al array
						$fila = [];
						foreach($row as $clave=>$valor){
							$fila[$clave] = $valor;
						}
						$resultado[] = $fila;
				}
				$json = json_encode($resultado, JSON_PRETTY_PRINT);							// Lo codifico como json
				return $json;																										// Devuelvo el json
			}
			
			public function obtenRegistro($tabla,$id){
				$query = "SELECT * FROM ".$tabla." WHERE Identificador = ".$id.";";																				// Creo la petición dinámica
				$result = mysqli_query($this->conexion , $query);								// Ejecuto la peticion
				$resultado = [];																								// Creo un array vacio
				while ($row = mysqli_fetch_assoc($result)) {										// PAra cada uno de los registros
						//$resultado[] = $row;																			// Los añado al array
						$fila = [];
						foreach($row as $clave=>$valor){
							$fila[$clave] = $valor;
						}
						$resultado[] = $fila;
				}
				$json = json_encode($resultado, JSON_PRETTY_PRINT);							// Lo codifico como json
				return $json;																										// Devuelvo el json
			}
			

		  public function insertaTabla($tabla, $valores) {
			 $campos = "";
			 $parametros = "";
			 $tipos = "";
			 $datos = [];

			 foreach ($valores as $clave => $valor) {
				  if (is_array($valor)) {
				      echo "Error: El valor de '$clave' es un array y no se puede convertir a string.";
				      return;
				  }
				  
				  $campos .= $clave . ",";
				  $parametros .= "?,";

				  if (isset($_FILES[$clave])) {
				      $tipos .= "b";
				      $datos[] = file_get_contents($_FILES[$clave]['tmp_name']);
				  } else {
				      $tipos .= "s";
				      $datos[] = $valor;
				  }
			 }

			 // Validación para asegurarse de que hay tipos y datos antes de continuar
			 if (empty($tipos) || empty($datos)) {
				  echo "Error: No se recibieron datos válidos para insertar.";
				  return;
			 }

			 $campos = rtrim($campos, ",");
			 $parametros = rtrim($parametros, ",");

			 $query = "INSERT INTO $tabla ($campos) VALUES ($parametros)";
			 $stmt = $this->conexion->prepare($query);

			 if ($stmt === false) {
				  die("Error en la preparación de la consulta: " . $this->conexion->error);
			 }

			 $stmt->bind_param($tipos, ...$datos);

			 foreach ($datos as $index => $dato) {
				  if ($tipos[$index] === "b") {
				      $stmt->send_long_data($index, $dato);
				  }
			 }

			 if ($stmt->execute()) {
				  echo "Inserción exitosa en la tabla $tabla.";
			 } else {
				  echo "Error al insertar en la tabla $tabla: " . $stmt->error;
			 }

			 $stmt->close();
		}
			
			public function actualizaTabla($tabla,$valores,$id){
					$query = "
						UPDATE ".$tabla." 
						SET
						";																													// Empiezo a formatear la query de actualización
					foreach($valores as $clave=>$valor){													// Para cada uno de los datos
						$query .= $clave."='".$valor."', ";													// Encadeno con la query
					}
					$query = substr($query, 0, -2);																// Le quito los dos ultimos caracteres
						$query .= "
						WHERE Identificador = ".$id."
						";																													// preparo la petición de inserción
					echo $query;
					$result = mysqli_query($this->conexion , $query);							// Ejecuto la peticion
					return "";							
			}
			public function actualizar($datos){														// Método de actualizar un solo campo en la tabla
					
					$query = "
						UPDATE ".$datos['tabla']." 
						SET ".$datos['columna']." = '".$datos['valor']."'
						
						WHERE Identificador = ".$datos['Identificador']."
						";																													// preparo la petición de inserción
					//echo $query;
					$result = mysqli_query($this->conexion , $query);							// Ejecuto la peticion
					return '{"mensaje":"ok"}';							
			}
			public function eliminaTabla($tabla,$id){
				$query = "
						DELETE FROM ".$tabla." 
						WHERE Identificador = ".$id.";
						";	
				$result = mysqli_query($this->conexion , $query);							// Ejecuto la peticion
			}
			
			private function codifica($entrada){
				return base64_encode($entrada);
			}
			
			private function decodifica($entrada){
				return base64_decode($entrada);
			}
			public function contarFilasTablas() {
    // Get the list of tables in the database
    $query = "
        SELECT 
            table_name 
        FROM 
            information_schema.tables
        WHERE 
            table_schema = '".$this->basededatos."';
    ";

    $result = mysqli_query($this->conexion, $query);
    if (!$result) {
        die("Error al recuperar las tablas: " . mysqli_error($this->conexion));
    }

    $datos = [];

    // Loop through each table and count its rows
    while ($row = mysqli_fetch_assoc($result)) {
    
        

        $tabla = $row['TABLE_NAME'];
        $queryCount = "SELECT COUNT(*) AS total FROM `$tabla`;";
        $resultCount = mysqli_query($this->conexion, $queryCount);

        if (!$resultCount) {
            die("Error al contar filas en la tabla $tabla: " . mysqli_error($this->conexion));
        }

        $count = mysqli_fetch_assoc($resultCount)['total'];
        $datos[] = ["texto" => $tabla, "valor" => (int)$count];
    }

    // Encode the result as a JSON string
    $json = json_encode($datos, JSON_PRETTY_PRINT);
    return $json;
}

	}

?>
