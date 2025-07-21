<?php
session_start();
require_once("../conexion.php");

if (!isset($_SESSION['correo'])) {
    header("Location: ../../pages/login.html");
    exit();
}

$correo = $_SESSION['correo'];

$stmt = $conexion->prepare("SELECT id_usuario FROM usuarios WHERE correo = ?");
$stmt->bind_param("s", $correo);
$stmt->execute();
$res = $stmt->get_result();
$id_usuario = $res->fetch_assoc()['id_usuario'];

$stmtDel = $conexion->prepare("DELETE FROM carrito WHERE id_usuario = ?");
$stmtDel->bind_param("i", $id_usuario);
$stmtDel->execute();

// Redirigir nuevamente al carrito
header("Location: ver_carrito.php");
exit();
?>
