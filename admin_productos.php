<?php
include 'conexion.php';
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 1) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="EXT/BOOTSTRAP/css/bootstrap.min.css">
</head>
<body>
<div class="container">
        <h1 class="my-4">Gestionar Productos</h1>
        <a href="admin_agregar_producto.php" class="btn btn-success mb-4">Agregar Producto</a>
        <a href="admin.php" class="btn btn-secondary mb-4">Volver al Menú Admin</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM producto";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["nombreProducto"] . "</td>";
                        echo "<td>" . $row["descripcion"] . "</td>";
                        echo "<td>$" . $row["precio"] . "</td>";
                        echo "<td><img src='imagenes/" . $row["imagen"] . "' width='50' height='50'></td>";
                        echo "<td>";
                        echo "<a href='admin_editar_producto.php?id=" . $row["id"] . "' class='btn btn-primary'>Editar</a> ";
                        echo "<a href='admin_eliminar_producto.php?id=" . $row["id"] . "' class='btn btn-danger'>Eliminar</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No hay productos</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>