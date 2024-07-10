<?php
include 'conexion.php';
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 1) {
    header("Location: login.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $rut = $_POST['rut'];
    $fechaNacimiento = $_POST['fechaNacimiento'];
    $contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);
    $correoElectronico = $_POST['correoElectronico'];
    $rolid = 3;

    $sql = "SELECT * FROM Usuario WHERE correoElectronico = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $correoElectronico);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $error = "El correo electrónico ya está registrado.";
    } else {
        $stmt->close();
        $sql = "SELECT * FROM Usuario WHERE rut = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $rut);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "El RUT ya está registrado.";
        } else {
            $stmt->close();
            $sql = "INSERT INTO Usuario (nombre, apellido, rut, fechaNacimiento, contraseña, correoElectronico, rolid) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssi", $nombre, $apellido, $rut, $fechaNacimiento, $contraseña, $correoElectronico, $rolid);

            if ($stmt->execute()) {
                header("Location: admin_trabajadores.php");
                exit;
            } else {
                $error = "Error: " . $stmt->error;
            }
        }
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
    <title>Agregar Trabajador</title>
    <link rel="stylesheet" href="EXT/BOOTSTRAP/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1 class="my-4">Agregar Trabajador</h1>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="apellido">Apellido</label>
                <input type="text" class="form-control" id="apellido" name="apellido" required>
            </div>
            <div class="form-group">
                <label for="rut">RUT</label>
                <input type="text" class="form-control" id="rut" name="rut" required oninput="formatRUT(this)">
            </div>
            <div class="form-group">
                <label for="fechaNacimiento">Fecha de Nacimiento</label>
                <input type="date" class="form-control" id="fechaNacimiento" name="fechaNacimiento" required>
            </div>
            <div class="form-group">
                <label for="contraseña">Contraseña</label>
                <input type="password" class="form-control" id="contraseña" name="contraseña" required>
            </div>
            <div class="form-group">
                <label for="correoElectronico">Correo Electrónico</label>
                <input type="email" class="form-control" id="correoElectronico" name="correoElectronico" required>
            </div>
            <button type="submit" class="btn btn-primary">Agregar</button>
            <a href="admin_trabajadores.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>

    <script src="EXT/jquery-3.7.1.min.js"></script>
    <script src="EXT/popper.min.js"></script>
    <script src="EXT/BOOTSTRAP/js/bootstrap.bundle.min.js"></script>
    <script>
        function formatRUT(rutField) {
            let rut = rutField.value.replace(/\D/g, '');
            if (rut.length > 1) {
                rut = rut.slice(0, -1) + '-' + rut.slice(-1);
            }
            if (rut.length > 5) {
                rut = rut.slice(0, -5) + '.' + rut.slice(-5);
            }
            if (rut.length > 9) {
                rut = rut.slice(0, -9) + '.' + rut.slice(-9);
            }
            rutField.value = rut;
        }
    </script>
</body>

</html>