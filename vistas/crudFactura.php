<?php

include './conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idCliente = $_POST['idCliente'];
    $vehiculos = isset($_POST['vehiculos']) ? $_POST['vehiculos'] : [];
    $cantidades = isset($_POST['cantidades']) ? $_POST['cantidades'] : [];

    $placas = isset($_POST['placas']) ? $_POST['placas'] : [];
    $totalItems = isset($_POST['totalItems']) ? $_POST['totalItems'] : [];
    $subtotal = $_POST['subtotal'];
    $subtotalIva = $_POST['subtotalIva'];
    $total = $_POST['total']; 

    try {
        // Iniciar transacción
        $conexion->beginTransaction();
        // Insertar en la tabla compra
        $sqlInsertCompra = "INSERT INTO compra (id_cliente, fecha_comp) VALUES (:id_cliente, NOW())";
        $stmtInsertCompra = $conexion->prepare($sqlInsertCompra);
        $stmtInsertCompra->bindParam(':id_cliente', $idCliente, PDO::PARAM_INT);
//        $stmtInsertCompra->bindParam(':subtotal', $subtotal);
//        $stmtInsertCompra->bindParam(':subtotalIva', $subtotalIva);
//        $stmtInsertCompra->bindParam(':total', $total);
        $stmtInsertCompra->execute();
        $idCompra = $conexion->lastInsertId();

        $contador = 0;

        foreach ($vehiculos as $idVehiculo) {
            $sqlVehiculo = "SELECT * FROM vehiculo WHERE id_vehiculo = :id_vehiculo";
            $stmtVehiculo = $conexion->prepare($sqlVehiculo);
            $stmtVehiculo->bindParam(':id_vehiculo', $idVehiculo, PDO::PARAM_INT);
            $stmtVehiculo->execute();
            $vehiculo = $stmtVehiculo->fetch(PDO::FETCH_ASSOC);

            $v_unitario = $vehiculo['pre_vehiculo'];
            $cantidad = $cantidades[$contador];
            $v_total = $totalItems[$contador];
            $placa = $placas[$contador];
            // Insertar en la tabla compra_detalle  
            $sqlDetalle = "INSERT INTO compra_detalle (id_comp, id_vehiculo, v_unitario, cantidad, v_total, placa) 
                                   VALUES (:id_comp, :id_vehiculo, :v_unitario, :cantidad, :v_total, :placa)";
            $stmtDetalle = $conexion->prepare($sqlDetalle);
            $stmtDetalle->bindParam(':id_comp', $idCompra, PDO::PARAM_INT);
            $stmtDetalle->bindParam(':id_vehiculo', $idVehiculo, PDO::PARAM_INT);
            $stmtDetalle->bindParam(':v_unitario', $v_unitario);
            $stmtDetalle->bindParam(':cantidad', $cantidad);
            $stmtDetalle->bindParam(':v_total', $v_total);
            $stmtDetalle->bindParam(':placa', $placa);
            $stmtDetalle->execute();
            $stock = $vehiculo['stock'] - 1;
            // Actualizar stock
            $sqlUpdateStock = "UPDATE vehiculo SET stock = :stock WHERE id_vehiculo = :id_vehiculo";
            $stmtUpdateStock = $conexion->prepare($sqlUpdateStock);
            $stmtUpdateStock->bindParam(':stock', $stock, PDO::PARAM_INT);
            $stmtUpdateStock->bindParam(':id_vehiculo', $idVehiculo, PDO::PARAM_INT);
            $stmtUpdateStock->execute();

            $contador = $contador + 1;
        }
        // Confirmar transacción
        $conexion->commit();
        echo '<script> alert("Registro creado con existo..")</script>';
        echo '<script> window.location="../vistas/index.php"</script>';
    } catch (Exception $e) {
        // Revertir transacción en caso de error
        $conexion->rollBack();
        echo "Error al guardar: " . $e->getMessage();
    }
}
?>