<?php
session_start();
include 'conexion.php';

if (isset($_POST['id'])) {
    $productId = $_POST['id'];
    if (!isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] = 1;
    } else {
        $_SESSION['cart'][$productId]++;
    }
}
?>