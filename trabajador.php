<?php
include 'conexion.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 3) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $venta_id = $_POST['venta_id'];
    $nuevo_estado = $_POST['nuevo_estado'];

    $sql_update = "UPDATE Venta SET id_estado = ? WHERE id = ?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("ii", $nuevo_estado, $venta_id);
    $stmt->execute();
    $stmt->close();

    header("Location: trabajador.php");
    exit;
}

$sql = "SELECT v.id, v.fechaVenta, v.totalVenta, u.nombre, u.apellido, ev.nombreEstado 
        FROM Venta v
        JOIN Usuario u ON v.id_usuario = u.Id
        JOIN estado_venta ev ON v.id_estado = ev.id
        WHERE DATE(v.fechaVenta) = CURDATE()";
$result = $conn->query($sql);

$sql_estados = "SELECT * FROM estado_venta";
$result_estados = $conn->query($sql_estados);
$estados = [];
while ($estado = $result_estados->fetch_assoc()) {
    $estados[] = $estado;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="EXT/BOOTSTRAP/css/bootstrap.min.css">
    <title>Trabajador - Gestión de Ventas</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">
            <img src="imagenes/logo1.png" width="210" height="80" alt="">
        </a>
        <a href="logout.php" class="btn btn-secondary ml-auto">Cerrar sesión</a>
    </nav>

    <div class="container mt-4">
        <h2 class="text-center">Gestión de Ventas</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Cliente</th>
                    <th>Estado</th>
                    <th>Actualizar Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['fechaVenta'] . "</td>";
                        echo "<td>$" . $row['totalVenta'] . "</td>";
                        echo "<td>" . $row['nombre'] . " " . $row['apellido'] . "</td>";
                        echo "<td>" . $row['nombreEstado'] . "</td>";
                        echo '<td>
                                <form method="POST" action="">
                                    <input type="hidden" name="venta_id" value="' . $row['id'] . '">
                                    <select name="nuevo_estado" class="form-control">';
                        foreach ($estados as $estado) {
                            echo '<option value="' . $estado['id'] . '">' . $estado['nombreEstado'] . '</option>';
                        }
                        echo '          </select>
                                    <button type="submit" class="btn btn-primary mt-2">Actualizar</button>
                                </form>
                              </td>';
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>No hay ventas disponibles</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="index.php" class="btn btn-primary">Volver</a>
    </div>

    <script src="EXT/jquery-3.7.1.min.js"></script>
    <script src="EXT/popper.min.js"></script>
    <script src="EXT/BOOTSTRAP/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
$conn->close();
?>