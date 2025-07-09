<?php
session_start();
if (!isset($_SESSION['correo']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Admin - Pretty Wealthy Woman</title>
    <link rel="stylesheet" href="../../css/estilos.css">
</head>
<body>
    <h1>Panel Administrativo 💼</h1>
    <a href="agregar_producto.php">Agregar Producto</a> |
    <a href="agregar_proveedor.php">Agregar Proveedor</a> |
    <a href="listar_productos.php">Listar Productos</a> |
    <a href="../logout.php">Cerrar sesión</a>
</body>
</html>
