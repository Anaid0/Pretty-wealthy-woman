<?php
require_once("../conexion.php");

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$rol = $_POST['rol'];

$sql = "UPDATE usuarios SET nombre=?, correo=?, rol=? WHERE id=?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("sssi", $nombre, $correo, $rol, $id);

if ($stmt->execute()) {
    echo "Usuario actualizado correctamente.";
} else {
    echo "Error al actualizar usuario: " . $stmt->error;
}

$conexion->close();
?>
