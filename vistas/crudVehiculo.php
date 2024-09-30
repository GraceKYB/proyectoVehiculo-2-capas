<?php

include './conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nombre'];
    $mod = $_POST['modelo'];
    $mar = $_POST['marca'];
    $col = $_POST['color'];
    
    $anio = $_POST['anio'];
    $pre = $_POST['precio'];

    try {
        // Iniciar transacción
        $conexion->beginTransaction();

        // Registrar el vehículo
        $sql = "INSERT INTO vehiculo(nom_vehiculo, mod_vehiculo, mar_vehiculo, col_vehiculo, anio_vehiculo, pre_vehiculo) 
                VALUES(:nombre, :modelo, :marca, :color, :anio, :precio)";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':nombre', $nom);
        $stmt->bindParam(':modelo', $mod);
        $stmt->bindParam(':marca', $mar);
        $stmt->bindParam(':color', $col);
        $stmt->bindParam(':anio', $anio);
        $stmt->bindParam(':precio', $pre);
        $stmt->execute();

        // Obtener el ID del vehículo registrado
        $vehiculoId = $conexion->lastInsertId();

        // Manejar la subida de múltiples imágenes
        if (isset($_FILES["imagenes"])) {
            $carpetaDestino = "./img/";
            if (!is_dir($carpetaDestino)) {
                mkdir($carpetaDestino, 0755, true);
            }

            foreach ($_FILES["imagenes"]["tmp_name"] as $key => $tempArchivo) {
                $nombreArchivo = $_FILES["imagenes"]["name"][$key];
                $tipoArchivo = $_FILES["imagenes"]["type"][$key];
                $tamanioArchivo = $_FILES["imagenes"]["size"][$key];

                if (($tipoArchivo == "image/jpeg" || $tipoArchivo == "image/png" || $tipoArchivo == "image/gif") && $tamanioArchivo <= 5000000) {
                    if (move_uploaded_file($tempArchivo, $carpetaDestino . $nombreArchivo)) {
                        $pathArchivo = $carpetaDestino . $nombreArchivo;

                        $sqlImg = "INSERT INTO imagen_vehiculo (id_vehiculo, ruta_img_veh) VALUES (:id_vehiculo, :path)";
                        $stmtImg = $conexion->prepare($sqlImg);
                        $stmtImg->bindParam(':id_vehiculo', $vehiculoId);
                        $stmtImg->bindParam(':path', $pathArchivo);
                        $stmtImg->execute();
                    } else {
                        throw new Exception('Error al mover el archivo: ' . $nombreArchivo);
                    }
                } else {
                    throw new Exception('Error de archivo o formato excedido para el archivo: ' . $nombreArchivo);
                }
            }

            // Confirmar transacción
            $conexion->commit();

            echo '<script> alert("Registro creado con exito")</script>';
            echo '<script> window.location="../vistas/index.php"</script>';
        }
    } catch (Exception $e) {
        // Revertir transacción en caso de error
        $conexion->rollBack();
        echo "Error al guardar: " . $e->getMessage();
    }
}

?>