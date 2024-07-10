<?php
include 'conexion.php';
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 1) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: admin_ventas.php");
    exit;
}

$venta_id = $_GET['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Venta</title>
    <link rel="stylesheet" href="EXT/BOOTSTRAP/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="my-4">Detalle de Venta</h1>
        <a href="admin_ventas.php" class="btn btn-secondary mb-4">Volver a Ventas</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio Unitario</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT p.nombreProducto, dv.precioUnitario, dv.cantidad, (dv.precioUnitario * dv.cantidad) AS total
                        FROM detalleventa dv
                        JOIN producto p ON dv.id_producto = p.id
                        WHERE dv.id_venta = $venta_id";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["nombreProducto"] . "</td>";
                        echo "<td>$" . $row["precioUnitario"] . "</td>";
                        echo "<td>" . $row["cantidad"] . "</td>";
                        echo "<td>$" . $row["total"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No hay detalles para esta venta</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
    <script src="EXT/jquery-3.7.1.min.js"></script>
    <script src="EXT/popper.min.js"></script>
    <script src="EXT/BOOTSTRAP/js/bootstrap.bundle.min.js"></script>
</body>
</html>