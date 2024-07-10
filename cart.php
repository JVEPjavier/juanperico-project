<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$cart = $_SESSION['cart'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="EXT/BOOTSTRAP/css/bootstrap.min.css">
    <style>
        .table th, .table td {
            vertical-align: middle;
            text-align: center;
        }
        .container {
            margin-top: 50px;
        }
        .btn-back {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">Carrito de Compras</h2>
        <?php if (!empty($cart)): ?>
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    foreach ($cart as $productId => $quantity):
                        $sql = "SELECT * FROM producto WHERE id = $productId";
                        $result = $conn->query($sql);
                        if ($row = $result->fetch_assoc()):
                            $subtotal = $row['precio'] * $quantity;
                            $total += $subtotal;
                    ?>
                            <tr>
                                <td><?php echo $row['nombreProducto']; ?></td>
                                <td>$<?php echo $row['precio']; ?></td>
                                <td><?php echo $quantity; ?></td>
                                <td>$<?php echo $subtotal; ?></td>
                            </tr>
                    <?php
                        endif;
                    endforeach;
                    ?>
                    <tr>
                        <td colspan="3" class="text-right"><strong>Total</strong></td>
                        <td><strong>$<?php echo $total; ?></strong></td>
                    </tr>
                </tbody>
            </table>
            <div class="text-center mt-4">
                <a href="index.php" class="btn btn-secondary btn-lg btn-back">Volver al Inicio</a>
                <form action="confirm_purchase.php" method="post" class="d-inline">
                    <button type="submit" class="btn btn-success btn-lg">Confirmar Compra</button>
                </form>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center">
                <strong>El carrito está vacío.</strong>
            </div>
            <div class="text-center mt-4">
                <a href="index.php" class="btn btn-secondary btn-lg">Volver al Inicio</a>
            </div>
        <?php endif; ?>
    </div>

    <script src="EXT/jquery-3.7.1.min.js"></script>
    <script src="EXT/popper.min.js"></script>
    <script src="EXT/BOOTSTRAP/js/bootstrap.bundle.min.js"></script>
</body>