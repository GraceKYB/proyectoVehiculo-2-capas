<?php
include './conexion.php';
$idCliente = isset($_GET['idCliente']) ? (int) $_GET['idCliente'] : 0;
$sqlListar = "SELECT * FROM vehiculo";
$stmt = $conexion->prepare($sqlListar);
$stmt->execute();
?>
<link rel="stylesheet" href="../estilos/styleLinkAsBtn.css"/>
<link rel="stylesheet" href="../estilos/styleDialogImg.css"/>
<link rel="stylesheet" href="../estilos/styleTable.css"/>
<html lang="es">
<head>
    <title>Lista vehiculos</title>
</head>
<body>
<form id="vehiculoForm" action="asignarPlaca.php" method="post">
    <input type="hidden" name="idCliente" value="<?php echo $idCliente; ?>">
    <h1>Lista de Vehiculos</h1>
    <hr>
    <a class="boton" href="listarClientes.php">
        < Regresar
    </a>
    <span style="display:inline-block; width: 60%;"></span>
    <button id="botonAsignarPlacas" type="submit" class="boton" style="padding-top: 5px; padding-bottom: 5px">
        Asignar placas >
    </button>
    <hr>
    <table>
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Modelo</th>
            <th>Marca</th>
            <th>Color</th>
            <th>Año</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Selección</th>
            <th>Imagen</th>
            <th>Cantidad</th>
        </tr>
        <?php
        if ($stmt->rowCount() > 0) {
            $index = 1;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $existStock = $row['stock'] > 0;
                $atributoDisabled = $existStock ? '' : 'disabled';

                $sqlImagenes = "SELECT * FROM imagen_vehiculo WHERE id_vehiculo=:id_vehiculo";
                $stmtImagen = $conexion->prepare($sqlImagenes);
                $stmtImagen->bindParam(':id_vehiculo', $row['id_vehiculo'], PDO::PARAM_INT);
                $stmtImagen->execute();
                $imagenes = $stmtImagen->fetchAll(PDO::FETCH_ASSOC);
                $rutaImagen = !empty($imagenes) ? $imagenes[0]['ruta_img_veh'] : "";
                ?>
                <tr>
                    <td><?php echo $index; ?></td>
                    <td><?php echo $row['nom_vehiculo']; ?></td>
                    <td><?php echo $row['mod_vehiculo']; ?></td>
                    <td><?php echo $row['mar_vehiculo']; ?></td>
                    <td><?php echo $row['col_vehiculo']; ?></td>
                    <td><?php echo $row['anio_vehiculo']; ?></td>
                    <td><?php echo $row['pre_vehiculo']; ?></td>
                    <td><?php echo $existStock ? $row['stock'] : "No disponible"; ?></td>
                    <td>
                        <input type="checkbox" name="vehiculos[]" value="<?php echo $row['id_vehiculo']; ?>"
                               <?php echo $atributoDisabled; ?>>
                    </td>
                    <td>
                        <img src="../img/verImagen.png" alt="Imagen" onclick="mostrarModal(<?php echo htmlspecialchars(json_encode($imagenes)); ?>)" style="cursor: pointer;">
                    </td>
                    <td>
                        <input
                            id="inputCant_<?php echo $index; ?>"
                            type="number" class="inputCantidadItem"
                            data-stock="<?php echo $row['stock']; ?>" name="cantidades[]" size="1px" maxlength="3"
                            <?php echo $atributoDisabled; ?> autocomplete="off" style="width: 50px;" min="0">
                        <br>
                        <span class="errorCantidad" style="color: red; display: none; font-size: 12px">Cantidad no disponible</span>
                    </td>
                </tr>
                <?php
                $index++;
            }
        } else {
            echo '<tr><td colspan="11">No existen registros en la tabla clientes</td></tr>';
        }
        ?>
    </table>
    <!-- Cuadro de diálogo (modal) -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <!-- Botón de cerrar -->
            <span class="close" onclick="cerrarModal()">&times;</span>
            <div id="modalImagenes"></div>
        </div>
    </div>

    <script>
        //------------------------------------------------------------
        // Función para mostrar el cuadro de diálogo (modal)
        function mostrarModal(imagenes) {
            var modal = document.getElementById('myModal');
            var modalImagenes = document.getElementById('modalImagenes');
            modal.style.display = 'block';
            modalImagenes.innerHTML = '';

            if (imagenes.length > 0) {
                imagenes.forEach(function(imagen) {
                    var imgElement = document.createElement('img');
                    imgElement.src = imagen.ruta_img_veh;
                    imgElement.alt = "Imagen del Vehículo";
                    imgElement.className = 'modal-img';
                    modalImagenes.appendChild(imgElement);
                });
            } else {
                var noFoundElement = document.createElement('p');
                noFoundElement.textContent = "No hay imágenes disponibles.";
                modalImagenes.appendChild(noFoundElement);
            }
        }

        // Función para cerrar el cuadro de diálogo (modal)
        function cerrarModal() {
            document.getElementById('myModal').style.display = 'none';
        }
        //------------------------------------------------------------

        //------------------------------------------------------------
        // Obtener todos los campos de entrada de cantidad
        var inputCantidadList = document.querySelectorAll('.inputCantidadItem');

        inputCantidadList.forEach(function(inputCantidad) {
            inputCantidad.addEventListener('change', function() {
                var stock = parseInt(this.getAttribute('data-stock'));
                var cantidad = parseInt(this.value);
                var errorCantidad = this.parentNode.querySelector('.errorCantidad');

                if (cantidad > stock) {
                    // Mostrar el mensaje de error si la cantidad ingresada es mayor que el stock disponible
                    errorCantidad.style.display = 'inline';
                    this.value = ''; // Limpiar el campo de cantidad
                } else {
                    // Ocultar el mensaje de error si la cantidad ingresada es válida
                    errorCantidad.style.display = 'none';
                }
            });
        });

        //------------------------------------------------------------
        function validarStock() {
            var checkboxes = document.getElementsByName('vehiculos[]');
            var cantidades = document.getElementsByName('cantidades[]');
            var existenSelecionados = false;

            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    existenSelecionados = true;
                    // Verificar si la cantidad es mayor que cero
                    if (cantidades[i].value === '' || parseInt(cantidades[i].value) <= 0) {
                        alert('Por favor, ingrese una cantidad mayor a cero para los vehículos seleccionados.');
                        return false; // Evitar que se envíe el formulario
                    }
                }
            }

            if (!existenSelecionados) {
                alert('Por favor, seleccione al menos un vehículo.');
                return false; // Evitar que se envíe el formulario
            }

            // Si se pasa todas las validaciones, se envía el formulario
            return true;
        }

        // Obtener el botón y agregar un manejador de eventos clic
        document.getElementById('botonAsignarPlacas').addEventListener('click', function(event) {
            // Evitar el comportamiento predeterminado del botón
            event.preventDefault();
            // Validar antes de enviar el formulario
            if (validarStock()) {
                document.getElementById('vehiculoForm').submit();
            }
        });
    </script>
</form>
</body>
</html>