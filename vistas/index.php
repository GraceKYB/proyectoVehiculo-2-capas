<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Project/PHP/PHPProject.php to edit this template
-->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="../estilos/style.css">
</head>
<body>
    <header>
        <div class="header-container">
            <img src="../imagenes/Logo.png" alt="Logo" class="logo">
            <nav class="navbar">
                <ul>
                    <li><a href="#">Inicio</a></li>
                    <li><a href="registro.php">Registro clientes</a></li>
                    <li><a href="#">Clientes</a>
                        <ul>
                            
                            <li><a href="listarClientes.php">Listado de clientes</a></li>
                        </ul>
                    </li>
                    
                    <li><a href="#">Registro Vehiculo</a>
                        <ul>
                            <li><a href="registroVehiculo.php">Vehículo</a></li>
                        </ul>
                    </li>
                     <li><a href="#">Vehiculos</a>
                        <ul>
                            
                            <li><a href="mostrar.php">Listado de vehiculos</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Consultas</a>
                        <ul>
                            <li><a href="Consultas.php">Busqueda usuario o placa</a></li>
                            <li><a href="listarFacturas.php">Detalle ventas</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Contacto</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <footer>
        <div class="footer-bottom">
            &copy; 2024 Nombre de la Empresa | Diseñado por <a href="http://www.ejemplodesarrollador.com">Desarrollador Web</a>
        </div>
    </footer>
</body>
</html>

