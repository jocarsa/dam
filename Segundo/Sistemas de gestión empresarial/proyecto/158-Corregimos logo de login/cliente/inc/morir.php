<?php
	include "esfirefox.php";
	include "bloqueoip.php";
	include "blacklist.php";
	include "whitelist.php";
	$filename = 'lock.txt';
	if (file_exists($filename)) {
		die("
		<style>
		     body {
		         margin: 0;
		         display: flex;
		         justify-content: center;
		         align-items: center;
		         height: 100vh;
		         background-color: #f0f0f0; /* Optional: for better visibility */
		     }
		     #candado {
		         font-size: 150px; /* Adjust size if needed */
		     }
		 </style>
		<div id='candado'>🔒</div>
	");
	}

?>
