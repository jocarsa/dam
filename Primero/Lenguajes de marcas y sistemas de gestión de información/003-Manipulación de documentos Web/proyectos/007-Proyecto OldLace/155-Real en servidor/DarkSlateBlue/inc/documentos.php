<?php if(isset($_GET['carpeta'])){?>
	<table>
		<thead>
			<tr>
				<td>Documento</td>
				<td>Operaciones</td>
			</tr>
		</thead>
		<tbody>
			<?php
				$folder = '../basededatos/'.$_GET['carpeta']."/";

				// Check if the folder exists
				if (is_dir($folder)) {
					 // Get all files and directories inside the folder
					 $files = scandir($folder);

					 // Filter out `.` and `..`
					 $files = array_diff($files, array('.', '..'));

					 // Print each file name
					 foreach ($files as $file) {
						  echo "
						  	<tr>
						  		<td>".$file . "</td>
						  		<td>
						  			<a href='?documento=".$file . "'>
						  				<button>
						  					Ver el pedido
						  				</button>
						  			</a>
						  		</td>
						  	</tr>";
					 }
				} else {
					 echo "The folder does not exist.";
				}
				?>
		</tbody>
	</table>
	
<?php } ?>
