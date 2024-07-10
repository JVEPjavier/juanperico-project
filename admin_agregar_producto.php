<?php
include 'conexion.php';
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 1) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $imagen = $_FILES['imagen']['name'];
    $cantidad = $_POST['cantidad'];
    $proveedor_id = $_POST['proveedor'];
    $categoria_id = $_POST['categoria'];
    $target = "imagenes/" . basename($imagen);

    $sql = "INSERT INTO producto (nombreProducto, descripcion, precio, imagen, Cantidad, id_proveedor, id_categoria) 
            VALUES ('$nombre', '$descripcion', '$precio', '$imagen', '$cantidad', '$proveedor_id', '$categoria_id')";

    if ($conn->query($sql) === TRUE) {
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $target)) {
            header("Location: admin_productos.php");
            exit;
        } else {
            echo "Error al subir la imagen.";
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}

$sql_categoria = "SELECT * FROM categoria";
$result_categoria = $conn->query($sql_categoria);

$sql_proveedor = "SELECT * FROM proveedor";
$result_proveedor = $conn->query($sql_proveedor);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="EXT/BOOTSTRAP/css/bootstrap.min.css">
    <title>Admin - Agregar Producto</title>
</head>
<body>
    <div class="container">
        <h1 class="my-4">Agregar Producto</h1>
        <form action="admin_agregar_producto.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nombre">Nombre del Producto</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
            </div>
            <div class="form-group">
                <label for="precio">Precio</label>
                <input type="number" step="0.01" class="form-control" id="precio" name="precio" required>
            </div>
            <div class="form-group">
                <label for="imagen">Imagen</label>
                <input type="file" class="form-control-file" id="imagen" name="imagen" required>
            </div>
            <div class="form-group">
                <label for="cantidad">Cantidad</label>
                <input type="number" class="form-control" id="cantidad" name="cantidad" required>
            </div>
            <div class="form-group">
                <label for="proveedor">Proveedor</label>
                <select class="form-control" id="proveedor" name="proveedor" required>
                    <option value="">Seleccionar Proveedor</option>
                    <?php while($row = $result_proveedor->fetch_assoc()): ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['nombreProveedor']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="categoria">Categoría</label>
                <select class="form-control" id="categoria" name="categoria" required>
                    <option value="">Seleccionar Categoría</option>
                    <?php while($row = $result_categoria->fetch_assoc()): ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['nombreCategoria']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Agregar Producto</button>
            <a href="admin_productos.php" class="btn btn-secondary">Volver</a>
        </form>
    </div>
</body>
</html>