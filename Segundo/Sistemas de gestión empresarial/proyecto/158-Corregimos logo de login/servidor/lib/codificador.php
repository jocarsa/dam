<?php

	class JVCodifica {

		 public function codifica($entrada) {
		     // Realiza un desplazamiento de +5 en los caracteres
		     $salida = '';
		     for ($i = 0; $i < strlen($entrada); $i++) {
		         $salida .= chr(ord($entrada[$i]) + 5);
		     }

		     // Aplica codificación Base64 tres veces
		     $salida = base64_encode(base64_encode(base64_encode($salida)));

		     return $salida;
		 }

		 public function descodifica($entrada) {
		     // Decodifica la cadena Base64 tres veces
		     $entrada = base64_decode(base64_decode(base64_decode($entrada)));

		     // Realiza un desplazamiento de -5 en los caracteres
		     $salida = '';
		     for ($i = 0; $i < strlen($entrada); $i++) {
		         $salida .= chr(ord($entrada[$i]) - 5);
		     }

		     return $salida;
		 }
	}

?>
