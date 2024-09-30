<?php
include './conexion.php';

$sqlListar = "SELECT * FROM compra";
$stmt = $conexion->prepare($sqlListar);
$stmt->execute();
?>
<!--<link rel="stylesheet" href="../estilos/styleTable.css"/>-->
<link rel="stylesheet" href="../estilos/styleListaFactura.css"/>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Facturas</title>
    </head>
    <body>
        <h1>Lista de facturas</h1>
        <hr>
        <a class="boton" href="index.php">
            < Regresar
        </a>
        <hr>
        <table>
            <tr>
                <th>#</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
            <?php
            if ($stmt->rowCount() > 0) {
                $index = 1;
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $sqlCliente = "SELECT * FROM usuario WHERE id_cliente = :id_cliente";
                    $stmtCliente = $conexion->prepare($sqlCliente);
                    $stmtCliente->bindParam(':id_cliente', $row['id_cliente'], PDO::PARAM_INT);
                    $stmtCliente->execute();
                    $cliente = $stmtCliente->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <tr>
                        <td><?php echo $index; ?></td>
                        <td><?php echo $cliente['nombre'] . "  " . $cliente['apellido']; ?></td>
                        <td><?php echo $row['fecha_comp']; ?></td>
                        <td>
                            <a class="boton" href="verFactura.php?idComp=<?php echo $row['id_comp']; ?>">Ver</a>
                        </td>
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
