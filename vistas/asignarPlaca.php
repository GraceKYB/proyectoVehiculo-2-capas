<?php
include './conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idCliente = isset($_POST['idCliente']) ? (int) $_POST['idCliente'] : 0;
    $vehiculos = isset($_POST['vehiculos']) ? $_POST['vehiculos'] : [];
    $cantidades = isset($_POST['cantidades']) ? $_POST['cantidades'] : [];
    $cantidades_filtradas = array_filter($cantidades, function ($valor) {
        return $valor !== null && $valor !== '';
    });
    $cantidades_nuevo_array = array_values($cantidades_filtradas);
    ?>
    <link rel="stylesheet" href="../estilos/styleLinkAsBtn.css"/>
    <link rel="stylesheet" href="../estilos/styleTable.css"/>
    <html lang="es">
        <head>
            <title>Asignar Placas vehiculos</title>

        </head>
        <body> 
            <form action="factura.php" method="post">
                <input type="hidden" name="idCliente" value="<?php echo $idCliente; ?>">

                <h1>Lista de vehiculos seleccionados</h1>
                <hr>
                <a class="boton" href="listarVehiculos.php?idCliente=<?php echo $idCliente; ?>">
                    < Regresar
                </a>
                <span style="display:inline-block; width: 60%;"></span>
                <button type="submit" class="boton" style="padding-top: 5px; padding-bottom: 5px">
                    Facturar >
                </button>
                <hr>                
                <table>
                    <tr>
                        <th>#</th>
                        <th>Vehículo</th>
                        <th>Modelo</th>
                        <th>Marca</th>
                        <th>Cantidad seleccionada</th>
                        <th>Asignar Placa</th> 
                    </tr>
                    <?php
                    $contador = 0;
                    $index = 1;
                    foreach ($vehiculos as $idVehiculo) {

                        $sqlVehiculo = "SELECT * FROM vehiculo WHERE id_vehiculo = :id_vehiculo";
                        $stmtVehiculo = $conexion->prepare($sqlVehiculo);
                        $stmtVehiculo->bindParam(':id_vehiculo', $idVehiculo, PDO::PARAM_INT);
                        $stmtVehiculo->execute();
                        $vehiculo = $stmtVehiculo->fetch(PDO::FETCH_ASSOC);
                        if ($vehiculo) {
                            ?>
                            <tr>
                                <td><?php echo $index; ?></td>
                                <td><?php echo $vehiculo['nom_vehiculo']; ?></td>
                                <td><?php echo $vehiculo['mod_vehiculo']; ?></td>
                                <td><?php echo $vehiculo['mar_vehiculo']; ?></td>
                                <td style="text-align: center;"><?php echo $cantidades_nuevo_array[$contador]; ?>
                                    <input type="hidden" name="cantidades[]" value="<?php echo $cantidades_nuevo_array[$contador]; ?>">
                                </td>
                                <td>
                                    <input type="text" name="placas[]" required style="text-transform: uppercase;">
                                </td>
                            </tr>
                            <input type="hidden" name="vehiculos[]" value="<?php echo $idVehiculo; ?>">
                            <?php
                        }
                        $contador = $contador + 1;
                        $index = $index + 1;
                    }
                    ?>
                </table>

            </form>

        </body>
        <script>
            function validarFacturacion() {
                var filas = document.querySelectorAll('table tr');
                var valido = true;

                for (var i = 1; i < filas.length; i++) {
                    var fila = filas[i];
                    var cantidadSeleccionada = parseInt(fila.cells[4].innerText);
                    var inputPlaca = fila.cells[5].querySelector('input[type="text"]');
                    var valorPlaca = inputPlaca.value.trim();
                    var partesPlaca = valorPlaca.split(',');

                    // Comprobar si el campo está vacío
                    if (valorPlaca === '') {
                        alert('El campo "Asignar Placa" no puede estar vacío en la fila ' + i);
                        valido = false;
                        break;
                    }

                    // Comprobar si el número de partes es igual a la cantidad seleccionada
                    if (partesPlaca.length !== cantidadSeleccionada) {
                        alert('El campo "Asignar Placa" en la fila ' + i + ' debe contener ' + cantidadSeleccionada + ' placas separadas por comas.');
                        valido = false;
                        break;
                    }
                }

                return valido;
            }

            document.addEventListener('DOMContentLoaded', function () {
                document.querySelector('button[type="submit"]').addEventListener('click', function (event) {
                    if (!validarFacturacion()) {
                        event.preventDefault();
                    }
                });
            });
        </script>
    </html>

    <?php
}
?>
