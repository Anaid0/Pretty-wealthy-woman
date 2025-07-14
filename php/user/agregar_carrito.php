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

$verificar = $conexion->prepare("SELECT * FROM carrito WHERE id_usuario = ? AND id_producto = ?");
$verificar->bind_param("ii", $id_usuario, $id_producto);
$verificar->execute();
$resultado = $verificar->get_result();

if ($resultado->num_rows > 0) {
    $conexion->query("UPDATE carrito SET cantidad = cantidad + $cantidad WHERE id_usuario = $id_usuario AND id_producto = $id_producto");
} else {
    // Insertar nuevo
    $insertar = $conexion->prepare("INSERT INTO carrito (id_usuario, id_producto, cantidad) VALUES (?, ?, ?)");
    $insertar->bind_param("iii", $id_usuario, $id_producto, $cantidad);
    $insertar->execute();
}

echo "<script>alert('Producto agregado al carrito.'); window.location.href='../catalogo.php';</script>";
?>
