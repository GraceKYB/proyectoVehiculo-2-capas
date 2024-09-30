<!DOCTYPE html>
<html lang="es">
    
<head>
    <meta charset="UTF-8">
    <title>Formulario de Búsqueda</title>
    <link rel="stylesheet" href="../estilos/styleConsulta.css"/>
     <script>
        function mostrarBusqueda(opcion) {
            document.getElementById('busqueda_cedula').style.display = opcion === 'cedula' ? 'block' : 'none';
            document.getElementById('busqueda_placa').style.display = opcion === 'placa' ? 'block' : 'none';
        }
    </script>
</head>
<body>
    <h1>Buscar Usuario o Vehículo</h1>
    <div class="search-buttons">
        <button onclick="mostrarBusqueda('cedula')">Buscar por Cédula</button>
        <button onclick="mostrarBusqueda('placa')">Buscar por Placa</button>
    </div>
    
    <div id="busqueda_cedula" class="search-form">
        <form action="busquedaUV.php" method="GET">
            <label for="cedula">Cédula:</label>
            <input type="text" id="cedula" name="cedula" required>
            <button type="submit">Buscar</button>
        </form>
    </div>
    
    <div id="busqueda_placa" class="search-form">
        <form action="busquedaUV.php" method="GET">
            <label for="placa">Placa:</label>
            <input type="text" id="placa" name="placa" required>
            <button type="submit">Buscar</button>
        </form>
    </div>
</body>
</html>
