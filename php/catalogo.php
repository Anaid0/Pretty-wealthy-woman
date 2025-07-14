<?php
session_start();
require_once("conexion.php");

$productos = $conexion->query("SELECT * FROM productos WHERE activo = 'ACTIVO'");
?>
<link rel="stylesheet" href="../css/catalogo.css">

<body data-logueado="<?= isset($_SESSION['correo']) ? 'true' : 'false' ?>">
<a href="../index.php" class="btn-volver">← Volver</a>
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
    <input type="number" id="modalCantidad" value="1" min="1">
    <button onclick="agregarAlCarrito()">🛒 Agregar al carrito</button>
  </div>
</div>
</body>

<script>
  const estaLogueado = document.body.getAttribute("data-logueado") === "true";
</script>
<script src="../js/catalogo.js"></script>