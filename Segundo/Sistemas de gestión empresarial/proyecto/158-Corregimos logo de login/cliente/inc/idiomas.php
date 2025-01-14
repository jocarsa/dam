<?php
	$idioma = explode(",",$_SERVER['HTTP_ACCEPT_LANGUAGE'])[0];
	//echo $idioma;
	$jsonFile = 'traducciones/'.$idioma.'.json';
	$jsonContent = file_get_contents($jsonFile);
	$idioma = json_decode($jsonContent, true); 
?>
