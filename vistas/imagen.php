<?php
// Include the database connection
include 'conexion.php';

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
?>
