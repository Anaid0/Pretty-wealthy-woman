<?php
session_start();
require_once("../conexion.php");

if (!isset($_SESSION['correo'])) {
    echo "<script>alert('Debes iniciar sesión para ver tu carrito.'); window.location.href='../pages/login.html';</script>";
    exit();
}

$correo = $_SESSION['correo'];
$stmtUsuario = $conexion->prepare("SELECT id_usuario FROM usuarios WHERE correo = ?");
$stmtUsuario->bind_param("s", $correo);
$stmtUsuario->execute();
$resUsuario = $stmtUsuario->get_result();
$usuario = $resUsuario->fetch_assoc();
$id_usuario = $usuario['id_usuario'];

$sql = "SELECT c.id_producto, c.cantidad, p.nombre, p.imagen, p.precio 
        FROM carrito c 
        JOIN productos p ON c.id_producto = p.id_producto 
        WHERE c.id_usuario = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>🛒 Tu carrito</title>
  <link rel="stylesheet" href="../../css/carrito.css">
</head>
<body>

<h2>🛒 Tu Carrito de Compras</h2>
<a href="../catalogo.php" class="btn-volver">← Seguir comprando</a>

<table>
  <thead>
    <tr>
      <th>Producto</th>
      <th>Imagen</th>
      <th>Precio</th>
      <th>Cantidad</th>
      <th>Total</th>
      <th>Acción</th>
    </tr>
  </thead>
  <tbody>
    <?php 
    $totalGeneral = 0;
    while ($item = $resultado->fetch_assoc()) :
      $total = $item['precio'] * $item['cantidad'];
      $totalGeneral += $total;
    ?>
    <tr>
      <td><?= $item['nombre'] ?></td>
      <td><img src="../../<?= $item['imagen'] ?>" width="50"></td>
      <td>$<?= number_format($item['precio'], 0) ?></td>
      <td><?= $item['cantidad'] ?></td>
      <td>$<?= number_format($total, 0) ?></td>
      <td>
        <a href="eliminar_carrito.php?id=<?= $item['id_producto'] ?>" 
           onclick="return confirm('¿Eliminar este producto del carrito?')">🗑️</a>
      </td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<h3>Total a pagar: $<?= number_format($totalGeneral, 0) ?></h3>
<?php if ($totalGeneral > 0): ?>
  <button onclick="alert('🛍️ Compra finalizada (aún sin procesar).')">Finalizar compra</button>
<?php endif; ?>

</body>
</html>
