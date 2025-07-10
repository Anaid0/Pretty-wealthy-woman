<?php
require_once("../conexion.php");

$id = $_POST['id'];

$sql = "DELETE FROM usuarios WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "Usuario eliminado correctamente.";
} else {
    echo "Error al eliminar usuario: " . $stmt->error;
}

$conexion->close();
?>
