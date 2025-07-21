<?php
session_start();
require_once("conexion.php");

$productos = $conexion->query("SELECT * FROM productos WHERE activo = 'ACTIVO'");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Catálogo</title>
  <link rel="stylesheet" href="../css/catalogo.css">
  <link rel="stylesheet" href="../css/menu.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body data-logueado="<?= isset($_SESSION['correo']) ? 'true' : 'false' ?>">

<!-- Header Sticky -->
<header class="menu-header">
  <div class="menu-container">
    <div class="menu-logo">💖 Pretty Wealthy Woman</div>
    <nav class="menu-nav">
      <a class="menu-link" href="../index.php#inicio">Inicio</a>
      <a class="menu-link" href="../php/catalogo.php">Catálogo</a>
      <a class="menu-link" href="../index.php#contacto">Contáctanos</a>
      <a class="menu-link" href="../index.php#historia">Sobre nosotras</a>
      <a class="menu-link" href="../php/user/ver_carrito.php">Carrito</a>

      <?php if (isset($_SESSION['correo'])): ?>
        <a class="menu-link" href="../php/logout.php">Cerrar sesión</a>
      <?php else: ?>
        <a class="menu-link" href="../php/user/registro.php">Crear cuenta</a>
        <a class="menu-link" href="../pages/login.html">Iniciar sesión</a>
      <?php endif; ?>
    </nav>
  </div>
</header>

<h2 class="titulo-catalogo">Catálogo de Productos</h2>
<div class="catalogo">
  <?php while ($producto = $productos->fetch_assoc()) : ?>
    <div class="tarjeta-producto">
      <img src="../<?= $producto['imagen'] ?>" alt="<?= $producto['nombre'] ?>">
      <h3><?= $producto['nombre'] ?></h3>
      <p>$<?= number_format($producto['precio'], 0) ?></p>
      <button onclick='mostrarDetalle(<?= json_encode($producto) ?>)'>Ver más</button>
    </div>
  <?php endwhile; ?>
</div>

<!-- Modal de producto -->
<div id="modalProducto" class="modal">
  <div class="modal-contenido">
    <span class="cerrar" onclick="cerrarModal()">&times;</span>
    <img id="modalImagen" src="" alt="" style="max-width:100%;">
    <h2 id="modalNombre"></h2>
    <p id="modalDescripcion"></p>
    <p><strong>Precio:</strong> $<span id="modalPrecio"></span></p>
    <label for="cantidad">Cantidad:</label>
    <input type="number" id="modalCantidad" value="1" min="1" max="12">
    <script>
      document.getElementById('form-compra').addEventListener('submit', function(e) {
      const cantidad = parseInt(document.getElementById('cantidad').value);
       if (cantidad > 12) {
        e.preventDefault();
        alert("Producto solamente puede ser adquirido 12 veces por compra");
    }
});
</script>

    <button onclick="agregarAlCarrito()">🛒 Agregar al carrito</button>
  </div>
</div>

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

<script>
  const estaLogueado = document.body.getAttribute("data-logueado") === "true";
</script>
<script src="../js/catalogo.js"></script>
</body>

</html>