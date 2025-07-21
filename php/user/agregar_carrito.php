<?php
session_start();
require_once("../conexion.php");

if (!isset($_SESSION['correo'])) {
    echo "<script>alert('Debes iniciar sesión para agregar productos al carrito.'); window.location.href='../pages/login.html';</script>";
    exit();
}

$correo = $_SESSION['correo'];
$consultaUsuario = $conexion->prepare("SELECT id_usuario FROM usuarios WHERE correo = ?");
$consultaUsuario->bind_param("s", $correo);
$consultaUsuario->execute();
$resultadoUsuario = $consultaUsuario->get_result();
$usuario = $resultadoUsuario->fetch_assoc();
$id_usuario = $usuario['id_usuario'];

$id_producto = $_GET['id'];
$cantidad = $_GET['cantidad'];

// Verificar si ya hay ese producto en el carrito
$verificar = $conexion->prepare("SELECT cantidad FROM carrito WHERE id_usuario = ? AND id_producto = ?");
$verificar->bind_param("ii", $id_usuario, $id_producto);
$verificar->execute();
$resultado = $verificar->get_result();

if ($resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
    $cantidad_actual = $fila['cantidad'];
    $cantidad_total = $cantidad_actual + $cantidad;

    if ($cantidad_total > 12) {
        echo "<script>alert('Producto solamente puede ser adquirido 12 veces por compra.'); window.location.href='../catalogo.php';</script>";
        exit();
    }

    $actualizar = $conexion->prepare("UPDATE carrito SET cantidad = ? WHERE id_usuario = ? AND id_producto = ?");
    $actualizar->bind_param("iii", $cantidad_total, $id_usuario, $id_producto);
    $actualizar->execute();
} else {
    if ($cantidad > 12) {
        echo "<script>alert('Producto solamente puede ser adquirido 12 veces por compra.'); window.location.href='../catalogo.php';</script>";
        exit();
    }

    $insertar = $conexion->prepare("INSERT INTO carrito (id_usuario, id_producto, cantidad) VALUES (?, ?, ?)");
    $insertar->bind_param("iii", $id_usuario, $id_producto, $cantidad);
    $insertar->execute();
}

echo "<script>alert('Producto agregado al carrito.'); window.location.href='../catalogo.php';</script>";
?>
