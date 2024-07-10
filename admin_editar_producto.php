<?php
include 'conexion.php';
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 1) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $imagen = $_FILES['imagen']['name'];
    $cantidad = $_POST['cantidad'];
    $proveedor_id = $_POST['proveedor'];
    $categoria_id = $_POST['categoria'];
    $descuento = $_POST['descuento'];
    $target = "imagenes/" . basename($imagen);

    // Aplicar descuento
    if ($descuento == '5%') {
        $precio *= 0.95;
    } elseif ($descuento == '10%') {
        $precio *= 0.90;
    } elseif ($descuento == '15%') {
        $precio *= 0.85;
    }

    if ($imagen) {
        $sql = "UPDATE producto SET nombreProducto='$nombre', descripcion='$descripcion', precio='$precio', imagen='$imagen', Cantidad='$cantidad', id_proveedor='$proveedor_id', id_categoria='$categoria_id' WHERE id='$id'";
    } else {
        $sql = "UPDATE producto SET nombreProducto='$nombre', descripcion='$descripcion', precio='$precio', Cantidad='$cantidad', id_proveedor='$proveedor_id', id_categoria='$categoria_id' WHERE id='$id'";
    }

    if ($conn->query($sql) === TRUE) {
        if ($imagen && move_uploaded_file($_FILES['imagen']['tmp_name'], $target)) {
            header("Location: admin_productos.php");
            exit;
        } else if (!$imagen) {
            header("Location: admin_productos.php");
            exit;
        } else {
            echo "Error al subir la imagen.";
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    $sql = "SELECT * FROM producto WHERE id='$id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
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
    <title>Admin - Editar Producto</title>
</head>
<body>
    <div class="container">
        <h1 class="my-4">Editar Producto</h1>
        <form action="admin_editar_producto.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nombre">Nombre del Producto</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $row['nombreProducto']; ?>" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" required><?php echo $row['descripcion']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="precio">Precio</label>
                <input type="number" step="0.01" class="form-control" id="precio" name="precio" value="<?php echo $row['precio']; ?>" required>
            </div>
            <div class="form-group">
                <label for="descuento">Descuento</label>
                <select class="form-control" id="descuento" name="descuento">
                    <option value="0%">Sin descuento</option>
                    <option value="5%">5%</option>
                    <option value="10%">10%</option>
                    <option value="15%">15%</option>
                </select>
            </div>
            <div class="form-group">
                <label for="imagen">Imagen</label>
                <input type="file" class="form-control-file" id="imagen" name="imagen">
                <img src="imagenes/<?php echo $row['imagen']; ?>" width="50" height="50">
            </div>
            <div class="form-group">
                <label for="cantidad">Cantidad</label>
                <input type="number" class="form-control" id="cantidad" name="cantidad" value="<?php echo $row['Cantidad']; ?>" required>
            </div>
            <div class="form-group">
                <label for="proveedor">Proveedor</label>
                <select class="form-control" id="proveedor" name="proveedor" required>
                    <option value="">Seleccionar Proveedor</option>
                    <?php while($row_proveedor = $result_proveedor->fetch_assoc()): ?>
                        <option value="<?php echo $row_proveedor['id']; ?>" <?php if ($row['id_proveedor'] == $row_proveedor['id']) echo 'selected'; ?>>
                            <?php echo $row_proveedor['nombreProveedor']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="categoria">Categoría</label>
                <select class="form-control" id="categoria" name="categoria" required>
                    <option value="">Seleccionar Categoría</option>
                    <?php while($row_categoria = $result_categoria->fetch_assoc()): ?>
                        <option value="<?php echo $row_categoria['id']; ?>" <?php if ($row['id_categoria'] == $row_categoria['id']) echo 'selected'; ?>>
                            <?php echo $row_categoria['nombreCategoria']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Actualizar Producto</button>
            <a href="admin_productos.php" class="btn btn-secondary">Volver</a>
        </form>
    </div>
</body>
</html>