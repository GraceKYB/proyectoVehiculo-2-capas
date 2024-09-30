<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Formulario</title>
        <link rel="stylesheet" href="../estilos/styleRegistrar.css"/>
    </head>
    <body>
        <?php
        include './conexion.php';
        $idE = isset($_GET['idEditar']) ? (int) $_GET['idEditar'] : 0;

        if ($idE > 0) {
            $sqlSelect = "select * from usuario where id_cliente= :id_cliente";
            $stmt = $conexion->prepare($sqlSelect);
            $stmt->bindParam(':id_cliente', $idE, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                ?>
        <div class="container">
                <form id="registroForm" action="crud.php" method="post">
                    <input type="text" id="idEdit" name="idEdit" value="<?php echo $row['id_cliente'] ?>">
                    <h2 id="encabezado">Editar Registro</h2>
                    <div class="form-row">
                    <div class="form-group col-mod-6">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo $row['nombre'] ?>" required>
                    </div>

                    <div class="form-group col-mod-6">
                        <label for="apellido">Apellido:</label>
                        <input type="text" id="apellido" name="apellido" class="form-control" value="<?php echo $row['apellido'] ?>">
                    </div>
                    </div>
                    <div class="form-row">
                    <div class="form-group col-mod-6">
                        <label for="cedula">Cédula:</label>
                        <input type="text" id="cedula" name="cedula" class="form-control" value="<?php echo $row['cedula'] ?>" required>
                    </div>

                    <div class="form-group col-mod-6">
                        <label for="correo">Correo:</label>
                        <input type="email" id="correo" name="correo" class="form-control" value="<?php echo $row['correo'] ?>" required>
                    </div>
                    </div>
                    <div class="form-row">
                    <div class="form-group col-mod-6">
                        <label for="edad">Edad:</label>
                        <input type="number" id="edad" name="edad" class="form-control" value="<?php echo $row['edad'] ?>" required>
                    </div>

                    <div class="form-group col-mod-6">
                        <label for="direccion">Dirección:</label>
                        <input type="text" id="direccion" name="direccion" class="form-control" value="<?php echo $row['direccion'] ?>" required>
                    </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Editar</button>
                    
                </form>
        </div>

                <?php
            }
        } else {
            ?>
        <div class="container">
            <form id="registroForm" action="crud.php" method="post">
                <input type="text" id="idEdit" name="idEdit" style="display: none;" value="0">
                <h2 id="encabezado">Regístrate</h2>
                <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="apellido">Apellido:</label>
                    <input type="text" id="apellido" name="apellido" class="form-control" required>
                </div>
                </div>
                 <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="cedula">Cédula:</label>
                    <input type="text" id="cedula" name="cedula" class="form-control" required>
                </div>

                <div class="form-group col-mod-6">
                    <label for="correo">Correo:</label>
                    <input type="email" id="correo" name="correo" class="form-control" required>
                </div>
                 </div>
                 <div class="form-row">

                <div class="form-group col-mod-6">
                    <label for="edad">Edad:</label>
                    <input type="number" id="edad" name="edad" class="form-control" required>
                </div>

                <div class="form-group col-mod-6">
                    <label for="direccion">Dirección:</label>
                    <input type="text" id="direccion" name="direccion" class="form-control" required>
                </div>
                 </div>
                <button type="submit"  ">Registrar</button>
                <a class="btn btn-primary" style="border-radius: 50px; padding: 10px 20px; background-color: #007bff; color: #fff; text-decoration: none;" href="index.php">
    Regresar
</a>
                
            </form>
        </div>
            <?php
        }
        ?>

    </body>
</html>
