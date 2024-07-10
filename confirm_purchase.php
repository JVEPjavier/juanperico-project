<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['user_id']) || empty($_SESSION['cart'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user_id'];
$cart = $_SESSION['cart'];
$total = 0;

// Calcular el total de la venta
foreach ($cart as $productId => $quantity) {
    $sql = "SELECT precio FROM producto WHERE id = $productId";
    $result = $conn->query($sql);
    if ($row = $result->fetch_assoc()) {
        $total += $row['precio'] * $quantity;
    }
}

// Insertar la venta
$sql = "INSERT INTO Venta (fechaVenta, totalVenta, id_usuario, id_estado) VALUES (NOW(), $total, $userId, 1)";
if ($conn->query($sql) === TRUE) {
    $ventaId = $conn->insert_id;

    foreach ($cart as $productId => $quantity) {
        $sql = "SELECT precio, Cantidad FROM producto WHERE id = $productId";
        $result = $conn->query($sql);
        if ($row = $result->fetch_assoc()) {
            $precioUnitario = $row['precio'];
            $cantidadActual = $row['Cantidad'];
            
            if ($quantity <= $cantidadActual) {
                // Insertar el detalle de la venta
                $sql = "INSERT INTO DetalleVenta (id_producto, id_venta, precioUnitario, cantidad) VALUES ($productId, $ventaId, $precioUnitario, $quantity)";
                if ($conn->query($sql) === TRUE) {
                    // Actualizar el stock del producto
                    $nuevoStock = $cantidadActual - $quantity;
                    $sql = "UPDATE producto SET Cantidad = $nuevoStock WHERE id = $productId";
                    $conn->query($sql);
                } else {
                    echo "Error al insertar detalle de venta: " . $conn->error;
                }
            } else {
                echo "Stock insuficiente para el producto ID: $productId";
            }
        }
    }

    unset($_SESSION['cart']);
    header("Location: index.php");
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>