<?php
include './conexion.php';

$sqlListar = "SELECT * FROM usuario WHERE estado='1'";
$stmt = $conexion->prepare($sqlListar);
$stmt->execute();
?>
<link rel="stylesheet" href="../estilos/styleLista.css"/>
<link rel="stylesheet" href="../estilos/styleLinkAsBtn.css"/>

<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Clientes</title>
</head>
<body>
    <hr>
    <a class="boton" href="listarFacturas.php">
        Facturas registradas
    </a>
    <a class="boton" href="index.php">
        Regresar
    </a>
    <hr>
    <h1>Lista de Clientes</h1>
    <table>
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Cédula</th>
            <th>Correo</th>
            <th>Edad</th>
            <th>Dirección</th>
            <th>Acciones</th>
        </tr>
        <?php
        if ($stmt->rowCount() > 0) {
            $index = 1;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <tr>
                    <td><?php echo $index; ?></td>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['apellido']; ?></td>
                    <td><?php echo $row['cedula']; ?></td>
                    <td><?php echo $row['correo']; ?></td>
                    <td><?php echo $row['edad']; ?></td>
                    <td><?php echo $row['direccion']; ?></td>
                    <td>
                        <a class="boton" href="registro.php?idEditar=<?php echo $row['id_cliente']; ?>">Editar</a>
                        <a class="boton" href="crud.php?idEliminar=<?php echo $row['id_cliente']; ?>" onclick="return confirm('¿Está seguro de que desea eliminar este cliente?')">Eliminar</a>
                        <a class="boton" href="listarVehiculos.php?idCliente=<?php echo $row['id_cliente']; ?>">Asignar Vehiculo</a>
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

