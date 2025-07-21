<?php
require_once("../conexion.php");
session_start();
if (!isset($_SESSION['correo']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../../index.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_empresa = trim($_POST["nombre_empresa"]);
    $telefono = trim($_POST["telefono"]);
    $email = trim($_POST["email"]);

    if (empty($nombre_empresa) || empty($telefono) || empty($email)) {
        $mensaje = "❌ Todos los campos son obligatorios";
    } else {
        $stmt = $conexion->prepare("INSERT INTO proveedores (nombre_empresa, telefono, email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nombre_empresa, $telefono, $email);

        if ($stmt->execute()) {
            $mensaje = "<script>alert('✅ Proveedor agregado correctamente'); window.location.href = './dashboard.php';</script>";
        } else {
            $mensaje = "<script>alert('❌ Error al agregar Proveedor'); window.location.href = './dashboard.php';</script>";
        }

        $stmt->close();
    }

    $conexion->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Proveedor</title>
    <link rel="stylesheet" href="../../css/agregar_proveedor.css">

</head>
<body>

    <button class="btn-volver" onclick="window.location.href='./dashboard.php'">← Volver al panel</button>

    <div class="contenedor">
        <h2>➕ Agregar Proveedor</h2>

        <?php if (isset($mensaje)) echo "<p class='mensaje'>$mensaje</p>"; ?>

        <form method="POST">
            <input type="text" name="nombre_empresa" placeholder="Nombre de la empresa" required>
            <input type="tel" name="telefono" placeholder="Teléfono" required>
            <input type="email" name="email" placeholder="Correo electrónico" required>
            <button type="submit">Guardar</button>
        </form>
    </div>

</body>
</html>
