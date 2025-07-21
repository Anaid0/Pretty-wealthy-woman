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
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

<!--  Footer -->
  <footer>
    <p>&copy; 2025 Pretty Wealthy Woman | Todos los derechos reservados</p>
    <div class="redes-sociales">
      <h5>Siguenos en todas nuestra redes sociales para mas promociones, noticias y anuncios:D</h5>
        <a href="https://www.facebook.com/share/1C3Uggm93s/" target="_blank"><i class="fab fa-facebook-f"></i></a>
        <a href="https://www.instagram.com/prettywealthywoman?igsh=MWlieW1xdDB3azh3ZQ==" target="_blank"><i class="fab fa-instagram"></i></a>
        <a href="https://mail.google.com/mail/?view=cm&fs=1&to=prettywealthywoman27@gmail.com" target="_blank"><i class="fas fa-envelope"></i></a>
        <a href="https://www.tiktok.com/@pretty_wealty_woman?_t=ZS-8y7Paa97nnO&_r=1" target="_blank"><i class="fab fa-tiktok"></i></a>
        <a href="https://x.com/dcapoficial?s=21" target="_blank"><i class="fab fa-twitter"></i></a>
    </div>
  </footer>

<script src="../../js/registro_usuario.js"></script>
</html>
