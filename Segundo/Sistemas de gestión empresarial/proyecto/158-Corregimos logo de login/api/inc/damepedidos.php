<?php

	$peticion = "
            SELECT 
                clientes.nombre AS nombre,
                clientes.apellidos AS apellidos,
                pedidos.fecha AS fecha_pedido,
                lineaspedido.productos_nombre AS producto,
                lineaspedido.cantidad AS cantidad
            FROM clientes
            LEFT JOIN pedidos ON clientes.Identificador = pedidos.clientes_nombre
            LEFT JOIN lineaspedido ON pedidos.Identificador = lineaspedido.pedidos_fecha
        ";
        $resultado = mysqli_query($mysqli, $peticion);
        
        $datos = [];
        while ($fila = mysqli_fetch_assoc($resultado)) {
            // Construir la estructura JSON
            $cliente_key = $fila['nombre'] . " " . $fila['apellidos'];
            if (!isset($datos[$cliente_key])) {
                $datos[$cliente_key] = [
                    "cliente" => [
                        "nombre" => $fila['nombre'],
                        "apellidos" => $fila['apellidos']
                    ],
                    "pedidos" => []
                ];
            }

            if ($fila['fecha_pedido']) {
                $pedido_key = $fila['fecha_pedido'];
                if (!isset($datos[$cliente_key]["pedidos"][$pedido_key])) {
                    $datos[$cliente_key]["pedidos"][$pedido_key] = [
                        "fecha" => $fila['fecha_pedido'],
                        "lineaspedido" => []
                    ];
                }

                if ($fila['producto'] && $fila['cantidad']) {
                    $datos[$cliente_key]["pedidos"][$pedido_key]["lineaspedido"][] = [
                        "producto" => $fila['producto'],
                        "cantidad" => $fila['cantidad']
                    ];
                }
            }
        }

        // Reorganizar el array para eliminar índices de cliente y pedidos
        $output = [];
        foreach ($datos as $cliente) {
            $cliente_pedidos = [];
            foreach ($cliente['pedidos'] as $pedido) {
                $cliente_pedidos[] = $pedido;
            }
            $output[] = [
                "cliente" => $cliente['cliente'],
                "pedidos" => $cliente_pedidos
            ];
        }

        echo json_encode($output, JSON_PRETTY_PRINT);
?>
