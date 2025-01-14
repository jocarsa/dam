<?php

/*
	Archivo que hace de enrutador para la API desarrollada para CRIMON.
	Esta API es capaz de comunicarse con otros sistemas 
*/
 
include "inc/error.php";

$mysqli = mysqli_connect("localhost", "crimson", "crimson", "crimson");
if(isset($_GET['o'])){
	switch ($_GET['o']) {
		 case "clientes":
		     include "inc/damepedidos.php";
		     break;
		 case "insertarCliente":
		 		include "inc/insertarcliente.php";
		 		
		 		break;
		 default:
		 	echo "no";
	}
}else{
	echo "no";
}
?>

