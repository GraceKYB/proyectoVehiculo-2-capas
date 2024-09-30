<?php

include './conexion.php';

// Obtener los parámetros de búsqueda
try {
    $conexion = new PDO("mysql:host=$host;dbname=$nombre_db", $usuario, $contrasena);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exc) {
    echo "Error al conectar a la base de datos: " . $exc->getMessage();
    die();
}

// Obtener los parámetros de búsqueda
$cedula = isset($_GET['cedula']) ? $_GET['cedula'] : '';
$placa = isset($_GET['placa']) ? $_GET['placa'] : '';

$resultados = [];

if ($cedula) {
    // Buscar por cédula
    $sql = "
        SELECT u.*, v.*, cd.*, iv.ruta_img_veh
        FROM usuario u
        JOIN compra c ON u.id_cliente = c.id_cliente
        JOIN compra_detalle cd ON c.id_comp = cd.id_comp
        JOIN vehiculo v ON cd.id_vehiculo = v.id_vehiculo
        LEFT JOIN imagen_vehiculo iv ON v.id_vehiculo = iv.id_vehiculo
        WHERE u.cedula = :cedula
    ";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':cedula', $cedula, PDO::PARAM_STR);
    $stmt->execute();
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
} elseif ($placa) {
    // Buscar por placa
    $sql = "
        SELECT u.*, v.*, cd.*, iv.ruta_img_veh
        FROM usuario u
        JOIN compra c ON u.id_cliente = c.id_cliente
        JOIN compra_detalle cd ON c.id_comp = cd.id_comp
        JOIN vehiculo v ON cd.id_vehiculo = v.id_vehiculo
        LEFT JOIN imagen_vehiculo iv ON v.id_vehiculo = iv.id_vehiculo
        WHERE cd.placa = :placa
    ";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':placa', $placa, PDO::PARAM_STR);
    $stmt->execute();
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados de Búsqueda</title>
    <link rel="stylesheet" href="../estilos/styleBusqueda.css"/>
</head>
<body>
    <h1>Resultados de Búsqueda</h1>
    <?php if ($resultados): ?>
        <ul>
            <?php foreach ($resultados as $resultado): ?>
                <li>
                    <h3>Información del Usuario</h3>
                    Nombre: <?= htmlspecialchars($resultado['nombre']) ?> <?= htmlspecialchars($resultado['apellido']) ?><br>
                    Cédula: <?= htmlspecialchars($resultado['cedula']) ?><br>
                    Correo: <?= htmlspecialchars($resultado['correo']) ?><br>
                    Edad: <?= htmlspecialchars($resultado['edad']) ?><br>
                    Dirección: <?= htmlspecialchars($resultado['direccion']) ?><br>
                    
                    <h3>Información del Vehículo</h3>
                    Nombre: <?= htmlspecialchars($resultado['nom_vehiculo']) ?><br>
                    Modelo: <?= htmlspecialchars($resultado['mod_vehiculo']) ?><br>
                    Marca: <?= htmlspecialchars($resultado['mar_vehiculo']) ?><br>
                    Color: <?= htmlspecialchars($resultado['col_vehiculo']) ?><br>
                    Año: <?= htmlspecialchars($resultado['anio_vehiculo']) ?><br>
                    Precio: <?= htmlspecialchars($resultado['pre_vehiculo']) ?><br>
                    Placa: <?= htmlspecialchars($resultado['placa']) ?><br>
                    
                    <h3>Imagen del Vehículo</h3>
                    <?php if ($resultado['ruta_img_veh']): ?>
                        <img src="<?= htmlspecialchars($resultado['ruta_img_veh']) ?>" alt="Imagen del Vehículo">
                    <?php else: ?>
                        No hay imagen disponible.
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No se encontraron resultados.</p>
    <?php endif; ?>
</body>
</html>