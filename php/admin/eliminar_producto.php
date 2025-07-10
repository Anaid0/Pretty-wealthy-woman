<?php
require_once("../conexion.php");

$id = $_POST['id_producto'];
$sql = "DELETE FROM productos WHERE id_producto = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "ok";
} else {
    echo "error: " . $stmt->error;
}
$conexion->close();
?>
