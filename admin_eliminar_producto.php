<?php
include 'conexion.php';
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 1) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];

$sql = "DELETE FROM producto WHERE id='$id'";

if ($conn->query($sql) === TRUE) {
    header("Location: admin_productos.php");
    exit;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>