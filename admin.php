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
    <title>Admin Interfaz</title>
    <link rel="stylesheet" href="EXT/BOOTSTRAP/css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 50px;
        }
        .card {
            margin-bottom: 20px;
        }
        .btn-back {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body text-center">
                        <h1 class="card-title">Bienvenido Admin</h1>
                        <h3 class="card-subtitle mb-4">Elija una de estas opciones:</h3>
                        <div class="list-group">
                            <a href="admin_productos.php" class="list-group-item list-group-item-action">Gestionar Productos</a>
                            <a href="admin_categoria.php" class="list-group-item list-group-item-action">Gestionar Categorias</a>
                            <a href="admin_ventas.php" class="list-group-item list-group-item-action">Gestionar Pedidos</a>
                            <a href="admin_proveedores.php" class="list-group-item list-group-item-action">Gestionar Proveedores</a>
                            <a href="admin_trabajadores.php" class="list-group-item list-group-item-action">Gestionar Trabajadores</a>
                        </div>
                        <a href="index.php" class="btn btn-secondary btn-back">Volver al Inicio</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="EXT/jquery-3.7.1.min.js"></script>
    <script src="EXT/popper.min.js"></script>
    <script src="EXT/BOOTSTRAP/js/bootstrap.bundle.min.js"></script>
</body>

</html>