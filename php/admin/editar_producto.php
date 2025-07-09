<?php
session_start();
require_once '../conexion.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Obtener producto por ID
if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$id = $_GET['id'];
$sql = "SELECT * FROM productos WHERE id_producto = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$producto = $resultado->fetch_assoc();

if (!$producto) {
    echo "Producto no encontrado";
    exit();
}

// Función para subir nueva imagen (si la hay)
function subirImagen($file) {
    $carpeta = "../assets/img/";
    $nombre = basename($file["name"]);
    $ruta = $carpeta . $nombre;
    return move_uploaded_file($file["tmp_name"], $ruta) ? $nombre : null;
}

// Procesar formulario
if (isset($_POST['actualizar'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $activo = isset($_POST['activo']) ? 1 : 0;

    // Si hay imagen nueva
    if ($_FILES['imagen']['name']) {
        $imagen = subirImagen($_FILES['imagen']);
        $sql = "UPDATE productos SET nombre=?, descripcion=?, precio=?, stock=?, imagen=?, activo=? WHERE id_producto=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdisii", $nombre, $descripcion, $precio, $stock, $imagen, $activo, $id);
    } else {
        // No cambia imagen
        $sql = "UPDATE productos SET nombre=?, descripcion=?, precio=?, stock=?, activo=? WHERE id_producto=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdisi", $nombre, $descripcion, $precio, $stock, $activo, $id);
    }

    $stmt->execute();
    header("Location: dashboard.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto | Pretty Wealthy Woman</title>
    <link rel="stylesheet" href="../css/admin.css">
    <script>
        function confirmarEdicion(nombre) {
            return confirm(`¿Estás segura de editar el producto "${nombre}"?`);
        }

        function vistaPrevia(event) {
            const img = document.getElementById("preview");
            img.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>
</head>
<body>
    <h2>✏️ Editar producto: <?php echo htmlspecialchars($producto['nombre']); ?></h2>

    <form method="POST" enctype="multipart/form-data" onsubmit="return confirmarEdicion('<?php echo $producto['nombre']; ?>')">
        <input type="text" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required>
        <textarea name="descripcion" required><?php echo htmlspecialchars($producto['descripcion']); ?></textarea>
        <input type="number" name="precio" value="<?php echo $producto['precio']; ?>" required step="0.01">
        <input type="number" name="stock" value="<?php echo $producto['stock']; ?>" required>
        <input type="file" name="imagen" accept="image/*" onchange="vistaPrevia(event)">
        <img id="preview" src="../assets/img/<?php echo $producto['imagen']; ?>" style="width:80px; height:80px; margin-top:10px;">
        <label><input type="checkbox" name="activo" <?php echo $producto['activo'] ? 'checked' : ''; ?>> Producto activo</label><br>
        <button class="btn editar" name="actualizar">Actualizar producto</button>
        <a href="dashboard.php" class="btn salir">Cancelar</a>
    </form>
</body>
</html>
