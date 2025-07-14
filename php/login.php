<?php
session_start();
require("./conexion.php");

$correo = $_POST['correo'];
$password = $_POST['password'];

$sql = "SELECT * FROM usuarios WHERE correo = ? AND password = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ss", $correo, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $usuario = $result->fetch_assoc();
    
    $_SESSION['id'] = $usuario['id']; 
    $_SESSION['correo'] = $usuario['correo'];
    $_SESSION['rol'] = $usuario['rol'];

    if ($usuario['rol'] === 'admin') {
        header("Location: ./admin/dashboard.php");
    } else {
        header("Location: ../index.php");
    }
} else {
    echo "<script>alert('❌ Correo o contraseña incorrectos.'); window.location='../pages/login.html';</script>";
}
?>
