<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Imagenes</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    </head>
    <body>
        <form action="subir.php" method="POST" enctype="multipart/form-data">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="mb-4">imagen</h2>
                <label>Seleccione una imagen</label>
                <input type="file" name="imagen" accept="image/*" required>
                <input type="submit" value="subir imagen">
            </div>
        </div>
    </div>
</form>
 </body>

</html>

