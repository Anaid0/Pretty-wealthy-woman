<?php
require_once("../conexion.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
    $rol = $_POST['rol'];

    $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, correo, contrasena, rol) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nombre, $correo, $contrasena, $rol);

    if ($stmt->execute()) {
        echo "Usuario agregado correctamente.";
    } else {
        echo "Error al agregar usuario: " . $stmt->error;
    }

    $conexion->close();
    exit();
}
?>

<h2>Agregar Usuario</h2>
<form method="POST">
    <label>Nombre:</label><br>
    <input type="text" name="nombre" required><br>

    <label>Correo:</label><br>
    <input type="email" name="correo" required><br>

    <label>Contraseña:</label><br>
    <input type="password" name="contrasena" required><br>

    <label>Rol:</label><br>
    <select name="rol" required>
        <option value="admin">Admin</option>
        <option value="cliente">Cliente</option>
    </select><br>

    <button type="submit">Agregar Usuario</button>
</form>
