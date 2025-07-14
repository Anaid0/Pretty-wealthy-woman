<?php
require_once("../conexion.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST['nombre'];
    $documento = $_POST['documento'];
    $celular =$_POST['celular'];
    $correo = $_POST['correo'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $rol = $_POST['rol'];

    $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, documento, celular, correo, password, rol) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $nombre, $documento, $celular, $correo, $password, $rol);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Usuario agregado correctamente'); window.location.href = './dashboard.php';</script>";
    } else {
        echo "<script>alert('❌ Error al agregar Usuario'); window.location.href = './dashboard.php';</script>" . $stmt->error;
    }

    $conexion->close();
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Usuario</title>
    <link rel="stylesheet" href="../../css/agregar_proveedor.css">
    <body>
        <button class="btn-volver" onclick="window.location.href='./dashboard.php'">← Volver al panel</button>

    <div class="contenedor"> 
        
    <h2>Agregar Usuario</h2>
    <form method="POST">
    <label>Nombre:</label><br>
    <input type="text" name="nombre" required><br>

    
    <label>Documento:</label><br>
    <input type="text" name="documento" required><br>

    
    <label>Celular:</label><br>
    <input type="number" name="celular" required><br>

    <label>Correo:</label><br>
    <input type="email" name="correo" required><br>

    <label>Contraseña:</label><br>
    <input type="password" name="password" required><br>

    <label>Rol:</label><br>
    <select name="rol" required>
        <option value="admin">Admin</option>
        <option value="cliente">Cliente</option>
    </select><br>

    <button type="submit">Agregar Usuario</button>
</form>
</div>
</body>
</html>

