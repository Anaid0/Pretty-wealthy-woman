<?php
require_once("conexion.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST["nombre"]);
    $correo = trim($_POST["correo"]);
    $telefono = trim($_POST["telefono"]);
    $mensaje = trim($_POST["mensaje"]);

    if (empty($nombre) || empty($correo) || empty($telefono) || empty($mensaje)) {
        $respuesta = "❌ Todos los campos obligatorios deben estar completos.";
        header("Location: ../index.php");
        exit();
    }

    $stmt = $conexion->prepare("INSERT INTO clientes_potenciales (nombre, correo, telefono, mensaje) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nombre, $correo, $telefono, $mensaje);

    if ($stmt->execute()) {
        header("Location: ../index.php");
    } else {
        echo "Error al guardar los datos: " . $stmt->error;
    }

    $stmt->close();
    $conexion->close();
}
?>