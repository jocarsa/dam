<form action="?" method="POST">
	<input type="text" name="nombre">
	<input type="submit">
</form>
<?php

if(isset($_POST)){
	echo "El nombre que has enviado es:".$_POST['nombre'];
}

?>
