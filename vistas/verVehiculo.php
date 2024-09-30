<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles del Vehículo</title>
</head>
<body>
    <h1>Detalles del Vehículo</h1>

    <?php
    include './conexion.php';

    // Obtener el ID del vehículo desde la URL (si se pasa como parámetro)
    $vehiculoId = $_GET['id']; // Suponiendo que estás pasando el ID del vehículo como parámetro en la URL

    // Consultar la información del vehículo
    $sqlConsultaVehiculo = "SELECT * FROM vehiculo WHERE id_vehiculo = :id";
    $stmtConsultaVehiculo = $conexion->prepare($sqlConsultaVehiculo);
    $stmtConsultaVehiculo->bindParam(':id', $vehiculoId);
    $stmtConsultaVehiculo->execute();

    if ($vehiculo = $stmtConsultaVehiculo->fetch(PDO::FETCH_ASSOC)) {
        // Mostrar la información del vehículo
        echo "<h2>{$vehiculo['nom_vehiculo']}</h2>";
        echo "<p>Modelo: {$vehiculo['mod_vehiculo']}</p>";
        echo "<p>Marca: {$vehiculo['mar_vehiculo']}</p>";
        echo "<p>Color: {$vehiculo['col_vehiculo']}</p>";
        echo "<p>Placa: {$vehiculo['pla_vehiculo']}</p>";
        echo "<p>Año: {$vehiculo['anio_vehiculo']}</p>";
        echo "<p>Precio: {$vehiculo['pre_vehiculo']}</p>";

        // Consultar y mostrar las imágenes del vehículo
        $sqlConsultaImagenes = "SELECT ruta_img_veh FROM imagen_vehiculo WHERE id_vehiculo = :id";
        $stmtConsultaImagenes = $conexion->prepare($sqlConsultaImagenes);
        $stmtConsultaImagenes->bindParam(':id', $vehiculoId);
        $stmtConsultaImagenes->execute();

        echo "<h2>Imágenes del Vehículo</h2>";
        while ($imagen = $stmtConsultaImagenes->fetch(PDO::FETCH_ASSOC)) {
            $rutaImagen = $imagen['ruta_img_veh'];
            echo "<img src='$rutaImagen' alt='Imagen de Vehículo'>";
        }
    } else {
        echo "<p>Vehículo no encontrado.</p>";
    }

    ?>

    <br><br>
    <a href="listadoVehiculos.php">Volver al Listado de Vehículos</a>
</body>
</html>
