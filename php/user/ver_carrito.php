<?php
session_start();
require_once("../conexion.php");

if (!isset($_SESSION['correo'])) {
    echo "<script>alert('Debes iniciar sesión para ver tu carrito.'); window.location.href='../../pages/login.html';</script>";
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
  <link rel="stylesheet" href="../../css/menu.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<!-- Header Sticky -->
<header class="menu-header">
  <div class="menu-container">
    <div class="menu-logo">💖 Pretty Wealthy Woman</div>
    <nav class="menu-nav">
      <a class="menu-link" href="../../index.php#inicio">Inicio</a>
      <a class="menu-link" href="../catalogo.php">Catálogo</a>
      <a class="menu-link" href="../../index.php#contacto">Contáctanos</a>
      <a class="menu-link" href="../../index.php#historia">Sobre nosotras</a>
      <a class="menu-link" href="#">Carrito</a>

      <?php if (isset($_SESSION['correo'])): ?>
        <a class="menu-link" href="../logout.php">Cerrar sesión</a>
      <?php else: ?>
        <a class="menu-link" href="/user/registro.php">Crear cuenta</a>
        <a class="menu-link" href="../../pages/login.html">Iniciar sesión</a>
      <?php endif; ?>
    </nav>
  </div>
</header>

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
  <td>
    <form action="actualizar_carrito.php" method="POST" class="cantidad-form">
      <input type="hidden" name="id_producto" value="<?= $item['id_producto'] ?>">
      <button type="submit" name="accion" value="restar">➖</button>
      <?= $item['cantidad'] ?>
      <button type="submit" name="accion" value="sumar" min="1" max="12">➕</button>
    </form>
  </td>
  <td>$<?= number_format($total, 0) ?></td>
  <td>
    <a href="eliminar_carrito.php?id=<?= $item['id_producto'] ?>" 
       onclick="return confirm('¿Eliminar este producto del carrito?')">🗑️</a>
  </td>
</tr>
<?php endwhile; ?>
</tbody>

</table>

<?php if ($totalGeneral > 0): ?>
  <form action="vaciar_carrito.php" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas vaciar el carrito?')">
    <button type="submit">🧹 Vaciar carrito</button>
  </form>
 <form action="finalizar_compra.php" method="POST" onsubmit="return confirm('¿Deseas finalizar tu compra?')">
  <button type="submit">🛍️ Finalizar compra</button>
</form>
<?php endif; ?>

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

</html>
