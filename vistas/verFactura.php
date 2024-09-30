<?php
include './conexion.php';
$id_comp = isset($_GET['idComp']) ? (int) $_GET['idComp'] : 0;

$sqlListar = "SELECT * FROM compra_detalle WHERE id_comp=:id_comp ";
$stmt = $conexion->prepare($sqlListar);
$stmt->bindParam(':id_comp', $id_comp, PDO::PARAM_INT);
$stmt->execute();
//$detalle = $stmtDet->fetch(PDO::FETCH_ASSOC);
?>
<!--<link rel="stylesheet" href="../estilos/styleTable.css"/>-->
<link rel="stylesheet" href="../estilos/styleDetallef.css"/>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Detalle Facturas</title>
    </head>
    <body>
        <h1 style="background-color: #cce5ff">Detalle  facturas</h1>
        <hr>
        <a class="boton" href="listarFacturas.php">
            < Regresar
        </a>
        <hr>
        <table>
            <tr>
                <th>#</th>
                <th>Vehiculo</th>
                <th>Total</th>
            </tr>
            <?php
            if ($stmt->rowCount() > 0) {
                $index = 1;
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $sqlVehiculo = "SELECT * FROM vehiculo WHERE id_vehiculo = :id_vehiculo";
                    $stmtVehiculo = $conexion->prepare($sqlVehiculo);
                    $stmtVehiculo->bindParam(':id_vehiculo', $row['id_vehiculo'], PDO::PARAM_INT);
                    $stmtVehiculo->execute();
                    $vehiculo = $stmtVehiculo->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <tr>
                        <td><?php echo $index; ?></td>
                        <td><?php echo $vehiculo['nom_vehiculo']; ?></td>
                        <td><?php echo $row['v_total']; ?></td>
                    </tr>
                    <?php
                    $index = $index + 1;
                }
            } else {
                echo '<tr><td colspan="7">No existen registros en la tabla clientes</td></tr>';
            }
            ?>
        </table>
    </body>
</html>
