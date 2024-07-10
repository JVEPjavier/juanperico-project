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
    <title>Gestionar Trabajadores</title>
    <link rel="stylesheet" href="EXT/BOOTSTRAP/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="my-4">Gestionar Trabajadores</h1>
    <a href="admin_agregar_trabajador.php" class="btn btn-success mb-4">Agregar Trabajador</a>
    <a href="admin.php" class="btn btn-secondary mb-4">Volver al Menú Admin</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>RUT</th>
                <th>Correo Electrónico</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM Usuario WHERE rolid = 3";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["nombre"] . "</td>";
                    echo "<td>" . $row["apellido"] . "</td>";
                    echo "<td>" . $row["rut"] . "</td>";
                    echo "<td>" . $row["correoElectronico"] . "</td>";
                    echo "<td>";
                    echo "<a href='admin_editar_trabajador.php?id=" . $row["Id"] . "' class='btn btn-primary'>Editar</a> ";
                    echo "<a href='admin_eliminar_trabajador.php?id=" . $row["Id"] . "' class='btn btn-danger'>Eliminar</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No hay trabajadores</td></tr>";
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