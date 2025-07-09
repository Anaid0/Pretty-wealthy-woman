<?php
session_start();
include('conexion.php');

$correo = $_POST["correo"];
$clave = $_POST["clave"];

if (empty($correo) || empty($clave)) {
    echo "<script>alert('Por favor, complete todos los campos.'); window.history.back();</script>";
    exit();
}

$query = $conexion->prepare("SELECT * FROM usuarios WHERE correo = ? AND clave = ?");
$query->bind_param("ss", $correo, $clave);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();

    $_SESSION['correo'] = $usuario['correo'];
    $_SESSION['rol'] = $usuario['rol'];

    if ($usuario['rol'] === 'admin') {
        header("Location: ../pages/admin/adminHome.html");
    } else {
        header("Location: ../pages/user/home.html");
    }
    exit();
} else {
    echo "<script>alert('Correo o contraseña incorrectos.'); window.history.back();</script>";
}

$query->close();
$conexion->close();
?>
