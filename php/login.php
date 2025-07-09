<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Pretty Wealthy Woman</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <h2>🔐 Iniciar Sesión</h2>
    <form method="POST" action="php/login.php">
        <input type="email" name="correo" placeholder="Correo" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Ingresar</button>
    </form>
</body>
</html>

<?php
session_start();
require_once("conexion.php");

$correo = $_POST['correo'];
$password = $_POST['password'];

$sql = "SELECT * FROM usuarios WHERE correo = ? AND password = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ss", $correo, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $usuario = $result->fetch_assoc();
    $_SESSION['correo'] = $usuario['correo'];
    $_SESSION['rol'] = $usuario['rol'];

    if ($usuario['rol'] === 'admin') {
        header("Location: admin/dashboard.php");
    } else {
        header("Location: ../index.php");
    }
} else {
    echo "<script>alert('Correo o contraseña incorrectos.'); window.location='../login.php';</script>";
}
?>

