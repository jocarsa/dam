<?php
	/*
	Este archivo se llama en el caso de ejecutar un cierre de sesión y es el encargado de en primer lugar iniciar la sesión a continuación destruir la sesión y por último redireccionar al formulario de inicio de sesión 

	*/
	session_start();
	session_destroy();
	header("Location: index.html");
?>
