<?php require_once("php/conexion.php"); ?>
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Pretty Wealthy Woman</title>
<link rel="stylesheet" href="css/index.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="css/menu.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<!-- Header Sticky -->
<header class="menu-header">
  <div class="menu-container">
    <div class="menu-logo">💖 Pretty Wealthy Woman</div>
    <nav class="menu-nav">
      <a class="menu-link" href="#inicio">Inicio</a>
      <a class="menu-link" href="./php/catalogo.php">Catálogo</a>
      <a class="menu-link" href="#contacto">Contáctanos</a>
      <a class="menu-link" href="#historia">Sobre nosotras</a>
      <a class="menu-link" href="./php/user/ver_carrito.php">Carrito</a>

      <?php if (isset($_SESSION['correo'])): ?>
        <a class="menu-link" href="./php/logout.php">Cerrar sesión</a>
      <?php else: ?>
        <a class="menu-link" href="./php/user/registro.php">Crear cuenta</a>
        <a class="menu-link" href="./pages/login.html">Iniciar sesión</a>
      <?php endif; ?>
    </nav>
  </div>
</header>

  <!--  Banner -->
  <section id="inicio" class="hero-banner">
    <img src="img/banner.webp" alt="Maquillaje Profesional">
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
          echo '<img src="' . $producto['imagen'] . '">';
          echo '<h3>' . $producto['nombre'] . '</h3>';
          echo '<p>' . $producto['descripcion'] . '</p>';
          echo '<p><strong>Proveedor:</strong> ' . $producto['nombre_empresa'] . '</p>';
          echo '<p><strong>💲' . number_format($producto['precio'], 2) . '</strong></p>';
          echo '<a href="php/catalogo.php" class="btn">Ver más</a>';
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

  <!-- Clientes potenciales -->
  <section class="formulario-clientes">
    <h2>¿Quieres ser cliente mayorista?</h2>
    <h3>Deja tus datos y te contáctaremos</h3>
  <form action="php/cliente_potencial.php" method="POST">
    <input type="text" name="nombre" placeholder="Tu nombre completo" required>
    <input type="email" name="correo" placeholder="Tu correo electrónico" required>
    <input type="tel" name="telefono" placeholder="Tu teléfono" required>
    <textarea name="mensaje" placeholder="¿En qué estás interesado?" rows="4" required></textarea>
    <button type="submit">📩 Enviar</button>
  </form>
  </section>

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

  <script src="js/index.js"></script>
</body>
</html>
