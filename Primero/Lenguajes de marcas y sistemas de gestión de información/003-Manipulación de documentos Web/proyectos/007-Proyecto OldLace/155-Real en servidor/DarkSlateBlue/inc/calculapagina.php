<?php
	if(isset($_GET['pagina'])){
		if($_GET['pagina'] == 0){$_SESSION['pagina'] = 0;}
		if($_GET['pagina'] == "siguiente"){$_SESSION['pagina']++;}
		if($_GET['pagina'] == "anterior"){$_SESSION['pagina']--;}
	}
?>
