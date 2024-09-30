<?php
// Include the database connection
include 'conexion.php';

try {
    // Prepare the SQL query to fetch vehicles and their images
    $query = "
        SELECT v.id_vehiculo, v.nom_vehiculo, v.mod_vehiculo, v.mar_vehiculo, v.col_vehiculo, v.anio_vehiculo, v.pre_vehiculo, i.ruta_img_veh
        FROM vehiculo v
        LEFT JOIN imagen_vehiculo i ON v.id_vehiculo = i.id_vehiculo
    ";

    $stmt = $conexion->prepare($query);
    $stmt->execute();

    // Fetch all the results
    $vehiculos = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $exc) {
    echo "Error al ejecutar la consulta: " . $exc->getMessage();
    $vehiculos = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Vehículos</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        img {
            max-width: 100px;
        }
    </style>
</head>
<body>
    <h1>Listado de Vehículos</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Modelo</th>
                <th>Marca</th>
                <th>Color</th>
                <th>Año</th>
                <th>Precio</th>
                <th>Imagen</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($vehiculos)): ?>
                <?php foreach ($vehiculos as $vehiculo): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($vehiculo['id_vehiculo']); ?></td>
                        <td><?php echo htmlspecialchars($vehiculo['nom_vehiculo']); ?></td>
                        <td><?php echo htmlspecialchars($vehiculo['mod_vehiculo']); ?></td>
                        <td><?php echo htmlspecialchars($vehiculo['mar_vehiculo']); ?></td>
                        <td><?php echo htmlspecialchars($vehiculo['col_vehiculo']); ?></td>
                        <td><?php echo htmlspecialchars($vehiculo['anio_vehiculo']); ?></td>
                        <td><?php echo htmlspecialchars($vehiculo['pre_vehiculo']); ?></td>
                        <td>
                            <?php if (!empty($vehiculo['ruta_img_veh'])): ?>
                                <img src="<?php echo htmlspecialchars($vehiculo['ruta_img_veh']); ?>" alt="Imagen del Vehículo">
                            <?php else: ?>
                                No disponible
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">No hay vehículos disponibles</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
