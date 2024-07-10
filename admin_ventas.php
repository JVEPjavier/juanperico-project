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
    <title>Gestionar Ventas</title>
    <link rel="stylesheet" href="EXT/BOOTSTRAP/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1 class="my-4">Gestionar Ventas</h1>
        <a href="admin.php" class="btn btn-secondary mb-4">Volver al Menú Admin</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Usuario</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT v.id, v.fechaVenta, v.totalVenta, u.nombre, u.apellido, e.nombreEstado
                    FROM venta v
                    JOIN usuario u ON v.id_usuario = u.id
                    JOIN estado_venta e ON v.id_estado = e.id";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["fechaVenta"] . "</td>";
                        echo "<td>$" . $row["totalVenta"] . "</td>";
                        echo "<td>" . $row["nombre"] . " " . $row["apellido"] . "</td>";
                        echo "<td>" . $row["nombreEstado"] . "</td>"; // Nueva columna
                        echo "<td>";
                        echo "<a href='admin_ver_venta.php?id=" . $row["id"] . "' class='btn btn-info'>Ver</a> ";
                        echo "<a href='admin_eliminar_venta.php?id=" . $row["id"] . "' class='btn btn-danger'>Eliminar</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No hay ventas</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>