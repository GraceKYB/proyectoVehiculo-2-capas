<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Formulario Vehículo</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="../estilos/styleRVehiculo.css">

    </head>
    <body>
        <div class="container">
            <h2>Registro de Vehículos</h2>
            <form action="crudVehiculo.php" method="post" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nombre">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="modelo">Modelo:</label>
                        <input type="text" class="form-control" id="modelo" name="modelo" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="marca">Marca:</label>
                        <input type="text" class="form-control" id="marca" name="marca" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="color">Color:</label>
                        <input type="text" class="form-control" id="color" name="color" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="anio">Año:</label>
                        <input type="number" class="form-control" id="anio" name="anio" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="precio">Precio:</label>
                        <input type="number" step="0.01" class="form-control" id="precio" name="precio" required>
                    </div>
                </div>
                    <div class="form-group">
                        <label for="imagenes">Seleccione imágenes:</label>
                        <input type="file" class="form-control-file" id="imagenes" name="imagenes[]" accept="image/*" multiple required>
                    </div>
                    <div id="preview"></div>
                    <button type="submit" class="btn btn-primary mt-3">Guardar</button>
                        <a class="btn btn-primary mt-3" href="index.php">
                      Regresar</a>

            </form><a
        </div>

        <script>
            document.getElementById('imagenes').addEventListener('change', function (event) {
                let files = event.target.files;
                let fileNames = [];

                Array.from(files).forEach((file) => {
                    fileNames.push(file.name);
                });

                let preview = document.getElementById('preview');
                preview.innerHTML = '';

                fileNames.forEach((fileName) => {
                    let fileNameElement = document.createElement('p');
                    fileNameElement.textContent = fileName;
                    preview.appendChild(fileNameElement);
                });
            });
        </script>
    </body>
</html>
