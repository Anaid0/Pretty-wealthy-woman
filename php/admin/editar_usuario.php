<?php
require_once("../conexion.php");
session_start();
if (!isset($_SESSION['correo']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../../index.php");
    exit();
}

$id = $_POST['id_usuario'];
$nombre = $_POST['nombre'];
$documento = $_POST['documento'];
$celular =$_POST['celular'];
$correo = $_POST['correo'];
$rol = $_POST['rol'];

$sql = "UPDATE usuarios SET nombre=?, documento=?, celular=?, correo=?, rol=? WHERE id_usuario=?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ssssss", $nombre, $documento, $celular, $correo, $rol, $id);

if ($stmt->execute()){
    if ($stmt->affected_rows > 0) {
       echo "<script>alert('✅ Usuario actualizado correctamente'); window.location.href = './dashboard.php';</script>";
    } else {
    echo "<script>alert('❌ Error al actualizar Usuario'); window.location.href = './dashboard.php';</script>" . $stmt->error;
}
}
$conexion->close();
?>
