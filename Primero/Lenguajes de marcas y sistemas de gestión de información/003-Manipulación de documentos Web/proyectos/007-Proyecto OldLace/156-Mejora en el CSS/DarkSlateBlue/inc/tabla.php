<?php if(isset($_GET['tabla'])){?>
	<table>
		<thead>
			<tr>
				<?php include "inc/cabeceras.php"?>
			</tr>
		</thead>
		<tbody>
			<?php include "inc/contenido.php"?>
		</tbody>
	</table>
	<?php include "inc/paginador.php";?>
	<a href="?formulario=<?php echo $_GET['tabla'] ?>">
		<button id="nuevo">+</button>
	</a>
<?php } ?>
