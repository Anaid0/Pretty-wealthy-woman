<?php
session_start();
require_once("../conexion.php");

if (!isset($_SESSION['correo'])) {
    header("Location: ../pages/login.html");
    exit();
}

$id_producto = $_GET['id'] ?? null;
$correo = $_SESSION['correo'];

$stmt = $conexion->prepare("SELECT id_usuario FROM usuarios WHERE correo = ?");
$stmt->bind_param("s", $correo);
$stmt->execute();
$res = $stmt->get_result();
$user = $res->fetch_assoc();
$id_usuario = $user['id_usuario'] ?? null;

if ($id_producto && $id_usuario) {
    $delete = $conexion->prepare("DELETE FROM carrito WHERE id_usuario = ? AND id_producto = ?");
    $delete->bind_param("ii", $id_usuario, $id_producto);
    $delete->execute();
}

header("Location: ver_carrito.php");
exit();
