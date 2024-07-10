<?php
include 'conexion.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link rel="stylesheet" href="EXT/BOOTSTRAP/css/bootstrap.min.css">
    <style>
        .navbar {
            margin-bottom: 20px;
        }

        .card {
            margin: 20px 0;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">
            <img src="imagenes/logo1.png" width="200" height="100" alt="">
        </a>
        <form class="form-inline my-2 my-lg-0 mx-auto">
            <input class="form-control mr-sm-2" type="search" placeholder="Buscar" aria-label="Buscar">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
        </form>
        <button class="btn btn-outline-primary my-2 my-sm-0" onclick="window.location.href='login.php'">Login</button>
        <button class="btn btn-outline-secondary my-2 my-sm-0 ml-2" onclick="window.location.href='register.php'">Register</button>
    </nav>

    <div class="container">
        <div class="row">
            <?php
            $sql = "SELECT * FROM producto";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="col-md-4">';
                    echo '<div class="card">';
                    echo '<img class="card-img-top" src="imagenes/' . $row["imagen"] . '" alt="Card image cap">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $row["nombreProducto"] . '</h5>';
                    echo '<p class="card-text">' . $row["descripcion"] . '</p>';
                    echo '<p class="card-text">Precio: $' . $row["precio"] . '</p>';
                    echo '<a href="producto.php?id=' . $row["id"] . '" class="btn btn-primary">Ver Producto</a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "0 resultados";
            }

            $conn->close();
            ?>
        </div>
    </div>

    <script src="EXT/jquery-3.7.1.min.js"></script>
    <script src="EXT/popper.min.js"></script>
    <script src="EXT/custom.js"></script>
    <script src="EXT/BOOTSTRAP/js/bootstrap.bundle.min.js"></script>
</body>

</html>