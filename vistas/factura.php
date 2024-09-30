<?php
include './conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idCliente = isset($_POST['idCliente']) ? (int) $_POST['idCliente'] : 0;
    $vehiculos = isset($_POST['vehiculos']) ? $_POST['vehiculos'] : [];
    $cantidades = isset($_POST['cantidades']) ? $_POST['cantidades'] : [];
    $placas = isset($_POST['placas']) ? $_POST['placas'] : [];
    ?>
    <link rel="stylesheet" href="../estilos/styleLinkAsBtn.css"/>
    <link rel="stylesheet" href="../estilos/styleDetallef.css"/>
    <html lang="es">
        <head>
            <title>Factura</title>
        </head>
        <body> 
            <form action="crudFactura.php" method="post">
                <input type="hidden" name="idCliente" value="<?php echo $idCliente; ?>">
                <a class="boton" href="listarClientes.php">
                    Cancelar
                </a>
                <span style="display:inline-block; width: 60%;"></span>
                <button type="submit" class="boton" style="padding-top: 5px; padding-bottom: 5px">
                    Guardar 
                </button>
                <hr>
                <h3 style=" padding: 0;margin: 0; background-color: #cce5ff">Datos Factura</h3>
                <?php
                $sqlCliente = "SELECT * FROM usuario WHERE id_cliente = :id_cliente";
                $stmtCliente = $conexion->prepare($sqlCliente);
                $stmtCliente->bindParam(':id_cliente', $idCliente, PDO::PARAM_INT);
                $stmtCliente->execute();
                $cliente = $stmtCliente->fetch(PDO::FETCH_ASSOC);
                ?>
                <table>
                    <tr>
                        <th>Nombre</th>
                        <td></span> <?php echo $cliente['nombre']; ?></td>
                    </tr>
                    <tr>
                        <th>Apellido</th>
                        <td></span> <?php echo $cliente['apellido']; ?></td>
                    </tr>
                    <tr>
                        <th>Cédula</th>
                        <td><?php echo $cliente['cedula']; ?></td>
                    </tr>
                    <tr>
                        <th>Correo</th>
                        <td></span> <?php echo $cliente['correo']; ?></td>
                    </tr>
                    <tr>
                        <th>Edad</th>
                        <td><?php echo $cliente['edad']; ?></td>
                    </tr>
                    <tr>
                        <th>Dirección</th>
                        <td> <?php echo $cliente['direccion']; ?></td>
                    </tr>
                </table>
                <hr>
                <h3 style=" padding: 0;margin: 0; background-color: #cce5ff">Detalle</h3>

                <input type="hidden" name="idCliente" value="<?php echo $idCliente; ?>">
                <table>
                    <tr>
                        <th>#</th>
                        <th>Vehículo</th>
                        <th>Modelo</th>
                        <th>Marca</th>
                        <th>V. Unitario</th>
                        <th>Cantidad</th> 
                        <th>Total</th> 
                    </tr>
                    <?php
                    $contador = 0;
                    $index = 1;
                    $subtotal = 0.0;
                    foreach ($vehiculos as $idVehiculo) {
                        $sqlVehiculo = "SELECT * FROM vehiculo WHERE id_vehiculo = :id_vehiculo";
                        $stmtVehiculo = $conexion->prepare($sqlVehiculo);
                        $stmtVehiculo->bindParam(':id_vehiculo', $idVehiculo, PDO::PARAM_INT);
                        $stmtVehiculo->execute();
                        $vehiculo = $stmtVehiculo->fetch(PDO::FETCH_ASSOC);
                        if ($vehiculo) {
                            $cantidad = intval($cantidades[$contador]);
                            $totalItem = round($cantidad * floatval($vehiculo['pre_vehiculo']), 2);
                            $subtotal = round($subtotal + $totalItem, 2);
                            ?>
                            <tr>
                                <td><?php echo $index; ?></td>
                                <td><?php echo $vehiculo['nom_vehiculo']; ?></td>
                                <td><?php echo $vehiculo['mod_vehiculo']; ?></td>
                                <td><?php echo $vehiculo['mar_vehiculo']; ?></td>
                                <td><?php echo $vehiculo['pre_vehiculo']; ?></td>
                                <td><?php echo $cantidad ?></td>
                                <td><?php echo $totalItem; ?></td>
                            </tr>
                            <input type="hidden" name="vehiculos[]" value="<?php echo $vehiculos[$contador]; ?>">
                            <input type="hidden" name="cantidades[]" value="<?php echo $cantidades[$contador]; ?>">
                            <input type="hidden" name="placas[]" value="<?php echo $placas[$contador]; ?>">
                            <input type="hidden" name="totalItems[]" value="<?php echo $totalItem; ?>">
                            <?php
                        }
                        $contador = $contador + 1;
                        $index = $index + 1;
                    }

                    $subtotalIva = round(0.15 * $subtotal, 2);
                    $total = round($subtotalIva + $subtotal, 2);
                    ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Subtotal</td>
                        <td><?php echo $subtotal; ?></td>
                    <input type="hidden" name="subtotal" value="<?php echo $subtotal; ?>">
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Iva 15%</td>
                        <td><?php echo $subtotalIva; ?></td>
                    <input type="hidden" name="subtotalIva" value="<?php echo $subtotalIva; ?>">
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Total</td>
                        <td><?php echo $total; ?></td>
                    <input type="hidden" name="total" value="<?php echo $total; ?>">
                    </tr>
                </table>

            </form>

        </body>
    </html>

    <?php
}
?>
