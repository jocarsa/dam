<?php

	function sanear($elemento){
		//var_dump($elemento);
		$coleccion = [
			'delete', 
			'drop', 
			'truncate',
			'table'
			];
		$entradas = $elemento;
		foreach ($entradas as $clave=>$valor) {
			 
			$entrada = strtolower($clave);
			if (array_filter($coleccion, fn($elemento) => strpos($entrada, $elemento) !== false)) {
				 die('{"resultado":"error 2"}');
			} 
			$entrada = strtolower($valor);
			if (array_filter($coleccion, fn($elemento) => strpos($entrada, $elemento) !== false)) {
				die('{"resultado":"error 2"}');
			} 
			 
		}
	}

?>
