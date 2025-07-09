<?php
session_start();
require_once '../conexion.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

function subirImagen($file) {
    $carpeta = "../assets/img/";
    $nombre = basename($file["name"]);
    $ruta = $carpeta . $nombre;

    if (move_uploaded_file($file["tmp_name"], $ruta)) {
        return $nombre;
    } else {
        return null;
    }
}

if (isset($_POST['guardar'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $activo = isset($_POST['activo']) ? 1 : 0;

    $imagen = subirImagen($_FILES['imagen']);

    if ($imagen) {
        $sql = "INSERT INTO productos (nombre, descripcion, precio, stock, imagen, activo)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdisi", $nombre, $descripcion, $precio, $stock, $imagen, $activo);
        $stmt->execute();
        header("Location: dashboard.php");
    } else {
        $error = "No se pudo subir la imagen";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Producto | Pretty Wealthy Woman</title>
    <link rel="stylesheet" href="../css/admin.css">
    <script>
        function vistaPrevia(event) {
            const img = document.getElementById("preview");
            img.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>
</head>
<body>
    <h2>Agregar nuevo producto</h2>

    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="nombre" placeholder="Nombre del producto" required>
        <textarea name="descripcion" placeholder="Descripción" required></textarea>
        <input type="number" name="precio" placeholder="Precio" required step="0.01">
        <input type="number" name="stock" placeholder="Stock disponible" required>
        <input type="file" name="imagen" accept="image/*" onchange="vistaPrevia(event)" required>
        <img id="preview" src="" style="width:80px; height:80px; margin-top:10px;"><br>
        <label><input type="checkbox" name="activo" checked> Producto activo</label><br>
        <button class="btn agregar" name="guardar">Guardar Producto</button>
        <a href="dashboard.php" class="btn salir">Cancelar</a>
    </form>
</body>
</html>
