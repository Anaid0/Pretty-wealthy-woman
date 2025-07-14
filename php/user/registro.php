<?php
require_once("../conexion.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST['nombre'];
    $documento = $_POST['documento'];
    $celular = $_POST['celular'];
    $correo = $_POST['correo'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $rol = "cliente"; 
    $estado = "activo";

    $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, documento, celular, correo, password, rol, estado) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $nombre, $documento, $celular, $correo, $password, $rol, $estado);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Registro exitoso. Ahora puedes iniciar sesión.'); window.location.href = '../../index.php';</script>";
    } else {
        echo "<script>alert('❌ Error al registrar usuario: " . $stmt->error . "');</script>";
    }

    $stmt->close();
    $conexion->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="../../css/registro_usuario.css"> 
</head>
<body>
    <button class="btn-volver" onclick="window.location.href='../../index.php'">← Volver al inicio</button>
    <div class="contenedor">
        <h2>📝 Registro de Usuario</h2>
        <form method="POST" onsubmit="return validarFormulario()">
  <label>Nombre:</label>
  <input type="text" name="nombre" required>

  <label>Documento:</label>
  <input type="text" name="documento" required>

  <label>Celular:</label>
  <input type="text" name="celular" required>

  <label>Correo electrónico:</label>
  <input type="email" name="correo" required>

  <label>Contraseña:</label>
  <div class="campo-password">
    <input type="password" name="contrasena" id="contrasena" required>
    <span class="toggle-password" onclick="togglePassword('contrasena', this)">👁️</span>
  </div>

  <label>Confirmar contraseña:</label>
  <div class="campo-password">
    <input type="password" id="confirmar_contrasena" required>
    <span class="toggle-password" onclick="togglePassword('confirmar_contrasena', this)">👁️</span>
  </div>

  <button type="submit">Registrarme</button>
</form>
    </div>
</body>
<script src="../../js/registro_usuario.js"></script>
</html>
