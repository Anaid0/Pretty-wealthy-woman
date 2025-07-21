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

$id_producto = $_POST['id_producto'];
$accion = $_POST['accion'];

// Obtener cantidad actual
$consulta = $conexion->prepare("SELECT cantidad FROM carrito WHERE id_usuario = ? AND id_producto = ?");
$consulta->bind_param("ii", $id_usuario, $id_producto);
$consulta->execute();
$resultado = $consulta->get_result();
$cantidadActual = $resultado->fetch_assoc()['cantidad'] ?? 0;

if ($accion === 'sumar') {
    if ($cantidadActual < 12) {
        $sql = "UPDATE carrito SET cantidad = cantidad + 1 WHERE id_usuario = ? AND id_producto = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ii", $id_usuario, $id_producto);
        $stmt->execute();
    } else {
        echo "<script>alert('No puedes agregar más de 12 unidades de este producto.'); window.location.href='ver_carrito.php';</script>";
        exit();
    }
} elseif ($accion === 'restar') {
    if ($cantidadActual > 1) {
        $sql = "UPDATE carrito SET cantidad = cantidad - 1 WHERE id_usuario = ? AND id_producto = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ii", $id_usuario, $id_producto);
        $stmt->execute();
    }
}

header("Location: ver_carrito.php");
exit();
?>
