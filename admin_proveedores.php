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
    <title>Gestionar Proveedores</title>
    <link rel="stylesheet" href="EXT/BOOTSTRAP/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="my-4">Gestionar Proveedores</h1>
        <a href="admin_agregar_proveedor.php" class="btn btn-success mb-4">Agregar Proveedor</a>
        <a href="admin.php" class="btn btn-secondary mb-4">Volver al Menú Admin</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Correo Electrónico</th>
                    <th>Número de Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM proveedor";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["nombreProveedor"] . "</td>";
                        echo "<td>" . $row["correoElectronico"] . "</td>";
                        echo "<td>" . $row["numeroTelefono"] . "</td>";
                        echo "<td>";
                        echo "<a href='admin_editar_proveedor.php?id=" . $row["id"] . "' class='btn btn-primary'>Editar</a> ";
                        echo "<a href='admin_eliminar_proveedor.php?id=" . $row["id"] . "' class='btn btn-danger'>Eliminar</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No hay proveedores</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>