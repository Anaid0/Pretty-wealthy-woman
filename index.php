<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Pretty Wealthy Woman</title>
  <link rel="stylesheet" href="css/index.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

  <!-- 🔝 Header -->
  <header class="main-header">
    <div class="container">
      <div class="logo">💖 Pretty Wealthy Woman</div>
      <nav class="nav">
        <a href="#">Inicio</a>
        <a href="#">Productos</a>
        <a href="#">Ofertas</a>
        <a href="#">Contacto</a>
        <a href="./pages/login.html">Iniciar sesión</a>
      </nav>
    </div>
  </header>

  <!-- 📸 Banner -->
  <section class="hero-banner">
    <img src="assets/img/banner.jpg" alt="Maquillaje Profesional">
    <div class="hero-text">
      <h1>¡Resalta tu belleza!</h1>
      <p>Productos de las mejores marcas para mujeres brillantes ✨</p>
      <a href="#" class="btn">Contátanos</a>
    </div>
  </section>

  <!-- 💅 Productos activos -->
  <section class="productos-destacados">
    <h2>🌟 Nuestros Productos</h2>
    <div class="productos-grid">
      <?php
      require_once("php/conexion.php");
      $sql = "SELECT p.nombre, p.descripcion, p.precio, p.imagen, pr.nombre_empresa 
              FROM productos p 
              JOIN proveedores pr ON p.id_proveedor = pr.id 
              WHERE p.activo = ACTIVO";

      $resultado = $conexion->query($sql);

      if ($resultado->num_rows > 0) {
        while ($producto = $resultado->fetch_assoc()) {
          echo '<div class="producto">';
          echo '<img src="img/' . $producto['imagen'] . '" alt="' . $producto['nombre'] . '">';
          echo '<h3>' . $producto['nombre'] . '</h3>';
          echo '<p>' . $producto['descripcion'] . '</p>';
          echo '<p><strong>Proveedor:</strong> ' . $producto['nombre_empresa'] . '</p>';
          echo '<p><strong>💲' . number_format($producto['precio'], 2) . '</strong></p>';
          echo '<a href="#" class="btn">Ver más</a>';
          echo '</div>';
        }
      } else {
        echo '<p>No hay productos disponibles por el momento.</p>';
      }
      ?>
    </div>
  </section>

  <footer>
    <p>&copy; 2025 Pretty Wealthy Woman | Todos los derechos reservados</p>
  </footer>

</body>
</html>
