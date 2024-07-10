<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $rut = $_POST['rut'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT); // Encriptar la contraseña
    $correo_electronico = $_POST['correo_electronico'];
    $rol_id = 2;

    $sql_check = "SELECT * FROM Usuario WHERE correoElectronico = '$correo_electronico'";
    $result = $conn->query($sql_check);

    if ($result->num_rows > 0) {
        echo "El correo electrónico ya está registrado.";
    } else {
        $sql = "INSERT INTO Usuario (nombre, apellido, rut, fechaNacimiento, contrasena, correoElectronico, rolid)
                VALUES ('$nombre', '$apellido', '$rut', '$fecha_nacimiento', '$contraseña', '$correo_electronico', '$rol_id')";

        if ($conn->query($sql) === TRUE) {
            echo "Registro exitoso";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="EXT/BOOTSTRAP/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }
        .register-container {
            width: 100%;
            max-width: 500px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .register-header {
            margin-bottom: 20px;
        }
        .login-link {
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2 class="register-header text-center">Registro de Usuario</h2>
        <form method="post" action="register.php">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="apellido">Apellido:</label>
                <input type="text" class="form-control" id="apellido" name="apellido" required>
            </div>
            <div class="form-group">
                <label for="rut">RUT:</label>
                <input type="text" class="form-control" id="rut" name="rut" required oninput="formatRUT(this)">
            </div>
            <div class="form-group">
                <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
            </div>
            <div class="form-group">
                <label for="contraseña">Contraseña:</label>
                <input type="password" class="form-control" id="contraseña" name="contraseña" required>
            </div>
            <div class="form-group">
                <label for="correo_electronico">Correo Electrónico:</label>
                <input type="email" class="form-control" id="correo_electronico" name="correo_electronico" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Registrar</button>
        </form>
        <div class="login-link">
            <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión</a></p>
        </div>
    </div>

    <script src="EXT/jquery-3.7.1.min.js"></script>
    <script src="EXT/popper.min.js"></script>
    <script src="EXT/custom.js"></script>
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