<?php
require_once("../conexion.php");
session_start();
if (!isset($_SESSION['correo']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../../index.php");
    exit();
}

$id = $_POST['id_producto'];
$sql = "DELETE FROM productos WHERE id_producto = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "<script>alert('✅ Producto eliminado correctamente'); window.location.href = './dashboard.php';</script>";
} else {
    echo "<script>alert('❌ Error al eliminar Producto'); window.location.href = './dashboard.php';</script>" . $stmt->error;
}
?>
