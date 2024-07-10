<?php
include 'conexion.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 1) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM proveedor WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: admin_proveedores.php");
    } else {
        header("Location: admin_proveedores.php");
    }

    $stmt->close();
} else {
    header("Location: admin_proveedores.php");
}

$conn->close();
?>