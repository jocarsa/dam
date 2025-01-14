<?php if(isset($_GET['documento'])){?>
	<style>
		.moneda{
		 	text-align:right;
		}
	</style>
	<?php
	// Load and decode JSON data
	$jsonData = file_get_contents('../basededatos/pedidos/'.$_GET['documento']); // Ensure your JSON file is named 'data.json' and placed in the same directory
	$data = json_decode($jsonData, true);

	// Extract data
	$cliente = $data['cliente'];
	$pedido = $data['pedido'];
	$productos = $data['productos'];
	?>

	<!DOCTYPE html>
	<html lang="en">
	<head>
		 <meta charset="UTF-8">
		 <meta name="viewport" content="width=device-width, initial-scale=1.0">
		 <title>Pedido <?php echo htmlspecialchars($pedido['numerodepedido']); ?> - <?php echo htmlspecialchars($cliente['nombre'] . ' ' . $cliente['apellidos']); ?></title>
		 <style>
		     table {
		         width: 100%;
		         border-collapse: collapse;
		     }
		     th, td {
		         border: 1px solid #ddd;
		         padding: 8px;
		     }
		     th {
		         background-color: #f2f2f2;
		     }
		 </style>
	</head>
	<body>

	<h1>Pedido</h1>
	<table>
		 <tr>
		     <td width="50%">
		         <h2>Emisor</h2>
		         <h3>JOCARSA - Jose Vicente Carratala</h3>
		         <p>Calle de Jose Vicente</p>
		         <p>46000 Valencia</p>
		         <p>54352345J</p>
		         <p>info@jocarsa.com</p>
		     </td>
		     <td>
		         <h2>Receptor</h2>
		         <h3><?php echo htmlspecialchars($cliente['nombre'] . ' ' . $cliente['apellidos']); ?></h3>
		         <p>Calle del cliente</p>
		         <p>Codigo postal y poblacion</p>
		         <p>DNI</p>
		         <p><?php echo htmlspecialchars($cliente['email']); ?></p>
		     </td>
		 </tr>
		 <tr>
		     <td>
		         <h2>Fecha de la factura</h2>
		         <p><?php echo htmlspecialchars($pedido['fecha']); ?></p>
		     </td>
		     <td>
		         <h2>Número de la factura</h2>
		         <p><?php echo htmlspecialchars($pedido['numerodepedido']); ?></p>
		     </td>
		 </tr>
		 <tr>
		     <td colspan="2">
		         <h2>Lineas de pedido</h2>
		     </td>
		 </tr>
	</table>
	<table>
		 <tr>
		     <th>Nombre</th>
		     <th>Descripcion</th>
		     <th>Precio</th>
		 </tr>
		 <?php
		 $total = 0;
		 foreach ($productos as $producto) {
		     $total += floatval($producto['precio']);
		     echo "<tr>";
		     echo "<td>" . htmlspecialchars($producto['nombre']) . "</td>";
		     echo "<td>" . htmlspecialchars($producto['descripcion']) . "</td>";
		     echo "<td class='moneda'>" . htmlspecialchars(number_format($producto['precio'], 2)) . " €</td>";
		     echo "</tr>";
		 }
		 ?>
	</table>
	<table id="tablapie">
		 <tr>
		     <td><strong>Total</strong></td>
		     <td class='moneda'><strong><?php echo htmlspecialchars(number_format($total, 2)); ?> €</strong></td>
		 </tr>
	</table>

	</body>
	</html>

		
<?php } ?>
