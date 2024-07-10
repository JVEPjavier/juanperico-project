<?php
include 'conexion.php';
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 1) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener la información del trabajador
    $sql = "SELECT * FROM Usuario WHERE Id = ? AND rolid = 3";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Trabajador no encontrado.";
        exit;
    }
    $stmt->close();
} else {
    header("Location: admin_trabajadores.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $rut = $_POST['rut'];
    $fechaNacimiento = $_POST['fechaNacimiento'];
    $correoElectronico = $_POST['correoElectronico'];

    if (!empty($_POST['contraseña'])) {
        $contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);
        $sql = "UPDATE Usuario SET nombre = ?, apellido = ?, rut = ?, fechaNacimiento = ?, contraseña = ?, correoElectronico = ? WHERE Id = ? AND rolid = 3";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssi", $nombre, $apellido, $rut, $fechaNacimiento, $contraseña, $correoElectronico, $id);
    } else {
        $sql = "UPDATE Usuario SET nombre = ?, apellido = ?, rut = ?, fechaNacimiento = ?, correoElectronico = ? WHERE Id = ? AND rolid = 3";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $nombre, $apellido, $rut, $fechaNacimiento, $correoElectronico, $id);
    }

    if ($stmt->execute()) {
        header("Location: admin_trabajadores.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Trabajador</title>
    <link rel="stylesheet" href="EXT/BOOTSTRAP/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="my-4">Editar Trabajador</h1>
    <form method="POST">
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $row['nombre']; ?>" required>
        </div>
        <div class="form-group">
            <label for="apellido">Apellido</label>
            <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo $row['apellido']; ?>" required>
        </div>
        <div class="form-group">
            <label for="rut">RUT</label>
            <input type="text" class="form-control" id="rut" name="rut" value="<?php echo $row['rut']; ?>" required>
        </div>
        <div class="form-group">
            <label for="fechaNacimiento">Fecha de Nacimiento</label>
            <input type="date" class="form-control" id="fechaNacimiento" name="fechaNacimiento" value="<?php echo $row['fechaNacimiento']; ?>" required>
        </div>
        <div class="form-group">
            <label for="correoElectronico">Correo Electrónico</label>
            <input type="email" class="form-control" id="correoElectronico" name="correoElectronico" value="<?php echo $row['correoElectronico']; ?>" required>
        </div>
        <div class="form-group">
            <label for="contraseña">Nueva Contraseña (dejar en blanco si no desea cambiarla)</label>
            <input type="password" class="form-control" id="contraseña" name="contraseña">
        </div>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="admin_trabajadores.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<script src="EXT/jquery-3.7.1.min.js"></script>
<script src="EXT/popper.min.js"></script>
<script src="EXT/BOOTSTRAP/js/bootstrap.bundle.min.js"></script>
</body>
</html>