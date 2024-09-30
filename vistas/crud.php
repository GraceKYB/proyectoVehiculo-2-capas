<?php

include './conexion.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['idEdit'];
    $nom = $_POST['nombre'];
    $ape = $_POST['apellido'];
    $ced = $_POST['cedula'];
    $correo = $_POST['correo'];
    $edad = $_POST['edad'];
    $dire = $_POST['direccion'];
    $estado = '1';
    

    if ($id == 0) {
        try {
            $sql = "INSERT INTO usuario(nombre,apellido,cedula,correo,edad,direccion,estado) "
                    . "VALUES(:nombre,:apellido,:cedula,:correo,:edad,:direccion,:estado)";

            //preparar la sentencia sql con una conexion existente
            $stmt = $conexion->prepare($sql);
            // vincular parametros
            $stmt->bindParam(':nombre', $nom);
            $stmt->bindParam(':apellido', $ape);
            $stmt->bindParam(':cedula', $ced);
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':edad', $edad);
            $stmt->bindParam(':direccion', $dire);
            $stmt->bindParam(':estado', $estado);

            //ejecutar
            $stmt->execute();

            echo '<script> alert("Registro creado con existo..")</script>';
            echo '<script> window.location="../vistas/index.php"</script>';
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    } else {
        try {
            $sql = "UPDATE usuario SET nombre=:nombre, apellido=:apellido, cedula=:cedula, correo=:correo, "
                    . "edad=:edad, direccion=:direccion "
                    . "WHERE id_cliente=:idcliente ";

            //preparar la sentencia sql con una conexion existente
            $stmt = $conexion->prepare($sql);
            // vincular parametros
            $stmt->bindParam(':idcliente', $id);
            $stmt->bindParam(':nombre', $nom);
            $stmt->bindParam(':apellido', $ape);
            $stmt->bindParam(':cedula', $ced);
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':edad', $edad);
            $stmt->bindParam(':direccion', $dire);

            //ejecutar
            $stmt->execute();

            echo '<script> alert("Registro editado con existo..")</script>';
        echo '<script> window.location="../vistas/listarClientes.php"</script>';
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['idEliminar'])) {
    $idEliminar = $_GET['idEliminar'];

    try {
//        $sql = "DELETE FROM usuario WHERE id_cliente=:idEliminar";
        
        $sql = "UPDATE usuario SET estado=:estado "
                    . "WHERE id_cliente=:idEliminar ";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':idEliminar', $idEliminar, PDO::PARAM_INT);
        $estado = '0';
        $stmt->bindParam(':estado', $estado);
        $stmt->execute();
        
        
        echo '<script> alert("Cliente eliminado correctamente.")</script>';
        echo '<script> window.location="../vistas/listarClientes.php"</script>';
    } catch (PDOException $exc) {
        echo $exc->getMessage();
    }
}
?>