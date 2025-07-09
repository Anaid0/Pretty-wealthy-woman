<?php
$conexion = new mysqli("localhost", "root", "1234", "pretty-wealthy-woman");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>
 