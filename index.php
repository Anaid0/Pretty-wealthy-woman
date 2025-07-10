<?php require_once("php/conexion.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Pretty Wealthy Woman</title>
<link rel="stylesheet" href="./css/index.css?v=<?php echo time(); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

  <!-- 🔝 Header Sticky -->
  <header class="main-header">
    <div class="container">
      <div class="logo">💖 Pretty Wealthy Woman</div>
      <nav class="nav">
        <a href="#inicio">Inicio</a>
        <a href="catalogo.php">Catálogo</a>
        <a href="#contacto">Contáctanos</a>
        <a href="#historia">Historia</a>
        <a href="#mision">Misión y Visión</a>
        <a href="#quienes">Quiénes Somos</a>
        <a href="./pages/registro.html">Crear cuenta</a>
        <a href="./pages/login.html">Iniciar sesión</a>
      </nav>
    </div>
  </header>

  <!-- 📸 Banner -->
  <section id="inicio" class="hero-banner">
    <img src="assets/img/banner.jpg" alt="Maquillaje Profesional">
    <div class="hero-text">
      <h1>¡Resalta tu belleza!</h1>
      <p>Productos de las mejores marcas para mujeres brillantes ✨</p>
      <a href="#contacto" class="btn">Contáctanos</a>
    </div>
  </section>

  <!-- 🛍 Productos destacados -->
  <section class="productos-destacados">
    <h2>🌟 Nuestros Productos Destacados</h2>
    <div class="productos-grid">
      <?php
      $sql = "SELECT p.nombre, p.descripcion, p.precio, p.imagen, pr.nombre_empresa 
              FROM productos p 
              JOIN proveedores pr ON p.id_proveedor = pr.id 
              WHERE p.activo = 'ACTIVO'
              ORDER BY RAND() LIMIT 4";

      $resultado = $conexion->query($sql);

      if ($resultado->num_rows > 0) {
        while ($producto = $resultado->fetch_assoc()) {
          echo '<div class="producto">';
          echo '<img src="img/' . $producto['imagen'] . '" alt="' . $producto['nombre'] . '">';
          echo '<h3>' . $producto['nombre'] . '</h3>';
          echo '<p>' . $producto['descripcion'] . '</p>';
          echo '<p><strong>Proveedor:</strong> ' . $producto['nombre_empresa'] . '</p>';
          echo '<p><strong>💲' . number_format($producto['precio'], 2) . '</strong></p>';
          echo '<a href="catalogo.php" class="btn">Ver más</a>';
          echo '</div>';
        }
      } else {
        echo '<p>No hay productos disponibles por el momento.</p>';
      }
      ?>
    </div>
  </section>

  <!-- 📝 Tarjetas informativas -->
  <section id="historia" class="card-section">
    <h2>📖 Nuestra Historia</h2>
    <p>Pretty Wealthy Woman nació con el sueño de empoderar a mujeres de todas las edades a través del cuidado personal y la belleza.</p>
  </section>

  <section id="mision" class="card-section">
    <h2>🎯 Misión</h2>
    <p>Brindar productos de alta calidad que fomenten el bienestar, la autoestima y la autenticidad de cada mujer.</p>
  </section>

  <section id="vision" class="card-section">
    <h2>🌟 Visión</h2>
    <p>Convertirnos en la marca líder de cosméticos naturales y empáticos en Latinoamérica.</p>
  </section>

  <section id="quienes" class="card-section">
    <h2>👩‍💼 ¿Quiénes Somos?</h2>
    <p>Somos un grupo de mujeres emprendedoras apasionadas por el bienestar y el desarrollo personal.</p>
  </section>

  <!-- 📬 Contacto -->
  <section id="contacto" class="card-section">
    <h2>📬 Contáctanos</h2>
    <p><strong>WhatsApp:</strong> +57 300 123 4567</p>
    <p><strong>Email:</strong> contacto@prettywealthywoman.com</p>
    <p><strong>Dirección:</strong> Bogotá, Colombia</p>
  </section>

  <!-- 🧾 Footer -->
  <footer>
    <p>&copy; 2025 Pretty Wealthy Woman | Todos los derechos reservados</p>
  </footer>

  <script src="js/index.js"></script>
</body>
</html>
