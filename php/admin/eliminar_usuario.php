<?php
require_once("../conexion.php");
session_start();
if (!isset($_SESSION['correo']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../../index.php");
    exit();
}

$id = $_POST['id_usuario'];

$sql = "UPDATE usuarios SET estado='INACTIVO' WHERE id_usuario = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "<script>alert('✅ Usuario eliminado correctamente'); window.location.href = './dashboard.php';</script>";
} else {
    echo "<script>alert('❌ Error al eliminar Usuario'); window.location.href = './dashboard.php';</script>" . $stmt->error;
}

$conexion->close();  
?>
