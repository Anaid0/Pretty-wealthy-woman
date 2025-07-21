<?php
require_once("../conexion.php");
session_start();
if (!isset($_SESSION['correo']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];
    $stock = $_POST["stock"];
    $id_proveedor = $_POST["id_proveedor"];
    $nombreImagenOriginal = $_FILES['imagen']['name'];
    $nombreImagen = str_replace(' ', '_', $nombreImagenOriginal);
    $rutaTemporal = $_FILES['imagen']['tmp_name'];
    $carpetaDestino = '../../img/' . $nombreImagen;
    $rutaParaBaseDeDatos = 'img/' . $nombreImagen;
    move_uploaded_file($_FILES['imagen']['tmp_name'], $carpetaDestino);


    $estado = ($stock > 0) ? "ACTIVO" : "INACTIVO";

    $stmt = $conexion->prepare("INSERT INTO productos (nombre, descripcion, precio, stock, id_proveedor, imagen, activo) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdisss", $nombre, $descripcion, $precio, $stock, $id_proveedor, $rutaParaBaseDeDatos, $estado);

    if ($stmt->execute()) {
        echo "alert('✅ Producto agregado correctamente'); window.location.href = './dashboard.php';";
    } else {
        echo "alert('❌ Error al agregar el producto'); window.location.href = './dashboard.php';";
    }

    $stmt->close();
}
?>

<!-- Formulario para agregar producto -->
<h2>➕ Agregar Producto</h2>
<form method="POST" enctype="multipart/form-data">
    <input type="text" name="nombre" placeholder="Nombre del producto" required>
    <textarea name="descripcion" placeholder="Descripción" required></textarea>
    <input type="number" step="0.01" name="precio" placeholder="Precio" required>
    <input type="number" name="stock" placeholder="Stock" required>

    <label for="id_proveedor">Proveedor:</label>
    <select name="id_proveedor" required>
        <option value="">-- Selecciona un proveedor --</option>
        <?php
        $proveedores = $conexion->query("SELECT id, nombre_empresa FROM proveedores");
        while ($fila = $proveedores->fetch_assoc()) {
            echo "<option value='{$fila['id']}'>{$fila['nombre_empresa']}</option>";
        }
        ?>
    </select>

    <label for="imagen">Imagen:</label>
    <input type="file" name="imagen" accept="image/*" required>

    <button type="submit">Guardar</button>
</form>
